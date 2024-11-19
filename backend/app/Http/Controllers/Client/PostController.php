<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Blog;

class PostController extends Controller
{
    // Phương thức index để hiển thị danh sách bài viết
    public function index()
    {
        // Lấy 5 bài viết gần đây có trạng thái đã xuất bản
        $posts = Blog::where('is_published', 1)->latest()->take(5)->get();

        return view('client.blogs.index', compact('posts'));
    }



    public function show($id)
    {
        // Lấy bài viết cụ thể
        $post = Blog::where('id', $id)->where('is_published', 1)->firstOrFail();

        // Lấy 5 bài viết gần đây có trạng thái đã xuất bản cho sidebar
        $posts = Blog::where('is_published', 1)->latest()->take(5)->get();

        return view('client.blogs.show', compact('post', 'posts'));
    }

}
