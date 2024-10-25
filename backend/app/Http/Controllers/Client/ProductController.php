<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Cart;
use App\Services\AttributeService;
use App\Services\AttributeValueService;
use App\Services\CategoryService;
use App\Services\ProductGalleryService;
use App\Services\ProductService;
use App\Services\ProductVariantService;
use App\Services\TagService;
use Illuminate\Http\Request;

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
        $data = $this->productService->getById($id)->load(['category', 'variants', 'tags', 'galleries']);
        // dd($data);
        $variants = $this->productVariantService->getProductVariant($id);

        $userId = auth()->id();
        $carts  = collect();
        if($userId) {
            $carts = Cart::where('user_id', $userId)->with('product')->get();
        }
        $cartCount = $carts->sum('quantity');

        $attributesWithValues = Attribute::with('attributeValues:id,id_attributes,attribute_value')
            ->select('id', 'attribute_name')
            ->get();
        return view('client.product')->with([
            'data'           => $data,
            'attribute'      => $attributesWithValues,
            'variants'       => $variants,
            'carts'          => $carts,
            'cartCount'      => $cartCount
        ]);
    }
}
