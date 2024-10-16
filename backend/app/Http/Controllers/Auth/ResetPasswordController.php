<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class ResetPasswordController extends Controller
{
    /**
     * Show the form for resetting the password.
     *
     * @param  Request  $request
     * @param  string  $token
     * @return \Illuminate\View\View
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('client.auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reset(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
            'token' => 'required',
        ]);

        // Xác thực thông tin đặt lại mật khẩu
        $response = Password::reset(
            $this->credentials($request), function ($user) use ($request) {
                $user->password = bcrypt($request->password);
                $user->save();
            }
        );

        // Kiểm tra phản hồi
        // return $response == Password::PASSWORD_RESET
        //             ? redirect()->route('client.login')->with('status', trans($response))
        //             : back()->withErrors(['email' => trans($response)]);
        if($response == Password::PASSWORD_RESET){
            return view('client.auth.passwords.auth-success-msg')->with([
                'title' => 'Chúc Mừng',
                'messages' => 'Bạn đã cập nhật mật khẩu thành công vui lòng đăng nhập',
            ]);
        }
        return  back()->withErrors(['email' => trans($response)]);
    }

    /**
     * Get the needed authentication credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only('email', 'password', 'password_confirmation', 'token');
    }
}
