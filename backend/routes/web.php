<?php

use App\Http\Controllers\AttributeController;
use App\Http\Controllers\AttributeValueController;
use App\Http\Controllers\CarrierController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SocialiteController;
use Illuminate\Support\Facades\Mail;

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => ['auth', 'isAdmin']
], function () {
    Route::get('dashboard', function () {
        return view('admin/dashboard');
    })->name('dashboard');
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
        Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy');
        Route::get('/listSotfDeleted', [ProductController::class, 'showSotfDelete'])->name('deleted');
        Route::put('/restore/{id}', [ProductController::class, 'restore'])->name('restore');
        Route::delete('/{id}/hard-delete', [ProductController::class, 'hardDelete'])->name('hardDelete');
        Route::post('/delete-multiple', [ProductController::class, 'deleteMuitpalt'])->name('deleteMultiple');
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
    Route::get('/attribute/listsotfdeleted',            [AttributeController::class, 'showSotfDelete'])->name('admin.attributes.deleted1');


    //Carriers
    Route::prefix('carriers')->group(function () {
        Route::get('/',                                     [CarrierController::class, 'index'])->name('carriers.index');
        Route::get('/create',                               [CarrierController::class, 'create'])->name('carriers.create');
        Route::post('/',                                    [CarrierController::class, 'store'])->name('carriers.store');
        Route::get('{id}/edit',                             [CarrierController::class, 'edit'])->name('carriers.edit');
        Route::put('/{id}',                                 [CarrierController::class, 'update'])->name('carriers.update');
        Route::patch('/restore/{id}',                       [CarrierController::class, 'restore'])->name('carriers.restore');
        Route::get('/listsotfdeleted',                      [CarrierController::class, 'showSotfDelete'])->name('carriers.deleted');
        // Xóa mềm carrier
        Route::delete('/{id}',                              [CarrierController::class, 'destroyCarrier'])->name('carriers.destroy');
        // Xóa cứng carrier
        Route::delete('/{id}/hard-delete',                  [CarrierController::class, 'hardDeleteCarrier'])->name('carriers.hardDelete');
        // Xóa nhiều
        Route::post('/delete-multiple',                     [CarrierController::class, 'deleteMuitpalt'])->name('carriers.deleteMultiple');
    });
    //Coupons
    Route::prefix('coupons')->group(function () {
        Route::get('/',                                     [CouponController::class, 'index'])->name('coupons.index');
        Route::get('/create',                               [CouponController::class, 'create'])->name('coupons.create');
        Route::post('/',                                    [CouponController::class, 'store'])->name('coupons.store');
        Route::get('/{id}',                                 [CouponController::class, 'show'])->name('coupons.show');
        Route::get('{id}/edit',                             [CouponController::class, 'edit'])->name('coupons.edit');
        Route::put('/{id}',                                 [CouponController::class, 'update'])->name('coupons.update');
        Route::patch('/restore/{id}',                       [CouponController::class, 'restore'])->name('coupons.restore');
        // Route::get('/listsotfdeleted',                   [CouponController::class, 'showSotfDelete'])->name('coupons.deleted');
        Route::get('/showsotfdelete/{id}',                  [CouponController::class, 'showSotfDeleteID'])->name('coupons.showsotfdelete');
        // Xóa mềm Coupons
        Route::delete('/{id}',                              [CouponController::class, 'destroyCoupon'])->name('coupons.destroy');
        // Xóa cứng Coupons
        Route::delete('/{id}/hard-delete',                  [CouponController::class, 'hardDeleteCoupon'])->name('coupons.hardDelete');
        // Xóa nhiều
        Route::post('/couponsDelete-multiple',              [CouponController::class, 'deleteMuitpalt'])->name('coupons.deleteMultiple');
    });
    Route::get('/listsotfdeleted',                       [CouponController::class, 'showSotfDelete'])->name('coupons.deleted');

    Route::prefix('attributes')->group(function () {
        Route::get('/',                                     [AttributeController::class, 'index'])->name('attributes.index');
        Route::get('/create',                               [AttributeController::class, 'create'])->name('attributes.create');
        Route::post('/',                                    [AttributeController::class, 'store'])->name('attributes.store');
        Route::get('{id}/edit',                             [AttributeController::class, 'edit'])->name('attributes.edit');
        Route::put('/{id}',                                 [AttributeController::class, 'update'])->name('attributes.update'); // Route để cập nhật thuộc tính
        Route::get('/{id}',                                 [AttributeController::class, 'show'])->name('attributes.show');
        Route::delete('/{id}',                              [AttributeController::class, 'destroy'])->name('attributes.destroy');
        Route::get('/shortdeleted',                         [AttributeController::class, 'showSotfDelete'])->name('attributes.deleted');
        Route::patch('/restore/{id}',                       [AttributeController::class, 'restore'])->name('attributes.restore');
        // Xóa cứng attribute
        Route::delete('/{id}/hard-delete',                  [AttributeController::class, 'hardDeleteAttribute'])->name('attributes.hardDelete');
        // Xóa mềm attribute_value
        Route::delete('/values/{id}',                       [AttributeController::class, 'destroyValue'])->name('attributeValues.destroy');
        // Xóa cứng attribute_value
        Route::delete('/values/{id}/hard-delete',           [AttributeController::class, 'hardDeleteAttributeValue'])->name('attributeValues.hardDelete');
        // Xóa nhiều
        Route::post('/delete-multiple',                     [AttributeController::class, 'deleteMuitpalt'])->name('attributes.deleteMultiple');
    });
    Route::get('/attributeshortdeleted',                 [AttributeController::class, 'showSotfDelete'])->name('attributes.attributeshortdeleted');

    Route::post('/save-attributes', [AttributeController::class, 'saveAttributes']);
    Route::prefix('categories')->group(function () {
        Route::get('/',                                    [CategoryController::class, 'index'])->name('categories.index');
        Route::get('create',                               [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/',                                   [CategoryController::class, 'store'])->name('categories.store');
        // Route::get('/{category}',                       [CategoryController::class, 'show'])->name('categories.show');
        Route::get('/categories/{category}',               [CategoryController::class, 'show'])->name('categories.show');
        Route::get('/{category}',                          [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/{category}',                          [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/{category}',                       [CategoryController::class, 'destroy'])->name('categories.destroy');
        Route::delete('/categories/delete-multiple',       [CategoryController::class, 'deleteMultiple'])->name('categories.delete-multiple');
        // Route::delete('/{category}/hard-delete',        [CategoryController::class, 'hardDelete'])->name('categories.hard-delete');
        Route::patch('/categories/{id}/restore',           [CategoryController::class, 'restore'])->name('categories.restore');
        Route::delete('/categories/{id}/hard-delete',      [CategoryController::class, 'hardDelete'])->name('categories.hard-delete');

        Route::post('/update-category-parent',            [CategoryController::class, 'updateParent']);
    });
    Route::get('/categoryTrashed',                        [CategoryController::class, 'trashed'])->name('categories.trashed');
    Route::get('/categoriesTrashed/search',               [CategoryController::class, 'searchTrashed'])->name('categories.trashed.search');
    Route::post('/categories/trashed/restore-multiple',   [CategoryController::class, 'restoreMultiple'])->name('categories.trashed.restoreMultiple');
    Route::post('/categories/trashed/hard-delete-multiple', [CategoryController::class, 'hardDeleteMultiple'])->name('categories.trashed.hardDeleteMultiple');

    //Users
    Route::prefix('users')->group(function () {
        Route::get('/',                                     [UserController::class, 'index'])->name('users.index');
        Route::get('/add',                                  [UserController::class, 'add'])->name('users.add');
        Route::post('/store',                               [UserController::class, 'store'])->name('users.store');
        Route::get('show/{id}',                             [UserController::class, 'show'])->name('users.show');
        Route::get('/edit/{id}',                            [UserController::class, 'edit'])->name('users.edit');
        Route::put('update/{id}',                           [UserController::class, 'update'])->name('users.update');
        Route::delete('/{id}/delete',                       [UserController::class, 'destroy'])->name('users.delete');
        Route::get('/deleteMultiple',                       [UserController::class, 'listdeleteMultiple'])->name('users.listdeleteMultiple');
        Route::post('/deleteMultiple',                      [UserController::class, 'deleteMultiple'])->name('users.deleteMultiple');
        Route::post('/manage/{id}',                         [UserController::class, 'manage'])->name('users.manage');
    });

    //Permissions
    Route::prefix('/permissions')->name('permissions.')->group(function () {
        Route::get('/',                                      [PermissionController::class, 'index'])->name('index');
        Route::get('/create',                                [PermissionController::class, 'create'])->name('create');
        Route::get('/{id}',                                  [PermissionController::class, 'show'])->name('show');
        Route::post('/',                                     [PermissionController::class, 'store'])->name('store');
        Route::get('/{id}/edit',                             [PermissionController::class, 'edit'])->name('edit');
        Route::put('/{id}',                                  [PermissionController::class, 'update'])->name('update');
        Route::delete('/{id}',                               [PermissionController::class, 'destroyPermission'])->name('destroyPermission');
        Route::delete('/{id}/hard',                          [PermissionController::class, 'destroyPermissionHard'])->name('destroyPermissionHard');

        Route::delete('/{id}/value',                         [PermissionController::class, 'destroyPermissionValue'])->name('destroyPermissionValue');
        Route::delete('/{id}/value/hard',                    [PermissionController::class, 'destroyPermissionValueHard'])->name('destroyPermissionValueHard');

        Route::post('/destroy-multiple',                     [PermissionController::class, 'destroyMultiple'])->name('destroyMultiple');
        Route::post('/values/destroy-multiple',              [PermissionController::class, 'destroyMultipleValues'])->name('destroyMultipleValues');
    });
});

Route::get('/client', function () {
    return view('client/home');
});

Route::prefix('auth')->group(function () {
    Route::get('admin/login',                             [LoginController::class, 'showFormLoginAdmin'])->name('admin.login');
    Route::get('login',                                  [LoginController::class, 'showFormLogin'])->name('client.login');
    Route::post('login',                                  [LoginController::class, 'login'])->name('auth.login');
    Route::get('logout',                                  [LoginController::class, 'logout'])->name('auth.logout');
    Route::get('register',                                [RegisterController::class, 'showFormRegister'])->name('show.register');
    Route::post('register',                               [RegisterController::class, 'register'])->name('register');

    // Route::get('password/confirm',                     [ConfirmPasswordController::class, 'showConfirmForm'])->name('password.showconfirm');
    // Route::post('password/confirm',                    [ConfirmPasswordController::class, 'confirm'])->name('password.confirm');
    Route::post('password/email',                         [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset',                          [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/reset',                         [ResetPasswordController::class, 'reset'])->name('password.update');
    Route::get('password/reset/{token}',                  [ResetPasswordController::class, 'showResetForm'])->name('password.reset');

    Route::get('google',                                  [SocialiteController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('google/callback',                         [SocialiteController::class, 'handleGoogleCallback']);

    Route::get('facebook',                                [SocialiteController::class, 'redirectToFacebook'])->name('auth.facebook');
    Route::get('facebook/callback',                       [SocialiteController::class, 'handleFacebookCallback']);

    Route::get('github',                                  [SocialiteController::class, 'redirectToGitHub'])->name('auth.github');
    Route::get('github/callback',                         [SocialiteController::class, 'handleGitHubCallback']);

    Route::get('twitter',                                 [SocialiteController::class, 'redirectToTwitter'])->name('auth.twitter');
    Route::get('twitter/callback',                        [SocialiteController::class, 'handleTwitterCallback']);
});

Route::prefix('/')->group(function () {
    Route::get('', function () {
        return view('client.home');
    })->name('client');
});
