<?php

use App\Http\Controllers\AttributeController;
use App\Http\Controllers\AttributeValueController;
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

Route::get('/', function () {
    return view('welcome');
});

//Attributes
Route::prefix('attributes')->group(function () {
    Route::get('/',                                     [AttributeController::class, 'index'])->name('admin.attributes.index');
    Route::get('/create',                               [AttributeController::class, 'create'])->name('admin.attributes.create');
    Route::post('/',                                    [AttributeController::class, 'store'])->name('admin.attributes.store');
    Route::get('{id}/edit',                             [AttributeController::class, 'edit'])->name('admin.attributes.edit');
    Route::put('/{id}',                                 [AttributeController::class, 'update'])->name('admin.attributes.update'); // Route để cập nhật thuộc tính
    Route::get('/{id}',                                 [AttributeController::class, 'show'])->name('admin.attributes.show');
    Route::delete('/{id}',                              [AttributeController::class, 'destroy'])->name('admin.attributes.destroy');
    Route::get('/deleted',                              [AttributeController::class, 'showSotfDelete'])->name('admin.attributes.deleted');
    Route::patch('/restore/{id}',                       [AttributeController::class, 'restore'])->name('admin.attributes.restore');
    // Xóa cứng attribute
    Route::delete('/{id}/hard-delete',                  [AttributeController::class, 'hardDeleteAttribute'])->name('admin.attributes.hardDelete');
    // Xóa mềm attribute_value
    Route::delete('/values/{id}',                       [AttributeController::class, 'destroyValue'])->name('admin.attributeValues.destroy');
    // Xóa cứng attribute_value
    Route::delete('/values/{id}/hard-delete',           [AttributeController::class, 'hardDeleteAttributeValue'])->name('admin.attributeValues.hardDelete');
    // Xóa nhiều
    Route::post('/delete-multiple',                     [AttributeController::class, 'deleteMuitpalt'])->name('admin.attributes.deleteMultiple');
});
Route::get('/deleted',                              [AttributeController::class, 'showSotfDelete'])->name('admin.attributes.deleted');
