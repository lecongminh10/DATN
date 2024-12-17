<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\RefundController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\PayMentController;
use App\Http\Controllers\UserReviewController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\PostController;
use App\Http\Controllers\Client\ProductController as ClientProductController;
use App\Http\Controllers\Client\FeedbackController as ClientFeedbackController; 

Route::prefix('/')->group(function () {
    Route::get('', [HomeController::class, 'index'])->name('client');
    //profile
    Route::get('/user', [UserController::class, 'indexClient'])->name('users.indexClient');
    Route::get('profile/{id}', [UserController::class, 'showClient'])->name('users.showClient');
    Route::put('update-profile/{id}', [UserController::class, 'updateClient'])->name('users.updateClient');
    Route::get('show-order', [UserController::class, 'showOrder'])->name('users.showOrder');
    Route::get('show-order-detail/{id}', [UserController::class, 'showDetailOrder'])->name('users.showDetailOrder');
    Route::get('show-rank/{id}', [UserController::class, 'showRank'])->name('users.showRank');
    Route::post('/order/{orderId}/cancel', [UserController::class, 'cancelOrder'])->name('users.cancel');
    Route::post('/order/{order}/review', [UserController::class, 'submitReview'])->name('users.submitReview');
    Route::get('/list-voucher', [UserController:: class, 'listVoucher'])->name('users.listVoucher');


    //product
    Route::get('/products', [HomeController::class, 'showProducts'])->name('client.products');
    Route::get('/products/sort', [HomeController::class, 'sortProducts'])->name('client.products.sort');
    Route::get('/product/{id}', [ClientProductController::class, 'showProduct'])->name('client.showProduct');
    Route::get('/products/category/{id}', [HomeController::class, 'getByCategory'])->name('client.products.Category');
    Route::get('/products/filter-by-product', [HomeController::class, 'filterByProducts'])->name('client.products.filterByProducts');
    Route::get('/search', [ClientProductController::class, 'search'])->name('search');

    //Oder
    Route::get('wishlist', [OrderController::class, 'wishList'])->name('wishList');
    Route::post('add-wishlist', [OrderController::class, 'addWishList'])->name('addWishList');
    Route::delete('wishlist/{id}', [OrderController::class, 'destroyWishlist'])->name('wishlistDelete');

    Route::post('add-cart', [OrderController::class, 'addToCart'])->name('addCart');
    Route::get('shopping-cart', [OrderController::class, 'showShoppingCart'])->name('shopping-cart');
    Route::get('checkout', [OrderController::class, 'showCheckOut'])->name('checkout')->middleware('check-cart');
    Route::post('addresses', [UserController::class, 'updateOrInsertAddress'])->name('addresses');
    Route::post('/addresses/set-default/{id}', [UserController::class, 'setDefaultAddress'])->name('addresses.setDefault');
    Route::post('/update-address', [UserController::class, 'updateAddress'])->name('update.address');
    Route::post('add-order', [PayMentController::class, 'addOrder'])->name('addOrder'); // tahnh toán 
    Route::delete('remove/{id}', [OrderController::class, 'removeFromCart'])->name('removeFromCart');
    Route::post('update-cart', [OrderController::class, 'updateCart'])->name('updateCart');
    Route::get('/blog', [PostController::class, 'index'])->name('client.blogs.index');
    Route::get('/blogs/{id}', [PostController::class, 'show'])->name('client.blogs.show');
    Route::get('/blogs/tag/{id}', [PostController::class, 'showTagPosts'])->name('client.blogs.tag');

    //Counpon
    Route::post('/apply-discount', [CouponController::class, 'applyDiscount']);

    // //PayMent
    Route::get('/vnpay-return', [PayMentController::class, 'vnpayReturn'])->name('vnpay.return');

    // Route::post('/create-order',                         [PayMentController::class, 'createOrder'])->name('create.order');
    // Route kiểm tra mã giảm giá
    Route::post('/check-coupon', [OrderController::class, 'checkCoupon'])->name('check.coupon');
    // Route áp dụng mã giảm giá vào đơn hàng
    Route::post('/apply-coupon', [OrderController::class, 'applyCoupon'])->name('apply.coupon');

    Route::get('/clear-coupons', function () {
        $currentUrl = url()->current();
        if ($currentUrl == "http://localhost:8000/checkout") {
            return response()->json(['success' => false]);
        }else{
            session()->forget('coupons'); // Clear the coupons session
            return response()->json(['success' => true]);
        }
    });
    Route::get('/product/{id}/reviews', [UserReviewController::class, 'showProductReviews'])->name('client.product.reviews');

    Route::middleware(['auth'])->group(function () {
        Route::get('/refunds', [RefundController::class, 'index'])->name('refunds.index');
        Route::post('/refunds', [RefundController::class, 'store'])->name('refunds.store');
        Route::put('/refunds/{refund}', [RefundController::class, 'update'])->name('refunds.update');
        Route::get('/refunds/create/{orderId}', [RefundController::class, 'createRefundForm'])->name('refunds.create');
    });
});
// Route::post('/reviews', [UserReviewController::class, 'store'])->name('reviews.store');


Route::prefix('chat')->name('chat.')->group(function () {
    Route::get('/', [ChatController::class, 'index'])->name('index')->middleware(['auth', 'isAdmin']);
    Route::post('/send-message', [ChatController::class, 'sendMessage'])->name('sendMessage');
    Route::post('/user-online/{id}', [ChatController::class, 'userOnline'])->name('userOnline');
    Route::post('/user-offline/{id}', [ChatController::class, 'userOffline'])->name('userOffline');
    Route::post('/getDataChatAdmin', [ChatController::class, 'getDataChatAdmin'])->middleware(['auth', 'isAdmin'])->name('getDataChatAdmin');
    Route::post('/getDataChatClient', [ChatController::class, 'getDataChatClient'])->name('getDataChatClient');
    Route::post('/get-room-id', [ChatController::class, 'getRoomId'])->name('getDataChatAdminaNew');
    Route::post('/chat-message/delete', [ChatController::class, 'deleteChatMessageById'])->middleware(['auth', 'isAdmin'])->name('message.delete');
});

Route::get('/feedbacks/create', [ClientFeedbackController::class, 'create'])->name('feedbacks.create');
Route::post('/feedbacks', [ClientFeedbackController::class, 'store'])->name('feedbacks.store');

Route::get('/{permalink}', [PageController::class, 'showPage'])
    ->where('permalink', '^[a-zA-Z0-9-]+$') 
    ->name('pages.show');