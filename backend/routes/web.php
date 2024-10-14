<?php

use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\OrderController;
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

Route::prefix('auth')->group(function(){
    Route::get('admin/login', [LoginController::class, 'showFormLoginAdmin'])->name('admin.login');
    Route::get('/login',[LoginController::class,'showFormLogin'])->name('client.login');
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



Route::middleware('isAdmin')->prefix('admin')->group(function(){
    Route::get('', function () {
        return view('admin.dashboard');
    })->name('admin');

    Route::group(
        [
            'prefix' => 'orders',
            'as' => 'orders.'
        ],
        function () {
            Route::get('list-order', [OrderController::class, 'index'])->name('listOrder');

            Route::get('list-trash-order', [OrderController::class, 'listTrash'])->name('listTrashOrder');

            Route::get('order-detail/{id}', [OrderController::class, 'showOrder'])->name('orderDetail');

            Route::get('order-edit/{code}', [OrderController::class, 'showModalEdit'])->name('orderEdit');
            
            Route::put('update-order/{id}', [OrderController::class, 'updateOrder'])->name('updateOrder');
            
            Route::delete('soft-delete/{id}', [OrderController::class, 'destroy'])->name('soft_delete');
            
            Route::delete('multi-soft-delete', [OrderController::class, 'deleteMuitpalt'])->name('multi_soft_delete');
            
            Route::put('restore/{id}', [OrderController::class, 'restore'])->name('restore');// một cái được rồi đúng khoong  ô thử lại caid
            
            Route::put('restore_selected', [OrderController::class, 'muitpathRestore'])->name('restore_selected');
            
            Route::delete('hard-delete/{id}', [OrderController::class, 'hardDelete'])->name('hard_delete');
            
            Route::delete('multi-hard-delete', [OrderController::class, 'deleteMuitpalt'])->name('multi_hard_delete'); 
        }
    );
});
Route::prefix('/')->group(function(){
    Route::get('', function () {
        return view('client.home');
    })->name('client');
});
