<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /**
     * Hiển thị form yêu cầu đặt lại mật khẩu.
     *
     * @return \Illuminate\View\View
     */
    public function showLinkRequestForm()
    {
        return view('client.auth.passwords.confirm'); 
    }

    /**
     * Gửi email liên kết đặt lại mật khẩu cho người dùng.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ]);
    
        $email = $request->only('email')['email'];
        $cacheKey = 'password_reset_' . $email;

        if (Cache::has($cacheKey)) {
            $expiresAt = Cache::get($cacheKey); 
            $remainingTime = $expiresAt - now()->timestamp;
    
            if ($remainingTime > 0) {
                return back()->withErrors([
                    'email' => 'Vui lòng chờ ' . $remainingTime . ' giây trước khi gửi yêu cầu mới.'
                ]);
            }
        }
    
        // Gửi liên kết đặt lại mật khẩu
        $response = Password::sendResetLink($request->only('email'));
    
        if ($response == Password::RESET_LINK_SENT) {
            // Lưu thời gian hết hạn vào cache với thời hạn 60 giây
            $expiresAt = now()->addSeconds(60)->timestamp;
            Cache::put($cacheKey, $expiresAt, 60);
    
            return back()->with(['status' => trans($response)])
                         ->with('waiting_time', 60); // Đính kèm thời gian chờ vào session
        } else {
            Log::error('Password reset link not sent:', ['response' => $response]);
            return back()->withErrors(['email' => trans($response)]);
        }
    }
    
    
    
}
