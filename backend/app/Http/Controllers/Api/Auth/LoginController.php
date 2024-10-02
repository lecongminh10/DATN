<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showFormLogin()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
      
            $credentials = $request->validate([
                'email' => ['required', 'email'], 
                'password' => ['required'],
            ]);    
                if (Auth::attempt($credentials)) {
                    $request->session()->regenerate();

                    if (Auth::user()->isAdmin()) {
                        return redirect()->route('admin');
                    }

                    return redirect()->route('client');
                }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
      
    }


    public function logout()
    {
        Auth::logout();
        \request()->session()->invalidate();
        return redirect('auth.login');
    }
}
