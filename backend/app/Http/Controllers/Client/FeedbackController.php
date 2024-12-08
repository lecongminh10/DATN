<?php

namespace App\Http\Controllers\Client;

use App\Models\Cart;
use App\Models\Feedback;
use App\Models\WishList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    // public function create()
    // {
    //     // Logic xử lý khi hiển thị form tạo feedback
    //     return view('client.feedbacks.create');

    // }

    public function create()
    {
        $userId = auth()->id();
        $carts = Cart::with(['product', 'productVariant.attributeValues.attribute', 'product.galleries'])
            ->where('user_id', $userId)
            ->get();

        $cartCount = $carts->sum('quantity');
        // Lấy thông tin người dùng đang đăng nhập
        $user = Auth::user();
        $wishlistCount = WishList::where('user_id',$userId)->count();
        // Truyền dữ liệu vào view
        return view('client.feedbacks.create', compact('user','carts', 'cartCount','wishlistCount'));
    }
}