<?php

namespace App\Http\Controllers\Client;

use App\Models\Seo;
use App\Models\Cart;
use App\Models\WishList;
use App\Models\Attribute;
use App\Services\TagService;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Services\CategoryService;
use App\Services\AttributeService;
use App\Http\Controllers\Controller;
use App\Services\AttributeValueService;
use App\Services\ProductGalleryService;
use App\Services\ProductVariantService;

class ProductController extends Controller
{
    protected $productService;
    protected $tagService;
    protected $productVariantService;
    protected $productGalleryService;
    protected $attributeService;
    protected $attributeValueService;
    protected $categoryService;

    // const PATH_UPLOAD = 'public/products'; => sau mở lại

    public function __construct(
        ProductService $productService,
        ProductVariantService $productVariantService,
        TagService $tagService,
        ProductGalleryService $productGalleryService,
        CategoryService $categoryService,
        AttributeService $attributeService,
        AttributeValueService $attributeValueService,


    ) {
        $this->productService = $productService;
        $this->productVariantService = $productVariantService;
        $this->tagService = $tagService;
        $this->productGalleryService = $productGalleryService;
        $this->categoryService = $categoryService;
        $this->attributeService = $attributeService;
        $this->attributeValueService = $attributeValueService;
    }

    public function showProduct(int $id)
    {
        $data = $this->productService->getById($id)->load(['category', 'variants', 'tags', 'galleries','seos','wishList']);
        // Lấy biến thể sản phẩm
        $variants = $this->productVariantService->getProductVariant($id);
        // $topRatedProducts = $this->productService->topRatedProducts();
        $bestSellingProducts = $this->productService->bestSellingProducts();
        $latestProducts = $this->productService->latestProducts();
        // dd($variants);
        $seo = $data->seos->first();
        if ($seo) {
            $meta_title = $seo->meta_title;
            $meta_description = $seo->meta_description;
            $meta_keywords = $seo->meta_keywords;
        } else {
            $meta_title = 'Default Title';
            $meta_description = 'Default Description';
            $meta_keywords = 'Default Keywords';
        }
        $carts  = collect();
        $userId = auth()->id();
        if($userId) {
            $carts = Cart::where('user_id', $userId)->with('product')->get();
        }
        $cartCount = $carts->sum('quantity');
        $wishlistCount = WishList::where('user_id',$userId)->count();
        // dd($meta_title);
        // Lấy các thuộc tính và giá trị
        $attributesWithValues = Attribute::with('attributeValues:id,id_attributes,attribute_value')
            ->select('id', 'attribute_name')
            ->get();
        $categories = $this->getCategoriesForMenu();
        return view('client.product-detail')->with([
            'data'           => $data,
            'attributes'     => $attributesWithValues,
            'variants'       => $variants,
            'carts'          => $carts,
            'cartCount'      => $cartCount,
            'meta_title'       => $meta_title,
            'meta_description' => $meta_description,
            'meta_keywords'    => $meta_keywords,
            // 'topRatedProducts'=>$topRatedProducts,
            'bestSellingProducts'=>$bestSellingProducts,
            'latestProducts'    =>$latestProducts,
            'categories'     =>$categories,
             'wishlistCount'   =>$wishlistCount,
        ]);
    }
    public function search(Request $request)
    {
        // Lấy từ khóa tìm kiếm và danh mục (nếu có)
        $query = $request->input('q');
        $categoryId = $request->input('cat');

        $carts  = collect();
        $userId = auth()->id();
        if($userId) {
            $carts = Cart::where('user_id', $userId)->with('product')->get();
        }
        $cartCount = $carts->sum('quantity');
        $wishlistCount = WishList::where('user_id',$userId)->count();
        $products = $this->productService->searchProducts($query, $categoryId);
        $categories = $this->getCategoriesForMenu();

        return view('client.products.search-results',
        [
            'carts'          => $carts,
            'cartCount'      => $cartCount,
            'products'       => $products,
            'categories'     =>$categories,
            'wishlistCount'   =>$wishlistCount,
        ]);
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
        return $parentCategories; // Trả về danh mục cha với danh mục con
    }
}
