<?php

namespace App\Http\Controllers\Auth;

use App\Events\AdminActivityLogged;
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

            $logDetails = sprintf(
                'Đăng nhập %s thành công: Email - %s',
                $action == 'admin' ? 'Admin' : 'Client',
                $credentials['email']
            );
    
            event(new AdminActivityLogged(
                Auth::id(), // ID người dùng đăng nhập
                'Đăng nhập',
                $logDetails
            ));

            if ($action == 'admin' && Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
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

            $logDetails = sprintf(
                'Đăng xuất thành công: Email - %s',
                $user->email
            );
    
            event(new AdminActivityLogged(
                $user->id, // ID người dùng đăng xuất
                'Đăng xuất',
                $logDetails
            ));

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
