<?php

namespace App\Http\Controllers\Client;

use App\Models\Seo;
use App\Models\Cart;
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
        $data = $this->productService->getById($id)->load(['category', 'variants', 'tags', 'galleries','seos']);
        // Lấy biến thể sản phẩm
        $variants = $this->productVariantService->getProductVariant($id);
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
        $userId = auth()->id();
        $carts  = collect();
        if($userId) {
            $carts = Cart::with(['product', 'productVariant.attributeValues.attribute', 'product.galleries'])
            ->where('user_id', $userId)
            ->get();
        }
        $cartCount = $carts->sum('quantity');
        // dd($meta_title);
        // Lấy các thuộc tính và giá trị
        $attributesWithValues = Attribute::with('attributeValues:id,id_attributes,attribute_value')
            ->select('id', 'attribute_name')
            ->get();
        return view('client.product-detail')->with([
            'data'           => $data,
            'attributes'     => $attributesWithValues,
            'variants'       => $variants,
            'carts'          => $carts,
            'cartCount'      => $cartCount,
            'meta_title'       => $meta_title,
            'meta_description' => $meta_description,
            'meta_keywords'    => $meta_keywords,
        ]);
    }
    public function search(Request $request)
{
    // Lấy từ khóa tìm kiếm và danh mục (nếu có)
    $query = $request->input('q');
    $categoryId = $request->input('cat');

    // Tìm kiếm sản phẩm
    $products = $this->productService->searchProducts($query, $categoryId);


    return view('client.products.search-results', compact('products'));
}
}
