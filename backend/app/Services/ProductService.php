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
        $this->productService = $productService;
    }

    public function getSeachProduct($search, $perPage)
    {
        return $this->productService->getAll($search, $perPage);
    }
    public function getFeaturedProducts()
    {
        return Product::with(['galleries', 'category', 'wishList' ,'variants'])
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->orderByDesc('view')
            ->take(10)
            ->get();
    }

    public function getTopProducts()
    {
        return Product::with(['galleries', 'category', 'wishList' ,'variants'])
            ->orderByDesc('view')
            ->get();
    }
    public function getAllProducts($count, $minprice = null, $maxprice = null)
    {
        $query = Product::with(['galleries', 'category', 'wishList' ,'variants']);

        if (!is_null($minprice) && !is_null($maxprice)) {
            $query->whereBetween('price_regular', [$minprice, $maxprice])
                ->orWhereBetween('price_sale', [$minprice, $maxprice]);
        }

        return $query->paginate($count);
    }

    public function getSaleProducts()
    {
        return Product::with(['galleries', 'category', 'wishList','variants'])
            ->select('*', DB::raw('((price_regular - price_sale) / price_regular) * 100 as discount_percentage'))
            ->orderBy('discount_percentage', 'desc')
            ->take(4)
            ->get();
    }


    public function show_soft_delete($search, $perPage)
    {
        return $this->productService->show_soft_delete($search, $perPage);
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

    // public function topRatedProducts()
    // {
    //     return Product::with(['galleries', 'category','wishList'])
    //     ->orderByDesc('rating')
    //     ->limit(10)
    //     ->get();
    // }

    public function bestSellingProducts()
    {
        return Product::with(['galleries', 'category', 'wishList','variants'])
            ->select('*', DB::raw('((price_regular - price_sale) / price_regular) * 100 as discount_percentage'))
            ->orderBy('discount_percentage', 'desc')
            ->take(10)
            ->get();
    }

    public function buyCountProducts()
    {
        return Product::with(['galleries', 'category', 'wishList' ,'variants'])
            ->whereMonth('created_at', now()->month) 
            ->whereYear('created_at', now()->year)  
            ->orderByDesc('buycount')          
            ->limit(10)
            ->get();
    }


    public function latestProducts()
    {
        $latestProduct = Product::orderByDesc('created_at')->first();

        if (!$latestProduct) {
            return collect();
        }
        $latestMonth = $latestProduct->created_at->month;
        $latestYear = $latestProduct->created_at->year;

        // Lọc sản phẩm theo tháng và năm mới nhất
        return Product::with(['galleries', 'category', 'wishList','variants'])
            ->whereMonth('created_at', $latestMonth) 
            ->whereYear('created_at', $latestYear)  
            ->orderByDesc('id')            
            ->limit(10)              
            ->get();
    }


    public function searchProducts($search, $categoryId = null)
    {
        $query = Product::with(['galleries', 'category', 'wishList','variants']);
        if ($search !== null) {
            $query = $query->where('name', 'like', "%{$search}%");
        }
        if ($categoryId !== null) {
            $query = $query->where('category_id', $categoryId);
        }

        return $query->paginate(10);
    }

    public function ratingProducts()
    {
        return Product::with(['galleries', 'category', 'wishList','variants'])
            ->whereNotNull('rating')
            ->orderByDesc('rating')
            ->limit(10)
            ->get();
    }

    public function filterbyProducts($data)
    {
        return $this->productService->filterbyProducts($data);
    }
}
