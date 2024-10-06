<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
        public function handle(Request $request, Closure $next): Response
        {
            if (!Auth::check()) {
                return redirect()->route('admin.login');
            }
            if (Auth::user()->isAdmin()) {
                return $next($request); 
            }
            return abort(403, 'Unauthorized action.'); 
        }

    
}
