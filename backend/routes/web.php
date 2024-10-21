<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;

use Illuminate\Http\Resources\Json\ResourceCollection;
// use App\Http\Controllers\PermissionController;
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
// admin routes
Route::get('/', function () {
    return view('admin.dashboard');
});
// Route::resource('permissions', PermissionController::class);
Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/', [CategoryController::class, 'store'])->name('categories.store');
    // Route::get('/{category}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('/{category}',         [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::delete('/categories/delete-multiple', [CategoryController::class, 'deleteMultiple'])->name('categories.delete-multiple');
    // Route::delete('/{category}/hard-delete', [CategoryController::class, 'hardDelete'])->name('categories.hard-delete');
    // Route::get('/trashed', [CategoryController::class, 'trashed'])->name('categories.trashed');
    Route::patch('/categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
Route::delete('/categories/{id}/hard-delete', [CategoryController::class, 'hardDelete'])->name('categories.hard-delete');
});
Route::get('/trashed', [CategoryController::class, 'trashed'])->name('categories.trashed');
Route::get('/categories/trashed/search', [CategoryController::class, 'searchTrashed'])->name('categories.trashed.search');
Route::post('/categories/trashed/restore-multiple', [CategoryController::class, 'restoreMultiple'])->name('categories.trashed.restoreMultiple');
Route::post('/categories/trashed/hard-delete-multiple', [CategoryController::class, 'hardDeleteMultiple'])->name('categories.trashed.hardDeleteMultiple');



// client routes
Route::get('/home', function () {
    return view('client.home'); // 'home' là tên của view mà bạn đã tạo

});
// Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::resource('home', HomeController::class);

