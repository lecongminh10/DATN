<?php

use App\Http\Controllers\AttributeController;
use App\Http\Controllers\AttributeValueController;
use App\Http\Controllers\CarrierController;
use App\Http\Controllers\CouponController;
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
    Route::get('/listsotfdeleted',                      [AttributeController::class, 'showSotfDelete'])->name('admin.attributes.deleted');
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
Route::get('/attribute/listsotfdeleted',                                  [AttributeController::class, 'showSotfDelete'])->name('admin.attributes.deleted1');


//Carriers
Route::prefix('carriers')->group(function () {
    Route::get('/',                                     [CarrierController::class, 'index'])->name('admin.carriers.index');
    Route::get('/create',                               [CarrierController::class, 'create'])->name('admin.carriers.create');
    Route::post('/',                                    [CarrierController::class, 'store'])->name('admin.carriers.store');
    Route::get('{id}/edit',                             [CarrierController::class, 'edit'])->name('admin.carriers.edit');
    Route::put('/{id}',                                 [CarrierController::class, 'update'])->name('admin.carriers.update');
    Route::patch('/restore/{id}',                       [CarrierController::class, 'restore'])->name('admin.carriers.restore');
    Route::get('/listsotfdeleted',                      [CarrierController::class, 'showSotfDelete'])->name('admin.carriers.deleted');
    // Xóa mềm carrier
    Route::delete('/{id}',                              [CarrierController::class, 'destroyCarrier'])->name('admin.carriers.destroy');
    // Xóa cứng carrier
    Route::delete('/{id}/hard-delete',                  [CarrierController::class, 'hardDeleteCarrier'])->name('admin.carriers.hardDelete');
    // Xóa nhiều
    Route::post('/delete-multiple',                     [CarrierController::class, 'deleteMuitpalt'])->name('admin.carriers.deleteMultiple');
});


//Coupons
Route::prefix('coupons')->group(function () {
    Route::get('/',                                     [CouponController::class, 'index'])->name('admin.coupons.index');
    Route::get('/create',                               [CouponController::class, 'create'])->name('admin.coupons.create');
    Route::post('/',                                    [CouponController::class, 'store'])->name('admin.coupons.store');
    Route::get('/{id}',                                 [CouponController::class, 'show'])->name('admin.coupons.show');
    Route::get('{id}/edit',                             [CouponController::class, 'edit'])->name('admin.coupons.edit');
    Route::put('/{id}',                                 [CouponController::class, 'update'])->name('admin.coupons.update');
    Route::patch('/restore/{id}',                       [CouponController::class, 'restore'])->name('admin.coupons.restore');
    Route::get('/listsotfdeleted',                           [CouponController::class, 'showSotfDelete'])->name('admin.coupons.deleted');
    Route::get('/showsotfdelete/{id}',                 [CouponController::class, 'showSotfDeleteID'])->name('admin.coupons.showsotfdelete');
    // Xóa mềm Coupons
    Route::delete('/{id}',                              [CouponController::class, 'destroyCoupon'])->name('admin.coupons.destroy');
    // Xóa cứng Coupons
    Route::delete('/{id}/hard-delete',                  [CouponController::class, 'hardDeleteCoupon'])->name('admin.coupons.hardDelete');
    // Xóa nhiều
    Route::post('/delete-multiple',                     [CouponController::class, 'deleteMuitpalt'])->name('admin.coupons.deleteMultiple');
});
// Route::get('/listsotfdeleted',                      [CouponController::class, 'showSotfDelete'])->name('admin.coupons.deleted');
