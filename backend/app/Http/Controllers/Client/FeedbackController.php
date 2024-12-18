<?php

namespace App\Http\Controllers\Client;

use App\Models\Cart;
use App\Models\Page;
use App\Models\Feedback;
use App\Models\WishList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function create()
    {
        $userId = auth()->id();
        $carts = Cart::with(['product', 'productVariant.attributeValues.attribute', 'product.galleries'])
            ->where('user_id', $userId)
            ->get();

        $cartCount = $carts->sum('quantity');
        $user = Auth::user();
        $wishlistCount = WishList::where('user_id',$userId)->count();
        $pages = Page::where('is_active', true) ->select('name', 'permalink')->get();
        return view('client.feedbacks.create', compact('pages','user','carts', 'cartCount','wishlistCount'));
    }
}