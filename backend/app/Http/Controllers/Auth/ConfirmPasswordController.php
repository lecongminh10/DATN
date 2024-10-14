<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ConfirmsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConfirmPasswordController extends Controller
{
   /**
     * Đường dẫn mà người dùng sẽ được chuyển hướng sau khi xác nhận thành công.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Tạo một instance mới của controller.
     *
     * Áp dụng middleware 'auth' để yêu cầu người dùng đã xác thực.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Hiển thị form xác nhận mật khẩu.
     *
     * @return \Illuminate\View\View
     */
    public function showConfirmForm()
    {
        return view('client.auth.passwords.confirm'); // Đường dẫn tới view xác nhận mật khẩu
    }

    /**
     * Xác nhận mật khẩu của người dùng.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirm(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|string',
        ]);

        // Kiểm tra xem mật khẩu có đúng không
        if (!Auth::guard('web')->validate(['email' => $request->user()->email, 'password' => $request->password])) {
            return back()->withErrors([
                'password' => 'Mật khẩu không đúng.',
            ]);
        }

        // Nếu mật khẩu đúng, chuyển hướng đến đường dẫn đã định
        return redirect()->intended($this->redirectTo);
    }
}
