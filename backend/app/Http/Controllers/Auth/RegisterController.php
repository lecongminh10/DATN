<?php

namespace App\Http\Controllers\Auth;

use App\Events\AdminActivityLogged;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function showFormRegister()
    {
        return view('client.auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        $user->permissionsValues()->attach(User::PERMISSION_CLIENT);

        $logDetails = sprintf(
            'Đăng ký tài khoản mới: Tên - %s, Email - %s',
            $user->username,
            $user->email
        );

        event(new AdminActivityLogged(
            $user->id,         
            'Đăng ký',         
            $logDetails       
        ));

        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->intended('/')->with('success', 'Registration successful! You are now logged in.');
    }
    
}
