<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('admin.auth.login');
// });
// Route::resource('permissions', PermissionController::class);

Route::prefix('auth')->group(function(){
    Route::get('login', [LoginController::class, 'showFormLogin'])->name('auth.showFormlogin');
    Route::post('login', [LoginController::class, 'login'])->name('auth.login');
    Route::get('logout', [LoginController::class, 'logout'])->name('auth.logout');
    // Route::get('register', [RegisterController::class, 'showFormRegister'])->name('register');
    // Route::post('register', [RegisterController::class, 'register']);

    // Route::get('password/confirm', [ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
    // Route::post('password/confirm', [ConfirmPasswordController::class, 'confirm']);
    // Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    // Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    // Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
    // Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    
    // Route::get('google', [SocialiteController::class, 'redirectToGoogle'])->name('auth.google');
    // Route::get('google/callback', [SocialiteController::class, 'handleGoogleCallback']);
    // Route::get('facebook', [SocialiteController::class, 'redirectToFacebook'])->name('auth.facebook');
    // Route::get('facebook/callback', [SocialiteController::class, 'handleFacebookCallback']);
});

Route::middleware('isAdmin')->prefix('admin')->group(function(){
        Route::get('', function () {
            return view('admin.dashboard');
        })->name('admin');
});
Route::prefix('client')->group(function(){
    Route::get('', function () {
        return view('client.home');
    })->name('client');
});
