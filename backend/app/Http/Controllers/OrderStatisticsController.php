<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderStatisticsController extends Controller
{
    public function index(Request $request)
    {
        // Lấy tháng được chọn từ request (nếu không có, mặc định là tháng hiện tại)
        $selectedMonth = $request->input('month', now()->format('Y-m'));

        // Parse năm và tháng từ chuỗi
        [$year, $month] = explode('-', $selectedMonth);

        // Lọc các đơn hàng theo tháng và năm
        $completedOrders = Order::where('status', Order::HOAN_THANH)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->get();

        $canceledOrders = Order::where('status', Order::DA_HUY)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->get();

        $lostOrders = Order::where('status', Order::HANG_THAT_LAC)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->get();

        // Tính toán dữ liệu thống kê
        $totalOrders = $completedOrders->count();
        $totalEarnings = $completedOrders->sum('total_price') ?: 0;
        $totalCanceledOrders = $canceledOrders->count();
        $totalLostOrders = $lostOrders->count();

        return view('admin.orders.statistics', compact(
            'totalOrders',
            'totalEarnings',
            'totalCanceledOrders',
            'totalLostOrders',
            'selectedMonth'
        ));
    }

    public function completedOrders()
    {
        $completedOrders = Order::where('status', Order::HOAN_THANH)->get();
        return view('admin.orders.completedOrders', compact('completedOrders'));
    }

        public function canceledOrders()
        {
            $canceledOrders = Order::getCanceledOrders();
            return view('admin.orders.canceledOrders', compact('canceledOrders'));
        }
        public function lostOrders()
    {
        $lostOrders = Order::where('status', Order::HANG_THAT_LAC)->get();
        return view('admin.orders.lostOrders', compact('lostOrders'));
    }
}
