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
    public function index(Request $request)
    {
        $selectedMonth = $request->input('month', now()->format('Y-m'));
        $startDate = \Carbon\Carbon::parse($selectedMonth . '-01')->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        $topSellingProducts = OrderItem::select('products.name as name', DB::raw('SUM(order_items.quantity) as value'))
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->whereBetween('order_items.created_at', [$startDate, $endDate])
            ->groupBy('products.name')
            ->orderByDesc('value')
            ->limit(10)
            ->get();
        $mostViewedProducts = Product::select('name', 'view as value')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderByDesc('view')
            ->get();

        $productStockData = Product::select('name', 'stock as value')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $totalSalesData = OrderItem::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(quantity) as total'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $revenueData = Product::select('categories.name as category_name', DB::raw('SUM(price_regular * buycount) as total'))
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->whereBetween('products.created_at', [$startDate, $endDate])
            ->groupBy('categories.name')
            ->get();

        $profitData = Product::select('name', DB::raw('SUM((price_regular - price_sale) * buycount) as total'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('name')
            ->get();

        $productRevenueData = Product::select('name', DB::raw('SUM(price_regular * buycount) as value'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('name')
            ->get();

        $customerFeedback = DB::table('users_reviews')
            ->select('product_id', DB::raw('AVG(rating) as average_rating'))
            ->whereBetween('created_at', [$startDate, $endDate])
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
                        'reviews' => $reviews,
                    ];
                }
                return null;
            })->filter();

        // Tỉ lệ hàng trả lại
        $returnRateData = OrderItem::select(
            'order_items.product_id',
            DB::raw('COUNT(*) as total_orders')
        )
            ->join('refunds', 'order_items.order_id', '=', 'refunds.order_id')
            ->whereBetween('order_items.created_at', [$startDate, $endDate])
            ->groupBy('order_items.product_id')
            ->get()
            ->map(function ($order) {
                $product = Product::find($order->product_id);
                if ($product) {
                    $totalReturns = DB::table('refunds')
                        ->where('product_id', $order->product_id)
                        ->count();

                    return [
                        'name' => $product->name,
                        'value' => $order->total_orders > 0 ? ($totalReturns / $order->total_orders * 100) : 0,
                    ];
                }
                return null;
            })->filter();

        // Xu hướng bán hàng
        $salesTrends = OrderItem::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(quantity) as total'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
        //Tổng sản phẩm ban đầu
        $totalProductStockAndBuycount = Product::select(DB::raw('SUM(stock) + SUM(buycount) as total'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->value('total') ?? 0;
        // Tổng tồn kho
        // Tổng tồn kho
        $totalProductStock = Product::whereBetween('created_at', [$startDate, $endDate])
            ->sum('stock') ?? 0;  // Nếu không có dữ liệu thì trả về 0

        // Tổng bán ra
        $totalProductBuyCount = Product::whereBetween('created_at', [$startDate, $endDate])
            ->sum('buycount') ?? 0;  // Nếu không có dữ liệu thì trả về 0


        $data = collect(compact(
            'salesTrends',
            'returnRateData',
            'customerFeedback',
            'topSellingProducts',
            'mostViewedProducts',
            'productStockData',
            'totalSalesData',
            'revenueData',
            'profitData',
            'productRevenueData',
            'totalProductStock',
            'totalProductBuyCount',
            'totalProductStockAndBuycount'
        ));

        return view('admin.statistics.index', $data->merge(['selectedMonth' => $selectedMonth])->toArray());
    }
}
