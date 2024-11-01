<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderStatisticsController extends Controller
{
    public function index()
    {
      // Lấy tất cả các đơn hàng có trạng thái "Hoàn thành"
    $completedOrders = Order::where('status', Order::HOAN_THANH)->get();

    // Tính tổng số đơn hàng hoàn thành
    $totalOrders = $completedOrders->count();

    // Tính tổng doanh thu từ các đơn hàng hoàn thành
    $totalEarnings = $completedOrders->sum('total_price') ?: 0;

    // Lấy tất cả các đơn hàng có trạng thái "Đã hủy"
    $canceledOrders = Order::where('status', Order::DA_HUY)->get();

    // Tính tổng số đơn hàng đã hủy
    $totalCanceledOrders = $canceledOrders->count();
    
    // Tính tổng doanh thu từ các đơn hàng đã hủy
    $totalCanceledEarnings = $canceledOrders->sum('total_price') ?: 0;

    // Lấy tất cả các đơn hàng có trạng thái "Hàng thất lạc"
    $lostOrders = Order::where('status', Order::HANG_THAT_LAC)->get();

    // Tính tổng số đơn hàng thất lạc
    $totalLostOrders = $lostOrders->count();

    return view('admin.orders.statistics', compact(
        'totalOrders',
        'totalEarnings',
        'totalCanceledOrders',
        'totalCanceledEarnings',
        'totalLostOrders'
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
