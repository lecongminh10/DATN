<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
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
    public function getFeaturedProducts()
    {
        return Product::with(['galleries', 'category'])
            ->orderByDesc('view')
            ->take(10)
            ->get();
    }
    public function getTopProducts()
    {
        return Product::with(['galleries', 'category'])
            ->orderByDesc('view')
            ->get();
    }
    public function getAllProducts($count , $minprice=null, $maxprice=null)
    {
        return Product::with(['galleries', 'category'])
        ->orwhereBetween('price_regular', [$minprice, $maxprice])
        ->orWhereBetween('price_sale', [$minprice, $maxprice])
        ->paginate($count);
    }

    public function getSaleProducts()
    {
        return Product::with(['galleries', 'category'])
            ->select('*', DB::raw('((price_regular - price_sale) / price_regular) * 100 as discount_percentage'))
            ->orderBy('discount_percentage', 'desc')
            ->take(4)
            ->get();
    }


    public function show_soft_delete($search , $perPage)
    {
        return $this->productService->show_soft_delete($search , $perPage);
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
