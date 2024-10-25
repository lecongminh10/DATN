<?php

namespace App\Http\Controllers\Client;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Category;
use App\Services\TagService;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Services\CategoryService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Address;
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
    public function index()
    {
        $userId = auth()->id();
        $carts  = collect();
        if($userId) {
            $carts = Cart::where('user_id', $userId)->with('product')->get();
        }

        $cartCount = $carts->sum('quantity');
        $products = $this->productService->getFeaturedProducts();
       
        return view('client.home', compact('products', 'carts', 'cartCount'));
    }

    public function showProducts(Request  $request)
    {
        $count = $request->input('count', 12);
        $products = $this->productService->getAllProducts($count);
        $sale = $this->productService->getSaleProducts();
        $categories = $this->categoryService->getAll();
        return view('client.products.list', compact('products', 'sale', 'categories'));
    }
    // sắp xếp sản phẩm
    public function sortProducts(Request $request)
    {
        $categories = $this->categoryService->getAll();
        $orderby = $request->input('orderby', 'price-asc');

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

        return view('client.products.list', compact('products', 'categories'));
    }
    // lọc sản phẩm theo danh mục
    public function getByCategory($id)
    {
        $categories = $this->categoryService->getAll();
        $category = Category::with('products')->where('id', $id)->firstOrFail();
        $products = $category->products()->paginate(10);

        return view('client.products.list', compact('products', 'categories'));
    }
    // lọc sản phẩm theo giá
    public function filterByPrice(Request $request)
    {
        $categories = $this->categoryService->getAll();
        $minPrice = $request->input('min', 0);
        $maxPrice = $request->input('max', 100000000);

        $products = Product::whereBetween('price_sale', [$minPrice, $maxPrice])
            ->paginate(10);

        return view('client.products.list', compact('products', 'categories', 'minPrice', 'maxPrice'));
    }
}
