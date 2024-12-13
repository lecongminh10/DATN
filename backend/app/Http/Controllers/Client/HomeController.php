<?php

namespace App\Http\Controllers\Client;

use App\Models\Cart;
use App\Models\Page;
use App\Models\Address;
use App\Models\Product;
use App\Models\Category;
use App\Events\TestEvent;
use App\Services\TagService;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Services\CategoryService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\BannerMain;
use App\Models\WishList;
use App\Services\AttributeValueService;
use App\Services\ProductGalleryService;
use App\Services\ProductVariantService;

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
        $pages = Page::where('is_active', 1)->get();
        $userId = auth()->id();
        $carts  = collect();
        if($userId) {
            $carts = Cart::where('user_id', $userId)->with('product')->get();
        }
        $wishlistCount = WishList::where('user_id',$userId)->count();
        $cartCount = $carts->sum('quantity');
        $products = $this->productService->getFeaturedProducts();
        $topRatedProducts = $this->productService->topRatedProducts();
        $bestSellingProducts = $this->productService->bestSellingProducts();
        $latestProducts = $this->productService->latestProducts();
        $ratingProducts = $this->productService->ratingProducts();
        $categories = $this->getCategoriesForMenu();
        $bannerMain = BannerMain::all();
        return view('client.home', compact('pages','categories','products','topRatedProducts', 'bestSellingProducts', 'latestProducts', 'ratingProducts', 'carts', 'cartCount', 'bannerMain','wishlistCount'));
    }

    public function showProducts(Request  $request)
    {
        $page = Page::where('is_active',1)->get();
        $userId = auth()->id();
        $count = $request->input('count', 12);
        $carts  = collect();
        if($userId) {
            $carts = Cart::where('user_id', $userId)->with('product')->get();
        }
        $cartCount = $carts->sum('quantity');
        $wishlistCount = WishList::where('user_id',$userId)->count();
        $minprice = $request ->input('min');
        $maxprice = $request->input('max');
        $products = $this->productService->getAllProducts($count , $minprice , $maxprice);
        $sale = $this->productService->getSaleProducts();
        $categories = $this->categoryService->getAll();
        return view('client.products.list', compact('page','products', 'sale', 'categories', 'carts', 'cartCount','wishlistCount'));
    }
    // sắp xếp sản phẩm
    public function sortProducts(Request $request)
    {
        $page = Page::where('is_active',1)->get();
        $categories = $this->categoryService->getAll();
        $orderby = $request->input('orderby', 'price-asc');
        $carts  = collect();
        $userId = auth()->id();
        if($userId) {
            $carts = Cart::where('user_id', $userId)->with('product')->get();
        }
        $cartCount = $carts->sum('quantity');
        $wishlistCount = WishList::where('user_id',$userId)->count();
        switch ($orderby) {
            case 'price-asc':
                $products = Product::orderBy('price_regular', 'asc')->paginate(12); // Giá thấp đến cao
                break;

            case 'price-desc':
                $products = Product::orderBy('price_regular', 'desc')->paginate(12); // Giá cao đến thấp
                break;

            case 'hot-promotion':
                $products = Product::with(['galleries', 'category'])
                    ->select('*', DB::raw('((price_regular - price_sale) / price_regular) * 100 as discount_percentage'))
                    ->orderBy('discount_percentage', 'desc')->paginate(12);
                break;

            case 'popularity':
                $products = Product::orderBy('view', 'desc')->paginate(12); // Xem nhiều
                break;

            default:
                $products = Product::paginate(12);
                break;
        }

        return view('client.products.list', compact('page','products', 'categories', 'carts', 'cartCount','wishlistCount'));
    }
    // lọc sản phẩm theo danh mục
    public function getByCategory($id)
    {
        $page = Page::where('is_active',1)->get();
        $categories = $this->categoryService->getAll();
        $carts  = collect();
        $userId = auth()->id();
        if($userId) {
            $carts = Cart::where('user_id', $userId)->with('product')->get();
        }
        $cartCount = $carts->sum('quantity');
        $wishlistCount = WishList::where('user_id',$userId)->count();
        $category = Category::with('products')->where('id', $id)->firstOrFail();
        $products = $category->products()->paginate(12);

        return view('client.products.list', compact('page','products', 'categories', 'carts', 'cartCount','wishlistCount'));
    }
    // lọc sản phẩm theo giá
    public function filterByPrice(Request $request)
    {
        $page = Page::where('is_active',1)->get();
        $categories = $this->categoryService->getAll();
        $carts  = collect();
        $userId = auth()->id();
        if($userId) {
            $carts = Cart::where('user_id', $userId)->with('product')->get();
        }
        $cartCount = $carts->sum('quantity');
        $wishlistCount = WishList::where('user_id',$userId)->count();
        $minPrice = $request->input('min', 0);
        $maxPrice = $request->input('max', 100000000);

        $products = Product::whereBetween('price_sale', [$minPrice, $maxPrice])
            ->paginate(10);

        return view('client.products.list', compact('page','products', 'categories', 'minPrice', 'maxPrice', 'carts', 'cartCount','wishlistCount'));
    }

    public function getCategoriesForMenu()
    {
        $parentCategories = $this->categoryService->getParent()->take(9);
        foreach ($parentCategories as $parent) {
            $parent->children = $this->categoryService->getChildCategories($parent->id);
        }
        return $parentCategories;
    }
    public function show($permalink)
    {
        $page = Page::where('is_active', 1)->get();
        $categories = $this->categoryService->getAll();
        $pages = Page::where('permalink', $permalink)
                    ->where('is_active', 1)
                    ->firstOrFail();
        $userId = auth()->id();
        $wishlistCount = WishList::where('user_id',$userId)->count();
        $carts = $userId ? Cart::where('user_id', $userId)->with('product')->get() : collect();
        $cartCount = $carts->sum('quantity');

        return view('client.pages.show', compact('wishlistCount','page','pages','cartCount', 'categories'));
    }

}
