<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\PayMentController;
use App\Http\Controllers\UserReviewController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\PostController;
use App\Http\Controllers\Client\ProductController as ClientProductController;

Route::prefix('/')->group(function () {
    Route::get('', [HomeController::class, 'index'])->name('client');
    //profile
    Route::get('/user',                                     [UserController::class, 'indexClient'])->name('users.indexClient');
    Route::get('profile/{id}',                              [UserController::class, 'showClient'])->name('users.showClient');
    Route::put('update-profile/{id}',                       [UserController::class, 'updateClient'])->name('users.updateClient');
    Route::get('show-order',                                [UserController::class, 'showOrder'])->name('users.showOrder');
    Route::get('show-order-detail/{id}',                    [UserController::class, 'showDetailOrder'])->name('users.showDetailOrder');
    Route::get('show-rank/{id}',                            [UserController::class, 'showRank'])->name('users.showRank');
    Route::post('/order/{orderId}/cancel',                  [UserController::class, 'cancelOrder'])->name('users.cancel');
    Route::post('/order/{order}/review',                    [UserController::class, 'submitReview'])->name('users.submitReview');


    //product
    Route::get('/products',                                 [HomeController::class, 'showProducts'])->name('client.products');
    Route::get('/products/sort',                            [HomeController::class, 'sortProducts'])->name('client.products.sort');
    Route::get('/product/{id}',                             [ClientProductController::class, 'showProduct'])->name('client.showProduct');
    Route::get('/products/category/{id}',                   [HomeController::class, 'getByCategory'])->name('client.products.Category');
    Route::get('/products/filter-by-price',                 [HomeController::class, 'filterByPrice'])->name('client.products.filterByPrice');
    Route::get('/search',                                   [ClientProductController::class, 'search'])->name('search');

    //Oder
    Route::get('wishlist',                                  [OrderController::class, 'wishList'])->name('wishList');
    Route::post('add-wishlist',                             [OrderController::class, 'addWishList'])->name('addWishList');
    Route::delete('wishlist/{id}',                          [OrderController::class, 'destroyWishlist'])->name('wishlistDelete');

    Route::post('add-cart',                                 [OrderController::class, 'addToCart'])->name('addCart');
    Route::get('shopping-cart',                             [OrderController::class, 'showShoppingCart'])->name('shopping-cart');
    Route::get('checkout',                                  [OrderController::class, 'showCheckOut'])->name('checkout')->middleware('check-cart');
    Route::post('addresses',                                [UserController::class, 'updateOrInsertAddress'])->name('addresses');
    Route::post('/addresses/set-default/{id}',              [UserController::class, 'setDefaultAddress'])->name('addresses.setDefault');
    Route::post('/update-address',                          [UserController::class, 'updateAddress'])->name('update.address');
    Route::post('add-order',                                [PayMentController::class, 'addOrder'])->name('addOrder'); // tahnh toán 
    Route::delete('remove/{id}',                            [OrderController::class, 'removeFromCart'])->name('removeFromCart');
    Route::post('update-cart',                              [OrderController::class, 'updateCart'])->name('updateCart');
    Route::get('/blog',                                     [PostController::class, 'index'])->name('client.blogs.index');
    Route::get('/blogs/{id}',                               [PostController::class, 'show'])->name('client.blogs.show');
    //Counpon
    Route::post('/apply-discount',                          [CouponController::class, 'applyDiscount']);

    // //PayMent
    Route::get('/vnpay-return',                            [PayMentController::class, 'vnpayReturn'])->name('vnpay.return');

    // Route::post('/create-order',                         [PayMentController::class, 'createOrder'])->name('create.order');

    //Chat
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index') ->middleware(['auth', 'isAdmin']);

    // Route để gửi tin nhắn
    Route::post('/chat/send-message', [ChatController::class, 'sendMessage'])->name('chat.sendMessage');

    // Route kiểm tra mã giảm giá
    Route::post('/check-coupon', [OrderController::class, 'checkCoupon'])->name('check.coupon');
    // Route áp dụng mã giảm giá vào đơn hàng
    Route::post('/apply-coupon', [OrderController::class, 'applyCoupon'])->name('apply.coupon');

        // routes/web.php
    Route::post('/send-message', [ChatController::class, 'sendMessage']);

    Route::get('/clear-coupons', function() {
        $currentUrl = url()->current();
        if($currentUrl=="http://localhost:8000/checkout"){
            return response()->json(['success' => false]);
        }
        session()->forget('coupons'); // Clear the coupons session
        return response()->json(['success' => true]); 
    });
    Route::get('/product/{id}/reviews', [UserReviewController::class, 'showProductReviews'])->name('client.product.reviews');
});
// Route::post('/reviews', [UserReviewController::class, 'store'])->name('reviews.store');