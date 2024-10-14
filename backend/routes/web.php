<?php

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
    return view('admin.dashboard');
});
// Route::resource('permissions', PermissionController::class);

// product
Route::prefix('products')->group(function () {

    Route::get('/', [ProductController::class, 'index'])->name('admin.products.index');
    Route::delete('/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
    Route::get('/listSotfDeleted', [ProductController::class, 'showSotfDelete'])->name('admin.products.deleted');
    Route::patch('/restore/{id}', [ProductController::class, 'restore'])->name('admin.products.restore');
    // Xóa cứng 
    Route::delete('/{id}/hard-delete', [ProductController::class, 'hardDeleteProduct'])->name('admin.products.hardDelete');
    // Xóa mềm 
    Route::delete('/values/{id}', [ProductController::class, 'destroyValue'])->name('admin.productValues.destroy');
    // Xóa cứng 
    Route::delete('/values/{id}/hard-delete', [ProductController::class, 'hardDeleteProductValue'])->name('admin.productValues.hardDelete');
    // Xóa nhiều
    Route::post('/delete-multiple', [ProductController::class, 'deleteMuitpalt'])->name('admin.products.deleteMultiple');

});





