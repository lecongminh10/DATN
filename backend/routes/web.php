<?php


use App\Http\Controllers\AttributeController;
use App\Http\Controllers\AttributeValueController;
use App\Http\Controllers\CarrierController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SocialiteController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.dashboard');
});

// Route::get('/', function () {
//     return view('client.');
// });
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
=======
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

     Route::post('/save-attributes', [AttributeController::class, 'saveAttributes']);
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
});

Route::post('/update-category-parent', [CategoryController::class, 'updateParent']);

Route::get('/client', function () {
    return view('client/home');
});

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

Route::prefix('/')->group(function(){
    Route::get('', function () {
        return view('client.home');
    })->name('client');
});

