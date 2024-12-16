<?php

namespace App\Http\Controllers\Client;

use App\Models\Cart;
use App\Models\Page;
use App\Models\Brand;
use App\Models\Address;
use App\Models\Product;
use App\Models\Category;
use App\Models\WishList;
use App\Events\TestEvent;
use App\Models\Attribute;
use App\Models\BannerLeft;
use App\Models\BannerMain;
use App\Services\TagService;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Services\CategoryService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\AttributeValueService;
use App\Services\ProductGalleryService;
use App\Services\ProductVariantService;
use Illuminate\Queue\Failed\NullFailedJobProvider;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $productService;
    protected $tagService;
    protected $productVariantService;
    protected $productGalleryService;
    protected $categoryService;
    protected $attributeValueService;

    public function __construct(
        ProductService $productService,
        ProductVariantService $productVariantService,
        TagService $tagService,
        ProductGalleryService $productGalleryService,
        CategoryService $categoryService,
        AttributeValueService $attributeValueService,

    ) {
        $this->productService = $productService;
        $this->productVariantService = $productVariantService;
        $this->tagService = $tagService;
        $this->productGalleryService = $productGalleryService;
        $this->categoryService = $categoryService;
        $this->attributeValueService = $attributeValueService;
    }
    public function index(Request $request)
    {
        $brands = Brand::all();
        $bannerLeft = BannerLeft::all();
        $userId = auth()->id();
        $carts = collect();
        if ($userId) {
            $carts = Cart::where('user_id', $userId)->with('product')->get();
        }
        $wishlistCount = WishList::where('user_id', $userId)->count();
        $cartCount = $carts->sum('quantity');
        $products = $this->productService->getFeaturedProducts();

        $latestProducts = $this->productService->latestProducts();
        $buyCountProducts = $this->productService->buyCountProducts();
        $ratingProducts = $this->productService->ratingProducts();
        $categories = $this->getCategoriesForMenu();
        $bannerMain = BannerMain::all();
        $pages = Page::where('is_active', true) ->select('name', 'permalink')->get();
        return view('client.home', compact('brands','bannerLeft','categories', 'products', 'buyCountProducts', 'latestProducts', 'ratingProducts', 'carts', 'cartCount', 'bannerMain', 'wishlistCount' ,'pages'));
    }

    public function showProducts(Request $request)
    {
        $userId = auth()->id();
        $count = $request->input('count', 12);
        $carts = collect();
        if ($userId) {
            $carts = Cart::where('user_id', $userId)->with('product')->get();
        }
        $cartCount = $carts->sum('quantity');
        $wishlistCount = WishList::where('user_id', $userId)->count();
        $minprice = $request->input('min');
        $maxprice = $request->input('max');
        $products = $this->productService->getAllProducts($count, $minprice, $maxprice);
        $sale = $this->productService->getSaleProducts();
        $categories = $this->categoryService->getAll();
        $attributes = Attribute::with('attributeValues')->get();
        $pages = Page::where('is_active', true) ->select('name', 'permalink')->get();
        return view('client.products.list', compact('pages','products', 'sale', 'categories', 'carts', 'cartCount', 'wishlistCount', 'attributes'));
    }
    // sắp xếp sản phẩm
    public function sortProducts(Request $request)
    {
        $categories = $this->categoryService->getAll();
        $orderby = $request->input('orderby', 'price-asc');
        $month = $request->input('month', null);
        $carts = collect();
        $userId = auth()->id();
        if ($userId) {
            $carts = Cart::where('user_id', $userId)->with('product')->get();
        }
        $cartCount = $carts->sum('quantity');
        $wishlistCount = WishList::where('user_id', $userId)->count();
        $attributes = Attribute::with('attributeValues')->get();
        // Query sản phẩm
        $query = Product::query();

        // Lọc theo tháng nếu có
        if ($month) {
            $query->whereMonth('created_at', $month);
        }
        $attributes = Attribute::with('attributeValues')->get();

        // Sắp xếp theo điều kiện
        switch ($orderby) {
            case 'price-asc':
                $query->orderBy('price_regular', 'asc'); // Giá thấp đến cao
                break;

            case 'price-desc':
                $query->orderBy('price_regular', 'desc'); // Giá cao đến thấp
                break;

            case 'hot-promotion':
                $query->with(['galleries', 'category'])
                    ->select('*', DB::raw('((price_regular - price_sale) / price_regular) * 100 as discount_percentage'))
                    ->orderBy('discount_percentage', 'desc');
                break;

            case 'popularity':
                $query->orderBy('view', 'desc'); // Xem nhiều
                break;

            default:
                break;
        }

        $products = $query->paginate(12);

        return view('client.products.list', compact('products', 'categories', 'carts', 'cartCount', 'wishlistCount', 'attributes'));
    }
    // lọc sản phẩm theo danh mục
    public function getByCategory($id)
    {
        $categories = $this->categoryService->getAll();
        $carts  = collect();
        $userId = auth()->id();
        if ($userId) {
            $carts = Cart::where('user_id', $userId)->with('product')->get();
        }
        $cartCount = $carts->sum('quantity');
        $wishlistCount = WishList::where('user_id', $userId)->count();
        $category = Category::with('products')->where('id', $id)->firstOrFail();
        $products = $category->products()->paginate(12);
        $attributes = Attribute::with('attributeValues')->get();

        return view('client.products.list', compact('products', 'categories', 'carts', 'cartCount','wishlistCount', 'attributes'));
    }

    public function filterByProducts(Request $request)
    {
        // Lấy danh sách thuộc tính và giá trị của chúng
        $attributes = Attribute::with('attributeValues')->get();

        $categories = $this->categoryService->getAll();
        $carts  = collect();
        $userId = auth()->id();
        if ($userId) {
            $carts = Cart::where('user_id', $userId)->with('product')->get();
        }
        $cartCount = $carts->sum('quantity');
        $wishlistCount = WishList::where('user_id',$userId)->count();


        // Lấy giá trị min và max từ request
        $minPrice = $request->input('min') != null ? floatval($request->input('min')) : null;
        $maxPrice = $request->input('max') != null ? floatval($request->input('max')) : null;


        //dd($maxPrice);
        $data = [
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
            'attributeValues' => collect($request->input('attributes'))->flatten()->filter()->toArray(), // Lấy danh sách ID của attribute_values

        ];

        // Lọc sản phẩm qua service
        $products = $this->productService->filterbyProducts($data);

        // Format giá
        $minPriceFormatted = $request->input('min') != null ?
            number_format($minPrice, 0, ',', '.') :
            null;
        $maxPriceFormatted = $request->input('max') != null ?
            number_format($maxPrice, 0, ',', '.') :
            null;

        // Trả về view
        return view('client.products.list', compact(
            'products',
            'categories',
            'attributes',
            'minPriceFormatted',
            'maxPriceFormatted',
            'carts',
            'cartCount',
            'wishlistCount'
        ));
    }

    public function getCategoriesForMenu()
    {
        // Lấy tất cả danh mục cha
        $parentCategories = $this->categoryService->getParent()->take(9);
        // Lấy danh mục con cho từng danh mục cha
        foreach ($parentCategories as $parent) {
            // Lấy danh mục con bằng cách sử dụng parent_id của danh mục cha
            $parent->children = $this->categoryService->getChildCategories($parent->id);
        }
        // $attributes = Attribute::with('attributeValues')->get();
        return $parentCategories; // Trả về danh mục cha với danh mục con
    }
}
