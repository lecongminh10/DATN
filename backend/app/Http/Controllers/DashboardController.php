<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Lấy tháng được chọn từ tham số trong yêu cầu (mặc định là tháng hiện tại)
        $selectedMonth = $request->input('month', now()->format('Y-m'));

        // Sản phẩm bán chạy
        $bestSellingProducts = OrderItem::select('order_items.product_id', DB::raw('SUM(order_items.quantity) as total_quantity'))
            ->groupBy('order_items.product_id')
            ->orderByDesc('total_quantity')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->when($selectedMonth, function ($query) use ($selectedMonth) {
                return $query->whereMonth('order_items.created_at', '=', date('m', strtotime($selectedMonth)))
                    ->whereYear('order_items.created_at', '=', date('Y', strtotime($selectedMonth)));
            })
            ->paginate(5, ['products.id', 'products.name', 'products.price', 'products.stock', 'products.created_at']);

        // Nạp mối quan hệ galleries cho mỗi sản phẩm
        $bestSellingProducts->each(function ($item) {
            $item->image_url = $item->product->getMainImage() ? Storage::url($item->product->getMainImage()->image_gallery) : null;
        });

        // Lọc đơn hàng, khách hàng, sản phẩm theo tháng
        $orders = Order::with(['user', 'carrier', 'payment'])
            ->when($selectedMonth, function ($query) use ($selectedMonth) {
                return $query->whereMonth('created_at', '=', date('m', strtotime($selectedMonth)))
                    ->whereYear('created_at', '=', date('Y', strtotime($selectedMonth)));
            })
            ->get();

        $totalOrders = $orders->count();
        $totalOrderPrice = $orders->sum('total_price');
        // Lọc tổng số khách hàng theo tháng
        $totalCustomers = User::when($selectedMonth, function ($query) use ($selectedMonth) {
            return $query->whereMonth('created_at', '=', date('m', strtotime($selectedMonth)))
                ->whereYear('created_at', '=', date('Y', strtotime($selectedMonth)));
        })->count();

        // Lọc tổng số sản phẩm theo tháng
        $totalProducts = Product::when($selectedMonth, function ($query) use ($selectedMonth) {
            return $query->whereMonth('created_at', '=', date('m', strtotime($selectedMonth)))
                ->whereYear('created_at', '=', date('Y', strtotime($selectedMonth)));
        })->count();

        // Doanh thu theo tháng
        $revenueData = Order::selectRaw('MONTH(created_at) as month, SUM(total_price) as total')
            ->groupBy('month')
            ->when($selectedMonth, function ($query) use ($selectedMonth) {
                return $query->whereMonth('created_at', '=', date('m', strtotime($selectedMonth)))
                    ->whereYear('created_at', '=', date('Y', strtotime($selectedMonth)));
            })
            ->pluck('total', 'month')
            ->toArray();

        // Khách hàng theo tháng
        $customerData = User::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->when($selectedMonth, function ($query) use ($selectedMonth) {
                return $query->whereMonth('created_at', '=', date('m', strtotime($selectedMonth)))
                    ->whereYear('created_at', '=', date('Y', strtotime($selectedMonth)));
            })
            ->pluck('total', 'month')
            ->toArray();

        // Tổng số sản phẩm theo tháng
        $productData = Product::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->when($selectedMonth, function ($query) use ($selectedMonth) {
                return $query->whereMonth('created_at', '=', date('m', strtotime($selectedMonth)))
                    ->whereYear('created_at', '=', date('Y', strtotime($selectedMonth)));
            })
            ->pluck('total', 'month')
            ->toArray();

        // Tổng số đơn hàng theo tháng
        $orderData = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->when($selectedMonth, function ($query) use ($selectedMonth) {
                return $query->whereMonth('created_at', '=', date('m', strtotime($selectedMonth)))
                    ->whereYear('created_at', '=', date('Y', strtotime($selectedMonth)));
            })
            ->pluck('total', 'month')
            ->toArray();

        $monthlyRevenue = array_fill(1, 12, 0);
        $monthlyCustomers = array_fill(1, 12, 0);
        $monthlyProducts = array_fill(1, 12, 0);
        $monthlyOrders = array_fill(1, 12, 0);

        foreach ($revenueData as $month => $total) {
            $monthlyRevenue[$month] = $total;
        }

        foreach ($customerData as $month => $total) {
            $monthlyCustomers[$month] = $total;
        }

        foreach ($productData as $month => $total) {
            $monthlyProducts[$month] = $total;
        }

        foreach ($orderData as $month => $total) {
            $monthlyOrders[$month] = $total;
        }

        return view('admin.dashboard', compact(
            'orders',
            'totalOrderPrice',
            'totalOrders',
            'totalCustomers',
            'totalProducts',
            'monthlyRevenue',
            'monthlyCustomers',
            'monthlyProducts',
            'monthlyOrders',
            'bestSellingProducts',
            'selectedMonth' // Truyền tháng đã chọn vào view
        ));
    }
}
