<?php

namespace App\Http\Controllers\Api\Products;

use App\Http\Controllers\Controller;
// use App\Models\Product;
use App\Services\ProductGalleryService;
use App\Services\ProductService;
use App\Services\ProductVariantService;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class ProductController extends Controller
{
    protected $productService;
    protected $productVariantService;
    protected $productGalleryService;

    const PATH_UPLOAD = '';

    public function __construct(
        ProductService $productService,
        ProductVariantService $productVariantService,
        ProductGalleryService $productGalleryService
    ) {
        $this->productService = $productService;
        $this->productVariantService = $productVariantService;
        $this->productGalleryService = $productGalleryService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $baseUrl = env('APP_URL') . '/storage';
        $dataProduct = $request->except(['product_variants', 'product_galaries']);

        // Gán giá trị mặc định cho các trường boolean nếu không có
        $dataProduct['is_active']       ??= 0;
        $dataProduct['is_hotdeal']      ??= 0;
        $dataProduct['is_homeview']     ??= 0;
        $dataProduct['is_hotview']      ??= 0;

        // Xử lý slug(tạo slug)
        // $dataProduct['slug'] = Str::slug($dataProduct['name']) . '-' . $dataProduct['code'];
        if (!empty($dataProduct['name']) && !empty($dataProduct['code'])) {
            $dataProduct['slug'] = Str::slug($dataProduct['name']) . '-' . $dataProduct['code'];
        }

        // Xử lý images
        if (isset($dataProduct['images']) && $dataProduct['images'] instanceof UploadedFile) {
            $relativePathProduct = $dataProduct['images']->store(self::PATH_UPLOAD);
            $dataProduct['images'] = $baseUrl . '/' . str_replace('public/', '', $relativePathProduct);
        }

        $dataProductVariantsTmp = $request->product_variants;
        $dataProductVariants = [];

        foreach ($dataProductVariantsTmp as $key => $item) {
            $tmp = explode('-', $key);
            $dataProductVariants[] = [
                'product_attribute_id' => $tmp[1],
                'price_modifier' => $item['price_modifier'],
                'stock' => $item['stock'] ?? 0,
                'sku' => $item['sku'] ?? null,
            ];
        }

        $dataProductGalleries = $request->product_galleries ?: [];
        $product = $this->productService->saveOrUpdate($dataProduct);

        // foreach ($dataProductVariants as $dataProductVariant) {
        //     $dataProductVariant['product_id'] = $product->id;

        // }


        foreach ($dataProductGalleries as $image_gallery) {
            $relativePath = $image_gallery->store(self::PATH_UPLOAD);
            $dataProductGallery = $baseUrl . '/' . str_replace('public/', '', $relativePath);
            $this->productGalleryService->saveOrUpdate([
                'product_id' => $product->id,
                'image_gallery' => $dataProductGallery
            ]);

        }

        //$product = $this->productService->saveOrUpdate($dataProduct);// chưa có service 

        return response()->json([
            'message' => 'Success',
            'product' => $product
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
