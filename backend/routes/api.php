<?php

use App\Http\Controllers\Api\Attributes\AttributeController;
use App\Http\Controllers\Api\AttributeValueController;

use App\Http\Controllers\Api\Categories\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Products\ProductController;
use App\Http\Controllers\Api\Users\UserController;
use App\Http\Controllers\Api\PermissionController;

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
    Route::post('/delete-multiple', [ProductController::class, 'deleteMuitpalt'])->name('products.delete-multiple');
});

// users
Route::group(['prefix' => 'api'], function () {
    Route::get('users', [UserController::class, 'index'])->name('index');
    Route::post('users', [UserController::class, 'store'])->name('store');
    Route::get('users/{id}', [UserController::class, 'show'])->name('show');
    Route::put('users/{id}', [UserController::class, 'update'])->name('update');
    Route::delete('users/{id}', [UserController::class, 'destroy'])->name('destroy');
    Route::delete('users/{id}/force', [UserController::class, 'forceDelete'])->name('forceDelete');
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
    Route::delete('/{id}', [AttributeController::class, 'destroy']);
    Route::delete('/values/{id}', [AttributeController::class, 'destroyValue']);
    Route::post('/delete-multiple', [AttributeController::class, 'deleteMultiple']);
    Route::delete('/{id}/soft-delete', [AttributeController::class, 'softDelete']);
    Route::delete('/{id}/hard-delete', [AttributeController::class, 'hardDelete']);

    //AtributeValue
    Route::post('/attribute-value/delete-multiple', [AttributeController::class, 'deleteAttributeValueMultiple']);
    Route::delete('attribute-value/{id}/soft-delete', [AttributeController::class, 'deleteAttributeValueMultiple']);
    Route::delete('attribute-value/{id}/hard-delete', [AttributeController::class, 'hardDeleteAttributeValue']);

});

Route::prefix('permissions')->group(function () {
    Route::get('/', [PermissionController::class, 'index']);
    Route::get('/{id}', [PermissionController::class, 'show']);
    Route::post('/', [PermissionController::class, 'storeOrUpdate']);
    Route::put('/{id}', [PermissionController::class, 'storeOrUpdate']);
    Route::delete('/{id}', [PermissionController::class, 'destroy']); // xóa mềm perrmission
    Route::post('/deleteMutipath',[PermissionController::class,'detroyPermissionValue']); // xóa mềm permission value
    Route::post('/deletePermission/{id}',[PermissionController::class,'deletePermission']); //xóa cứng permission
    Route::post('/deletePervalue',[PermissionController::class,'detroyValuePermission']); // xóa cứng permission value
});