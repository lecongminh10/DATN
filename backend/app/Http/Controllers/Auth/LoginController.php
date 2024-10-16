<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showFormLoginAdmin()
    {
        return view('admin.auth.login');
    }
    public function showFormLogin()
    {
        return view('client.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'action' => ['required', 'string'], 
        ]);
        $action = $request->input('action');
        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            if ($action == 'admin' && Auth::user()->isAdmin()) {
                return redirect()->route('admin');
            } elseif ($action == 'client'&& !Auth::user()->isAdmin()) {
                return redirect()->route('client');
            }
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
    

    public function logout()
    {
        if (Auth::check()) {
            $user = Auth::user();
            Auth::logout();
            \request()->session()->invalidate();
            if ($user->isAdmin()) {
                return redirect()->route('admin.login');
            } else {
                return redirect()->route('client.login');
            }
        }
        return redirect('/');
    }
    
}
