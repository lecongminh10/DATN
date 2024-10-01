<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Products\ProductController;

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


Route::delete('/products/{id}', [ProductController::class, 'destroy']);
Route::delete('/hardDelete/{id}', [ProductController::class, 'hardDelete'])->name('products.hardDelete');
Route::post('/products/delete-multiple', [ProductController::class, 'deleteMuitpalt']);