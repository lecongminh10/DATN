<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;


class CheckCartQuantity
{
  /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {

            $userId = Auth::id();
            $cartCount = Cart::where('user_id', $userId)->count();
            if ($cartCount > 0) {
                return $next($request);
            }

            return redirect()->route('client.products');
        }
        return redirect()->route('login')->with('error', 'Please log in to continue.');
    }
    
}
