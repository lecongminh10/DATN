<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Support\Facades\Log;

class SocialiteController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            $this->_registerOrLoginUser($googleUser);
            return redirect()->intended(Auth::user()->isAdmin() ? '/admin' : '/');
        } catch (Exception $e) {
            Log::error('Google login error: ' . $e->getMessage());
            return redirect('/login')->with('error', 'Đã có lỗi xảy ra. Vui lòng thử lại sau.');
        }
    }
    protected function _registerOrLoginUser($data)
    {
        $user = User::where('email', $data->email)
                ->orWhere('google_id', $data->id)
                ->first();
        if (!$user) {
            $uniqueUsername = $this->generateUniqueUsername($data->name);
            $user = new User();
            $user->username = $uniqueUsername;
            $user->email = $data->email;
            $user->password = Hash::make(Str::random(16));
            $user->remember_token = Str::random(60);
            $user->google_id = $data->id;
            try {
                $user->save();
                $user->permissionsValues()->attach(User::PERMISSION_CLIENT);
            } catch (Exception $e) {
                Log::error('Failed to attach permission: ' . $e->getMessage());
            }
        }

        Auth::login($user);
    }
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->stateless()->user();

            $user = User::where('facebook_id', $facebookUser->id)
                        ->orWhere('email', $facebookUser->email)
                        ->first();
            if ($user) {
                Auth::login($user);
                return redirect()->route('client');
            }
            $uniqueUsername = $this->generateUniqueUsername($facebookUser->name);
            $newUser = User::create([
                'username' => $uniqueUsername,
                'email' => $facebookUser->email,
                'facebook_id' => $facebookUser->id,
                'password' => Hash::make(Str::random(16)),
            ]);

            try {
                $newUser->permissionsValues()->attach(User::PERMISSION_CLIENT);
                Log::info('Đã thêm quyền cho người dùng mới với ID: ' . $newUser->id);
            } catch (Exception $e) {
                Log::error('Không thể thêm quyền cho người dùng mới: ' . $e->getMessage());
            }
            Auth::login($newUser);
            return redirect()->intended('dashboard');
        } catch (Exception $e) {
            Log::error('Lỗi khi đăng nhập bằng Facebook:', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ]);
            return redirect('/')->withErrors(['error' => 'Đăng nhập bằng Facebook không thành công: ' . $e->getMessage()]);
        }
    }

    public function redirectToGitHub()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleGitHubCallback()
    {
        try {
            $githubUser = Socialite::driver('github')->stateless()->user();
            $user = User::where('github_id', $githubUser->id)
            ->orWhere('email', $githubUser->email)
            ->first();
            if ($user) {
                Auth::login($user);
                return redirect()->intended('/');
            } 
            $uniqueUsername = $this->generateUniqueUsername($githubUser->nickname);
            $newUser = User::create([
                    'username' => $uniqueUsername,
                    'email' => $githubUser->email,
                    'github_id' => $githubUser->id,
                    'password' => Hash::make(Str::random(16)), // Tạo mật khẩu ngẫu nhiên
                ]);
                try {
                    $newUser->permissionsValues()->attach(User::PERMISSION_CLIENT);
                    Log::info('Đã thêm quyền cho người dùng mới với ID: ' . $newUser->id);
                } catch (Exception $e) {
                    Log::error('Không thể thêm quyền cho người dùng mới: ' . $e->getMessage());
                }
                Auth::login($newUser);
                return redirect()->intended('/');
            
        } catch (Exception $e) {
            Log::error('Lỗi'.$e);
            return redirect('/')->withErrors(['error' => 'Đăng nhập bằng GitHub không thành công: ' . $e->getMessage()]);
        }
    }

    public function redirectToTwitter()
    {
        return Socialite::driver('twitter')->redirect();
    }

    public function handleTwitterCallback()
    {
        try {
            $twitterUser = Socialite::driver('twitter')->user();

            Log::info('User' ,[
                'user'=>$twitterUser
            ]);
            $user = User::where('twitter_id', $twitterUser->id)
                        ->orWhere('email', $twitterUser->email)
                        ->first();

            if ($user) {
                Auth::login($user);
                return redirect()->route('/');
            }

            $newUser = User::create([
                'username' => $this->generateUniqueUsername($twitterUser->name),
                'email' => $twitterUser->email, 
                'twitter_id' => $twitterUser->id,
                'password' => Hash::make(Str::random(16)),
                'profile_picture'=>$twitterUser->avatar
            ]);
            try {
                $newUser->permissionsValues()->attach(User::PERMISSION_CLIENT);
                Log::info('Đã thêm quyền cho người dùng mới với ID: ' . $newUser->id);
            } catch (Exception $e) {
                Log::error('Không thể thêm quyền cho người dùng mới: ' . $e->getMessage());
            }
            Auth::login($newUser);
            return redirect()->intended('/');
        } catch (Exception $e) {
            Log::error('Lỗi khi đăng nhập bằng Twitter:', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ]);
            return redirect('/')->withErrors(['error' => 'Đăng nhập bằng Twitter không thành công: ' . $e->getMessage()]);
        }
    }

    private function generateUniqueUsername($username)
    {
        $baseUsername = Str::slug($username);
        $existingUser = User::where('username', $baseUsername)->first();
        if (!$existingUser) {
            return $baseUsername;
        }
        $counter = 1;
        $newUsername = $baseUsername . $counter;
        while (User::where('username', $newUsername)->exists()) {
            $counter++;
            $newUsername = $baseUsername . $counter;
        }
        return $newUsername;
    }
}
