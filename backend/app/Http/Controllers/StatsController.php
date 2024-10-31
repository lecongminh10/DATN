<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Services\TagService;
use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Services\CouponService;
use App\Services\ProductService;
use App\Services\CategoryService;
use App\Services\AttributeService;
use Illuminate\Support\Facades\DB;
use App\Services\OrderLocationService;
use App\Services\AttributeValueService;
use App\Services\ProductGalleryService;
use App\Services\ProductVariantService;

class StatsController extends Controller
{
    protected $productService;
    protected $tagService;
    protected $productVariantService;
    protected $productGalleryService;
    protected $attributeService;
    protected $attributeValueService;
    protected $categoryService;

    protected $couponService;

    protected $orderService;
    protected $orderLocationService;

    // const PATH_UPLOAD = 'public/products'; => sau mở lại

    public function __construct(
        ProductService $productService,
        ProductVariantService $productVariantService,
        TagService $tagService,
        ProductGalleryService $productGalleryService,
        CategoryService $categoryService,
        AttributeService $attributeService,
        AttributeValueService $attributeValueService,
        CouponService $couponService,
        OrderService $orderService,
        OrderLocationService $orderLocationService,
    ) {
        $this->productService = $productService;
        $this->productVariantService = $productVariantService;
        $this->tagService = $tagService;
        $this->productGalleryService = $productGalleryService;
        $this->categoryService = $categoryService;
        $this->attributeService = $attributeService;
        $this->attributeValueService = $attributeValueService;
        $this->couponService = $couponService;
        $this->orderService = $orderService;
        $this->orderLocationService = $orderLocationService;
    }
    public function index()
    {
        //top  sản phẩm bán chạy
        $topSellingProducts = Product::select('name', 'buycount as value')
            ->orderBy('buycount')
            ->get();
        //top sản phẩm view
        $mostViewedProducts = Product::select('name', 'view as value')->get();

        // số  lượng sản phẩm
        $lowStockThreshold = 10;
        $allProducts = Product::select('name', 'stock as value')->get();
        $lowStockProducts = $allProducts->map(function ($product) {
            return [
                'name' => $product->name,
                'value' => $product->value,
            ];
        });
        //  Tổng số lượng sản phẩm bán ra theo ngày
        $totalSalesData = OrderItem::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(quantity) as total'))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
        // doanh thu theo danh mục
        $revenueData = Product::select('categories.name as category_name', DB::raw('SUM(price_regular * buycount) as total'))
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->groupBy('categories.name')
            ->get();
        // doanh thu theo từng sản phẩm
        $profitData = Product::select('name', DB::raw('SUM(price_regular * buycount) as value'))
            ->groupBy('name')->get();
        // lợi nhuận theo từng sản phẩm
        $productRevenueData = Product::select('name', DB::raw('SUM((price_regular - price_sale) * buycount) as total'))
            ->groupBy('name')->get();
        // đánh giá khách hàng
        $customerFeedback = DB::table('users_reviews')
            ->select('product_id', DB::raw('AVG(rating) as average_rating'))
            ->groupBy('product_id')
            ->get()
            ->map(function ($feedback) {
                $product = DB::table('products')->where('id', $feedback->product_id)->first();
                $reviews = DB::table('users_reviews')
                    ->where('product_id', $feedback->product_id)
                    ->select('review_text', 'rating')
                    ->get();

                if ($product) {
                    return [
                        'name' => $product->name,
                        'value' => $feedback->average_rating,
                        'reviews' => $reviews
                    ];
                }
                return null;
            })->filter();
        // tỉ lệ trả hàng
        $returnRateData = OrderItem::select(
            'order_items.product_id',
            DB::raw('COUNT(*) as total_orders')
        )
            ->join('refunds', 'order_items.order_id', '=', 'refunds.order_id')
            ->groupBy('order_items.product_id')
            ->get()
            ->map(function ($order) {
                $product = Product::find($order->product_id);
                // tính số lượng hàng trả lại
                if ($product) {
                    $totalReturns = DB::table('refunds')
                        ->where('product_id', $order->product_id)
                        ->count();

                    return [
                        'name' => $product->name,
                        'value' => $order->total_orders > 0 ? ($totalReturns / $order->total_orders * 100) : 0
                    ];
                }
                return null;
            })->filter();

        $salesTrends = OrderItem::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(quantity) as total'))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $data = collect(compact('salesTrends','returnRateData', 'customerFeedback', 'allProducts', 'topSellingProducts', 'mostViewedProducts', 'lowStockProducts', 'totalSalesData', 'revenueData', 'profitData', 'productRevenueData'));
        return view('admin.statistics.index', $data->toArray());
    }
}
