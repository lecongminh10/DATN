<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\ProductRepository;

class ProductService extends BaseService
{
    protected $productService;

    // Làm việc với controller, lấy dữ liệu từ response

    public function __construct(ProductRepository $productService)
    {
        parent::__construct($productService);
        $this ->productService = $productService;
    }

    public function getSeachProduct($search, $perPage)
    {
        return $this->productService->getAll($search, $perPage);
    }

    public function isProductSoftDeleted(int $id): bool
    {
        return $this->productService->isSoftDeleted($id); // Gọi phương thức kiểm tra trong repository
    }

    public function getIdWithTrashed(int $id)
    {
        return $this->productService->getByIdWithTrashed($id); 
    }

    // public function deleteProduct(Product $product)
    // {
    //     return $this->productService->deleteProductWithRelations($product);
    // }

    // public function saveOrUpdate(array $dataProduct, array $productVariants = [], array $galleryPaths = []){
    //     $product = Product::updateOrCreate(['id' => $dataProduct['id'] ?? null], $dataProduct);

    //     foreach($productVariants as $variants){
    //         $product->variants()->updateOrCreate(['product_attribute_id' => $variants['product_attribute_id']], $variants);
    //     }

    //     foreach($galleryPaths as $path){
    //         $product->galleries()->create(['image' => $path]);
    //     }
    // }
}
