<?php

namespace App\Http\Controllers\Client;

use App\Models\Blog;
use App\Models\Cart;
use App\Http\Controllers\Controller;
use App\Models\Tag;
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
        $carts  = collect();
        $cartCount = $carts->sum('quantity');
        $tags = Tag::all();
        return view('client.blogs.index', compact('posts', 'carts', 'cartCount', 'tags')); {

        }

    }





    public function show($id)
    {
        // Lấy bài viết cụ thể
        $post = Blog::where('id', $id)->where('is_published', 1)->firstOrFail();

        // Lấy 5 bài viết gần đây có trạng thái đã xuất bản cho sidebar
        $posts = Blog::where('is_published', 1)->latest()->take(5)->get();

        return view('client.blogs.show', compact('post', 'posts'));
    }

    // app/Http/Controllers/BlogController.php

    public function showTagPosts($id)
    {
        // Lấy tag theo ID
        $tag = Tag::findOrFail($id);

        // Lấy các bài viết liên quan đến tag này
        $posts = $tag->posts;  // Giả sử có mối quan hệ 'posts' trong mô hình Tag

        // Trả về view 'tag.blade.php' kèm theo dữ liệu
        return view('client.blogs.tag', compact('tag', 'posts'));
    }





}
