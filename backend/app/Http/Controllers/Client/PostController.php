<?php

namespace App\Http\Controllers\Client;

use App\Models\Blog;
use App\Models\Cart;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $carts = Cart::with(['product', 'productVariant.attributeValues.attribute', 'product.galleries'])
            ->where('user_id', $userId)
            ->get();

        $cartCount = $carts->sum('quantity');
        $user = Auth::user();
        $posts = Blog::where('is_published', 1)->latest()->take(5)->get();
        $categories = Category::with('children')->whereNull('parent_id')->get();
        return view('client.blogs.index', compact('posts', 'categories', 'carts', 'cartCount'));
    }



    public function show($id)
    {
        // Lấy bài viết cụ thể
        $post = Blog::where('id', $id)->where('is_published', 1)->firstOrFail();

        // Lấy 5 bài viết gần đây có trạng thái đã xuất bản cho sidebar
        $posts = Blog::where('is_published', 1)->latest()->take(5)->get();
        $userId = auth()->id();
        $carts  = collect();
        if ($userId) {
            $carts = Cart::where('user_id', $userId)->with('product')->get();
        }

        $cartCount = $carts->sum('quantity');

        return view('client.blogs.show', compact('post', 'posts', 'cartCount'));
    }

}
