<?php

use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\Mail;
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
//     return view('client.');
// });
// Route::resource('permissions', PermissionController::class);

Route::prefix('auth')->group(function () {
    Route::get('admin/login', [LoginController::class, 'showFormLoginAdmin'])->name('admin.login');
    Route::get('/login', [LoginController::class, 'showFormLogin'])->name('client.login');
    Route::post('login', [LoginController::class, 'login'])->name('auth.login');
    Route::get('logout', [LoginController::class, 'logout'])->name('auth.logout');
    Route::get('register', [RegisterController::class, 'showFormRegister'])->name('show.register');
    Route::post('register', [RegisterController::class, 'register'])->name('register');

    // Route::get('password/confirm', [ConfirmPasswordController::class, 'showConfirmForm'])->name('password.showconfirm');
    // Route::post('password/confirm', [ConfirmPasswordController::class, 'confirm'])->name('password.confirm');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');

    Route::get('google', [SocialiteController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('google/callback', [SocialiteController::class, 'handleGoogleCallback']);

    Route::get('facebook', [SocialiteController::class, 'redirectToFacebook'])->name('auth.facebook');
    Route::get('facebook/callback', [SocialiteController::class, 'handleFacebookCallback']);

    Route::get('github', [SocialiteController::class, 'redirectToGitHub'])->name('auth.github');
    Route::get('github/callback', [SocialiteController::class, 'handleGitHubCallback']);

    Route::get('twitter', [SocialiteController::class, 'redirectToTwitter'])->name('auth.twitter');
    Route::get('twitter/callback', [SocialiteController::class, 'handleTwitterCallback']);
});

Route::prefix('/permissions')->name('permissions.')->group(function () {
    Route::get('/', [PermissionController::class, 'index'])->name('index');
    Route::get('/create', [PermissionController::class, 'create'])->name('create');
    Route::get('/{id}', [PermissionController::class, 'show'])->name('show');
    Route::post('/', [PermissionController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [PermissionController::class, 'edit'])->name('edit');
    Route::put('/{id}', [PermissionController::class, 'update'])->name('update');



    // Sử dụng DELETE cho việc xóa mềm và xóa cứng
    Route::delete('/{id}', [PermissionController::class, 'destroyPermission'])->name('destroyPermission');
    Route::delete('/{id}/hard', [PermissionController::class, 'destroyPermissionHard'])->name('destroyPermissionHard');

    Route::delete('/{id}/value', [PermissionController::class, 'destroyPermissionValue'])->name('destroyPermissionValue');
    Route::delete('/{id}/value/hard', [PermissionController::class, 'destroyPermissionValueHard'])->name('destroyPermissionValueHard');

    Route::post('/destroy-multiple', [PermissionController::class, 'destroyMultiple'])->name('destroyMultiple');
    Route::post('/values/destroy-multiple', [PermissionController::class, 'destroyMultipleValues'])->name('destroyMultipleValues');
});



Route::middleware('isAdmin')->prefix('admin')->group(function () {
    Route::get('', function () {
        return view('admin.dashboard');
    })->name('admin');
});
Route::prefix('/')->group(function () {
    Route::get('', function () {
        return view('client.home');
    })->name('client');
});
