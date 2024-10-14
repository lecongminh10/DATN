<?php

use App\Http\Controllers\AttributeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
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

Route::get('/', function () {
    return view('welcome');
});
// Route::resource('permissions', PermissionController::class);

// Admin
Route::get('/admin', function () {
    return view('admin/dashboard');
});

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.'
], function () {
    Route::get('dashboard', function () {
        return view('admin/dashboard');
    });
    Route::group([
        'prefix' => 'products',
        'as' => 'products.',
    ], function () {
        // CRUD products (list, add, update, detail, delete)=> resful API
        Route::get('/listProduct', [ProductController::class, 'index'])->name('listProduct');
        Route::get('/addProduct', [ProductController::class, 'showAdd'])->name('addProduct');
        Route::post('/addProduct', [ProductController::class, 'store'])->name('addPostProduct');
        Route::get('/showProduct/{id}', [ProductController::class, 'showProduct'])->name('showProduct');
        Route::get('/update-product/{id}', [ProductController::class, 'showUpdate'])->name('updateProduct');
        Route::put('/updateProduct/{id}', [ProductController::class, 'update'])->name('updatePutProduct');
        Route::get('/{id}/variants', [ProductController::class, 'getVariants'])->name('admin.products.getVariants');

        // Route::get('/deleteProduct/{id}', [ProductController::class, 'destroy'])->name('deleteProduct');
    });

    Route::post('/save-attributes', [AttributeController::class, 'saveAttributes']);
});

Route::post('/update-category-parent', [CategoryController::class, 'updateParent']);

Route::get('/client', function () {
    return view('client/home');
});