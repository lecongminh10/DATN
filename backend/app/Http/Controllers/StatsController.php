<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatsController extends Controller
{
    // Lấy số lượng sản phẩm bán ra
    public function index()
    {
        $totalSales = Product::selectRaw('DATE(created_at) as date, COUNT(*) as sales_count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // $revenueByTime = Order::selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue')
        //     ->groupBy('date')
        //     ->orderBy('date')
        //     ->get();

        $bestSellingProducts = Product::withCount('orders')
            ->orderBy('orders_count', 'desc')
            ->limit(10)
            ->get();

        $inventoryStatus = Product::select('id', 'name', 'stock')
            ->where('stock', '<', 10)
            ->get();

        // $returnRate = Order::where('is_returned', true)->count() / Order::count() * 100;

        $profit = Product::selectRaw('id, name, (sale_price - cost_price) as profit')->get();

        return view('admin.statistical.index', compact('totalSales', 'revenueByTime', 'bestSellingProducts', 'inventoryStatus', 'returnRate', 'profit'));
    }
}
