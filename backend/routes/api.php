<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Products\ProductController;
use App\Http\Controllers\Api\Users\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/products', [ProductController::class, 'store'])->name('store');



// users
Route::get('users', [UserController::class, 'index'])->name('index');
Route::post('users', [UserController::class, 'store'])->name('store');
Route::get('users/{id}', [UserController::class, 'show'])->name('show');
Route::put('users/{id}', [UserController::class, 'update'])->name('update');
Route::delete('users/{id}', [UserController::class, 'destroy'])->name('destroy');
Route::delete('users/{id}/force', [UserController::class, 'forceDelete'])->name('forceDelete');