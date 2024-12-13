<?php

namespace App\Http\Controllers\Client;

use App\Models\Tag;
use App\Models\Blog;
use App\Models\Cart;
use App\Models\Page;
use App\Models\Category;
use App\Models\WishList;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {

        $page = Page::where('is_active', 1)->get();
        $userId = auth()->id();
        $carts = Cart::with(['product', 'productVariant.attributeValues.attribute', 'product.galleries'])
            ->where('user_id', $userId)
            ->get();

        $cartCount = $carts->sum('quantity');
        $user = Auth::user();
        $posts = Blog::where('is_published', 1)->latest()->take(5)->get();
        $carts  = collect();
        $tags = Tag::all();
        $categories = Category::with('children')->whereNull('parent_id')->get();
        $wishlistCount = WishList::where('user_id',$userId)->count();
        return view('client.blogs.index', compact('page','posts', 'categories','carts', 'cartCount', 'tags','wishlistCount'));
    }





    public function show($id)
    {
        // Lấy bài viết cụ thể
        $post = Blog::where('id', $id)->where('is_published', 1)->firstOrFail();

        // Lấy 5 bài viết gần đây có trạng thái đã xuất bản cho sidebar
        $posts = Blog::where('is_published', 1)->latest()->take(5)->get();
        $this->countCartWish();

        $userId = auth()->id();
        $carts = Cart::with(['product', 'productVariant.attributeValues.attribute', 'product.galleries'])
            ->where('user_id', $userId)
            ->get();

        $cartCount = $carts->sum('quantity');
        $wishlistCount = WishList::where('user_id',$userId)->count();

        return view('client.blogs.show', compact('post', 'posts', 'cartCount','wishlistCount'));
    }

    // app/Http/Controllers/BlogController.php

    public function showTagPosts($id)
    {
        // Lấy tag theo ID
        $tag = Tag::findOrFail($id);

        // Lấy các bài viết liên quan đến tag này
        $posts = $tag->posts;  // Giả sử có mối quan hệ 'posts' trong mô hình Tag
        $this->countCartWish();
        // Trả về view 'tag.blade.php' kèm theo dữ liệu
        return view('client.blogs.tag', compact('tag', 'posts', 'cartCount','wishlistCount'));
    }

    private function countCartWish()
    {
        $userId = auth()->id();
        $carts  = collect();
        if($userId) {
            $carts = Cart::where('user_id', $userId)->with('product')->get();
        }
        $cartCount = $carts->sum('quantity');
        $wishlistCount = WishList::where('user_id',$userId)->count();
    }
}
