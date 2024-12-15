<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryStatisticsController extends Controller
{
    public function index()
    {
        // Lấy danh sách danh mục với số lượng sản phẩm trong mỗi danh mục
        $categories = Category::withCount('products')->where('is_active', true)->get();

        // Trả về view 'admin.statistics.categories'
        return view('admin.statistics.category', compact('categories'));
    }
}
