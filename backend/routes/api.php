<?php

use App\Http\Controllers\AttributeController;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;

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

// Products
Route::prefix('products')->group(function () {
    Route::get('/list-product', [ProductController::class, 'index'])->name('index');
    Route::get('/{id}', [ProductController::class, 'showProduct'])->name('products.show');
    Route::post('/add-products', [ProductController::class, 'store'])->name('store');
    Route::put('/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/{id}',[ProductController::class, 'destroy'])->name('products.destroy');
    Route::delete('/hardDelete/{id}',[ProductController::class, 'hardDelete'])->name('products.hardDelete');
    Route::post('/delete-multiple', [ProductController::class, 'deleteMuitpalt'])->name('products.delete-multiple');
});

// Users
Route::prefix('users')->group( function () {
    Route::get('/',                         [UserController::class, 'index'])->name('users.index');
    Route::post('/',                        [UserController::class, 'store'])->name('users.store');
    Route::get('/{id}',                     [UserController::class, 'show'])->name('users.show');
    Route::put('/{id}',                     [UserController::class, 'update'])->name('users.update');
    Route::delete('/{id}',                  [UserController::class, 'destroy'])->name('users.destroy');// xóa mềm
    Route::delete('/{id}/hardDelete',       [UserController::class, 'hardDelete'])->name('users.hardDelete');// xóa cứng
    Route::post('/delete-multiple',         [UserController::class, 'deleteMuitpalt'])->name('users.delete-multiple');
});

// categories
Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/{category}', [CategoryController::class, 'show'])->name('categories.show');
    Route::put('/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::post('/delete-multiple', [CategoryController::class, 'deleteMuitpalt'])->name('categories.delete-multiple'); // xóa mềm nhiều id cùng một lúc
    Route::delete('/{category}/hard-delete', [CategoryController::class, 'hardDelete'])->name('categories.hard-delete');
});
//Attributes
Route::prefix('attributes')->group(function () {
    Route::get('/', [AttributeController::class, 'index']);
    Route::get('/{id}', [AttributeController::class, 'show']);
    Route::post('/', [AttributeController::class, 'store']);
    Route::put('/{id}', [AttributeController::class, 'update']);
    Route::delete('/{id}', [AttributeController::class, 'destroy']);//Xóa mềm attribute
    Route::delete('/{id}/hardDeleteAttributes',[AttributeController::class, 'hardDeleteAttribute']);//Xóa cứng attribute
    Route::delete('/values/{id}', [AttributeController::class, 'destroyValue']);// xóa mềm attribute_value
    Route::delete('/values/{id}/hardDeleteAttributes',[AttributeController::class, 'hardDeleteAttributeValue']);
    Route::post('/delete-multiple', [AttributeController::class, 'deleteMuitpalt']);// Xóa nhiều 
});

Route::prefix('permissions')->group(function () {
    Route::get('/', [PermissionController::class, 'index']);
    Route::get('/{id}', [PermissionController::class, 'show']);
    Route::post('/', [PermissionController::class, 'storeOrUpdate']);
    Route::put('/{id}', [PermissionController::class, 'storeOrUpdate']);
    Route::delete('/{id}', [PermissionController::class, 'destroyPermission']); // xóa mềm perrmission
    Route::delete('/values/{id}',[PermissionController::class,'destroyPermissionValue']); // xóa mềm permission value
    Route::delete('/deletePermission/{id}',[PermissionController::class,'destroyPermissionHard']); //xóa cứng permission
    Route::delete('/values-hard/{id}',[PermissionController::class,'destroyPermissionValueHard']); // xóa cứng permission value
    Route::post('/deleteMutipath',[PermissionController::class,'deleteMuitpalt']);
});