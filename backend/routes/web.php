<?php

use App\Helpers\ApiHelper;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeoController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\CarrierController;
use App\Http\Controllers\InfoBoxController;
use App\Http\Controllers\PayMentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\PopuphomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserReviewController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\PostController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ExportImportController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AttributeValueController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\PaymentGatewayController;
use App\Http\Controllers\Client\ProductController as ClientProductController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SeoController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\InfoBoxController;
use App\Http\Controllers\PopuphomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserReviewController;
use App\Http\Controllers\ExportImportController;
use App\Http\Controllers\CategoryStatisticsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\FeedbackController;


Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => ['auth', 'isAdmin']
], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::group([
        'prefix' => 'products',
        'as' => 'products.',
    ], function () {
        // CRUD products (list, add, update, detail, delete)=> resful API
        Route::get('/listProduct',                           [ProductController::class, 'index'])->name('listProduct');
        Route::get('/addProduct',                            [ProductController::class, 'showAdd'])->name('addProduct');
        Route::post('/addProduct',                           [ProductController::class, 'store'])->name('addPostProduct');
        Route::get('/showProduct/{id}',                      [ProductController::class, 'showProduct'])->name('showProduct');
        Route::get('/update-product/{id}',                   [ProductController::class, 'showUpdate'])->name('updateProduct');
        Route::put('/updateProduct/{id}',                    [ProductController::class, 'update'])->name('updatePutProduct');
        Route::get('/{id}/variants',                         [ProductController::class, 'getVariants'])->name('admin.products.getVariants');

        // Route::get('/deleteProduct/{id}', [ProductController::class, 'destroy'])->name('deleteProduct');
        Route::delete('/{id}',                              [ProductController::class, 'destroy'])->name('destroy');
        Route::get('/listSotfDeleted',                      [ProductController::class, 'showSotfDelete'])->name('deleted');
        Route::put('/restore/{id}',                         [ProductController::class, 'restore'])->name('restore');
        Route::delete('/{id}/hard-delete',                  [ProductController::class, 'hardDelete'])->name('hardDelete');
        Route::post('/delete-multiple',                     [ProductController::class, 'deleteMuitpalt'])->name('deleteMultiple');
    });
    //Attributes
    Route::prefix('attributes')->group(function () {
        Route::get('/', [AttributeController::class, 'index'])->name('admin.attributes.index');
        Route::get('/create', [AttributeController::class, 'create'])->name('admin.attributes.create');
        Route::post('/', [AttributeController::class, 'store'])->name('admin.attributes.store');
        Route::get('{id}/edit', [AttributeController::class, 'edit'])->name('admin.attributes.edit');
        Route::put('/{id}', [AttributeController::class, 'update'])->name('admin.attributes.update'); // Route để cập nhật thuộc tính
        Route::get('/{id}', [AttributeController::class, 'show'])->name('admin.attributes.show');
        Route::delete('/{id}', [AttributeController::class, 'destroy'])->name('admin.attributes.destroy');
        Route::get('/listsotfdeleted', [AttributeController::class, 'showSotfDelete'])->name('admin.attributes.deleted');
        Route::patch('/restore/{id}', [AttributeController::class, 'restore'])->name('admin.attributes.restore');
        // Xóa cứng attribute
        Route::delete('/{id}/hard-delete', [AttributeController::class, 'hardDeleteAttribute'])->name('admin.attributes.hardDelete');
        // Xóa mềm attribute_value
        Route::delete('/values/{id}', [AttributeController::class, 'destroyValue'])->name('admin.attributeValues.destroy');
        // Xóa cứng attribute_value
        Route::delete('/values/{id}/hard-delete', [AttributeController::class, 'hardDeleteAttributeValue'])->name('admin.attributeValues.hardDelete');
        // Xóa nhiều
        Route::post('/delete-multiple', [AttributeController::class, 'deleteMuitpalt'])->name('admin.attributes.deleteMultiple');
    });

    Route::get('/attribute/listsotfdeleted',                [AttributeController::class, 'showSotfDelete'])->name('admin.attributes.deleted1');

    //Carriers
    Route::prefix('carriers')->group(function () {
        Route::get('/', [CarrierController::class, 'index'])->name('carriers.index');
        Route::get('/create', [CarrierController::class, 'create'])->name('carriers.create');
        Route::post('/', [CarrierController::class, 'store'])->name('carriers.store');
        Route::get('{id}/edit', [CarrierController::class, 'edit'])->name('carriers.edit');
        Route::put('/{id}', [CarrierController::class, 'update'])->name('carriers.update');
        Route::patch('/restore/{id}', [CarrierController::class, 'restore'])->name('carriers.restore');
        Route::get('/listsotfdeleted', [CarrierController::class, 'showSotfDelete'])->name('carriers.deleted');
        // Xóa mềm carrier
        Route::delete('/{id}', [CarrierController::class, 'destroyCarrier'])->name('carriers.destroy');
        // Xóa cứng carrier
        Route::delete('/{id}/hard-delete', [CarrierController::class, 'hardDeleteCarrier'])->name('carriers.hardDelete');
        // Xóa nhiều
        Route::post('/delete-multiple', [CarrierController::class, 'deleteMuitpalt'])->name('carriers.deleteMultiple');
    });

    //tags
    Route::prefix('tags')->group(function () {
        Route::get('/',                                     [TagController::class, 'index'])->name('tags.index');
        Route::get('/create',                               [TagController::class, 'create'])->name('tags.create');
        Route::post('/',                                    [TagController::class, 'store'])->name('tags.store');
        Route::get('{id}/edit',                             [TagController::class, 'edit'])->name('tags.edit');
        Route::put('/{id}',                                 [TagController::class, 'update'])->name('tags.update');
        Route::patch('/restore/{id}',                       [TagController::class, 'restore'])->name('tags.restore');
        Route::get('/listsotfdeleted',                      [TagController::class, 'showSotfDelete'])->name('tags.deleted');
        // Xóa mềm
        Route::delete('/{id}',                              [TagController::class, 'destroyTag'])->name('tags.destroy');
        // Xóa cứng
        Route::delete('/{id}/hard-delete',                  [TagController::class, 'hardDeleteTag'])->name('tags.hardDelete');
        // Xóa nhiều
        Route::post('/delete-multiple',                     [TagController::class, 'deleteMuitpalt'])->name('tags.deleteMultiple');
    });

    //pages
    Route::prefix('pages')->group(function () {
        Route::get('/',                                     [PageController::class, 'index'])->name('pages.index');
        Route::get('/create',                               [PageController::class, 'create'])->name('pages.create');
        Route::post('/',                                    [PageController::class, 'store'])->name('pages.store');
        Route::get('{id}/edit',                             [PageController::class, 'edit'])->name('pages.edit');
        Route::put('/{id}',                                 [PageController::class, 'update'])->name('pages.update');
        Route::patch('/restore/{id}',                       [PageController::class, 'restore'])->name('pages.restore');
        Route::get('/listsotfdeleted',                      [PageController::class, 'showSotfDelete'])->name('pages.deleted');
        // Xóa mềm
        Route::delete('/{id}',                              [PageController::class, 'destroyPage'])->name('pages.destroy');
        // Xóa cứng
        Route::delete('/{id}/hard-delete',                  [PageController::class, 'hardDeletePage'])->name('pages.hardDelete');
        // Xóa nhiều
        Route::post('/delete-multiple',                     [PageController::class, 'deleteMuitpalt'])->name('pages.deleteMultiple');
    });

    //seo
    Route::prefix('seo')->group(function () {
        Route::get('/',                                     [SeoController::class, 'index'])->name('seo.index');
        Route::get('/create',                               [SeoController::class, 'create'])->name('seo.create');
        Route::post('/',                                    [SeoController::class, 'store'])->name('seo.store');
        Route::get('{id}/edit',                             [SeoController::class, 'edit'])->name('seo.edit');
        Route::put('/{id}',                                 [SeoController::class, 'update'])->name('seo.update');
        Route::get('/{id}/products',                        [SeoController::class, 'getProductsBySeo'])->name('seo.products');
        Route::patch('/restore/{id}',                       [SeoController::class, 'restore'])->name('seo.restore');
        Route::get('/listsotfdeleted',                      [SeoController::class, 'showSotfDelete'])->name('seo.deleted');
        // Xóa mềm
        Route::delete('/{id}',                              [SeoController::class, 'destroySeo'])->name('seo.destroy');
        // Xóa cứng
        Route::delete('/{id}/hard-delete',                  [SeoController::class, 'hardDeleteSeo'])->name('seo.hardDelete');
        // Xóa nhiều
        Route::post('/delete-multiple',                     [SeoController::class, 'deleteMuitpalt'])->name('seo.deleteMultiple');
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
        // Route::get('/listsotfdeleted',                                [CouponController::class, 'showSotfDelete'])->name('coupons.deleted');
        Route::get('/showsotfdelete/{id}',                  [CouponController::class, 'showSotfDeleteID'])->name('coupons.showsotfdelete');
        // Xóa mềm Coupons
        Route::delete('/{id}', [CouponController::class, 'destroyCoupon'])->name('coupons.destroy');
        // Xóa cứng Coupons
        Route::delete('/{id}/hard-delete', [CouponController::class, 'hardDeleteCoupon'])->name('coupons.hardDelete');
        // Xóa nhiều
        Route::post('/couponsDelete-multiple', [CouponController::class, 'deleteMuitpalt'])->name('coupons.deleteMultiple');
    });
    Route::get('/listsotfdeleted', [CouponController::class, 'showSotfDelete'])->name('coupons.deleted');

    Route::prefix('attributes')->group(function () {
        Route::get('/', [AttributeController::class, 'index'])->name('attributes.index');
        Route::get('/create', [AttributeController::class, 'create'])->name('attributes.create');
        Route::post('/', [AttributeController::class, 'store'])->name('attributes.store');
        Route::get('{id}/edit', [AttributeController::class, 'edit'])->name('attributes.edit');
        Route::put('/{id}', [AttributeController::class, 'update'])->name('attributes.update'); // Route để cập nhật thuộc tính
        Route::get('/{id}', [AttributeController::class, 'show'])->name('attributes.show');
        Route::delete('/{id}', [AttributeController::class, 'destroy'])->name('attributes.destroy');
        Route::get('/shortdeleted', [AttributeController::class, 'showSotfDelete'])->name('attributes.deleted');
        Route::patch('/restore/{id}', [AttributeController::class, 'restore'])->name('attributes.restore');
        // Xóa cứng attribute
        Route::delete('/{id}/hard-delete', [AttributeController::class, 'hardDeleteAttribute'])->name('attributes.hardDelete');
        // Xóa mềm attribute_value
        Route::delete('/values/{id}', [AttributeController::class, 'destroyValue'])->name('attributeValues.destroy');
        // Xóa cứng attribute_value
        Route::delete('/values/{id}/hard-delete', [AttributeController::class, 'hardDeleteAttributeValue'])->name('attributeValues.hardDelete');
        // Xóa nhiều
        Route::post('/delete-multiple', [AttributeController::class, 'deleteMuitpalt'])->name('attributes.deleteMultiple');
    });
    Route::get('/attributeshortdeleted', [AttributeController::class, 'showSotfDelete'])->name('attributes.attributeshortdeleted');

    Route::post('/save-attributes', [AttributeController::class, 'saveAttributes']);

    Route::prefix('categories')->group(function () {
        Route::get('/',                                    [CategoryController::class, 'index'])->name('categories.index');
        Route::get('create',                               [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/',                                   [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{category}',               [CategoryController::class, 'show'])->name('categories.show');
        Route::get('/{category}',                          [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/{category}',                          [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/{category}',                       [CategoryController::class, 'destroy'])->name('categories.destroy');
        Route::delete('/categories/delete-multiple',       [CategoryController::class, 'deleteMultiple'])->name('categories.delete-multiple');
        Route::patch('/categories/{id}/restore',           [CategoryController::class, 'restore'])->name('categories.restore');
        Route::delete('/categories/{id}/hard-delete',      [CategoryController::class, 'hardDelete'])->name('categories.hard-delete');
        Route::post('/update-category-parent',             [CategoryController::class, 'updateParent']);
        Route::get('/home',                                [HomeController::class, 'index'])->name('home.index');
    });
    Route::get('/categoryTrashed', [CategoryController::class, 'trashed'])->name('categories.trashed');
    Route::get('/categoriesTrashed/search', [CategoryController::class, 'searchTrashed'])->name('categories.trashed.search');
    Route::post('/categories/trashed/restore-multiple', [CategoryController::class, 'restoreMultiple'])->name('categories.trashed.restoreMultiple');
    Route::post('/categories/trashed/hard-delete-multiple', [CategoryController::class, 'hardDeleteMultiple'])->name('categories.trashed.hardDeleteMultiple');

    //Users
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/add', [UserController::class, 'add'])->name('users.add');
        Route::post('/store', [UserController::class, 'store'])->name('users.store');
        Route::get('show/{id}', [UserController::class, 'show'])->name('users.show');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
        Route::put('update/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/{id}/delete', [UserController::class, 'destroy'])->name('users.delete');
        Route::get('/deleteMultiple', [UserController::class, 'listdeleteMultiple'])->name('users.listdeleteMultiple');
        Route::post('/deleteMultiple', [UserController::class, 'deleteMultiple'])->name('users.deleteMultiple');
        Route::post('/manage/{id}', [UserController::class, 'manage'])->name('users.manage');
    });

    //payment
    Route::prefix('payments')->group(function () {
        Route::get('/',                                     [PayMentController::class, 'index'])->name('payments.index');
        Route::get('/add',                                  [PayMentController::class, 'add'])->name('payments.add');
        Route::post('/store',                               [PayMentController::class, 'store'])->name('payments.store');
        Route::get('show/{id}',                             [PayMentController::class, 'show'])->name('payments.show');
        Route::get('/edit/{id}',                            [PayMentController::class, 'edit'])->name('payments.edit');
        Route::put('update/{id}',                           [PayMentController::class, 'update'])->name('payments.update');
        Route::delete('/users/{id}/delete',                 [PayMentController::class, 'destroy'])->name('payments.delete');
        Route::post('/users/deleteMultiple',                [PayMentController::class, 'deleteMultiple'])->name('payments.deleteMultiple');
    });

    //payment-gateway
    Route::prefix('paymentgateways')->group(function () {
        Route::get('/',                                     [PaymentGatewayController::class, 'index'])->name('paymentgateways.index');
        Route::get('/add',                                  [PaymentGatewayController::class, 'add'])->name('paymentgateways.add');
        Route::post('/store',                               [PaymentGatewayController::class, 'store'])->name('paymentgateways.store');
        Route::get('show/{id}',                             [PaymentGatewayController::class, 'show'])->name('paymentgateways.show');
        Route::get('/edit/{id}',                            [PaymentGatewayController::class, 'edit'])->name('paymentgateways.edit');
        Route::put('update/{id}',                           [PaymentGatewayController::class, 'update'])->name('paymentgateways.update');
        Route::delete('/users/{id}/delete',                 [PaymentGatewayController::class, 'destroy'])->name('paymentgateways.delete');
        Route::post('/users/deleteMultiple',                [PaymentGatewayController::class, 'deleteMultiple'])->name('paymentgateways.deleteMultiple');
    });

    //Permissions
    Route::prefix('/permissions')->name('permissions.')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('index');
        Route::get('/create', [PermissionController::class, 'create'])->name('create');
        Route::get('/{id}', [PermissionController::class, 'show'])->name('show');
        Route::post('/', [PermissionController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [PermissionController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PermissionController::class, 'update'])->name('update');
        Route::delete('/{id}', [PermissionController::class, 'destroyPermission'])->name('destroyPermission');
        Route::delete('/{id}/hard', [PermissionController::class, 'destroyPermissionHard'])->name('destroyPermissionHard');

        Route::delete('/{id}/value', [PermissionController::class, 'destroyPermissionValue'])->name('destroyPermissionValue');
        Route::delete('/{id}/value/hard', [PermissionController::class, 'destroyPermissionValueHard'])->name('destroyPermissionValueHard');

        Route::post('/destroy-multiple', [PermissionController::class, 'destroyMultiple'])->name('destroyMultiple');
        Route::post('/values/destroy-multiple', [PermissionController::class, 'destroyMultipleValues'])->name('destroyMultipleValues');
    });

    //Oder
    Route::group(
        [
            'prefix' => 'orders',
            'as' => 'orders.'
        ],
        function () {
            Route::get('list-order', [OrderController::class, 'index'])->name('listOrder');
            Route::get('list-trash-order', [OrderController::class, 'listTrash'])->name('listTrashOrder');
            Route::get('order-detail/{id}', [OrderController::class, 'showOrder'])->name('orderDetail');
            Route::get('order-edit/{code}', [OrderController::class, 'showModalEdit'])->name('orderEdit');
            Route::put('update-order/{id}', [OrderController::class, 'updateOrder'])->name('updateOrder');
            Route::delete('soft-delete/{id}', [OrderController::class, 'destroy'])->name('soft_delete');
            Route::delete('multi-soft-delete', [OrderController::class, 'deleteMuitpalt'])->name('multi_soft_delete');
            Route::put('restore/{id}', [OrderController::class, 'restore'])->name('restore'); // một cái được rồi đúng khoong  ô thử lại caid
            Route::put('restore_selected', [OrderController::class, 'muitpathRestore'])->name('restore_selected');
            Route::delete('hard-delete/{id}', [OrderController::class, 'hardDelete'])->name('hard_delete');
            Route::delete('multi-hard-delete', [OrderController::class, 'deleteMuitpalt'])->name('multi_hard_delete');

            Route::get('canceled', [OrderController::class, 'canceledOrders'])->name('canceledOrders');
            Route::get('completed', [OrderController::class, 'completedOrders'])->name('completedOrders');
            Route::get('lost', [OrderStatisticsController::class, 'lostOrders'])->name('lostOrders');
            Route::get('statistics', [OrderStatisticsController::class, 'index'])->name('statistics');
        }
    );

    // Blogs
    Route::prefix('blogs')->group(function () {
        Route::get('/', [BlogController::class, 'index'])->name('blogs.index');
        Route::get('/create', [BlogController::class, 'create'])->name('blogs.create');
        Route::post('/', [BlogController::class, 'store'])->name('blogs.store');
        Route::get('{id}/edit', [BlogController::class, 'edit'])->name('blogs.edit');
        Route::put('/{id}', [BlogController::class, 'update'])->name('blogs.update'); // Route để cập nhật blog
        Route::get('/{id}', [BlogController::class, 'show'])->name('blogs.show');
        Route::delete('/{id}', [BlogController::class, 'destroy'])->name('blogs.destroy');
        Route::get('/shortdeleted', [BlogController::class, 'showSoftDelete'])->name('blogs.deleted');
        Route::get('/trash', [BlogController::class, 'trash'])->name('blogs.trash'); // Route để hiển thị danh sách blog đã xóa
        Route::patch('/restore/{id}', [BlogController::class, 'restore'])->name('blogs.restore'); // Khôi phục blog đã xóa
        // Route cho danh sách blog đã bị xóa mềm
        // Route::get('/listsotfdeleted', [BlogController::class, 'showSoftDelete'])->name('blogs.deleted');

        // Route khôi phục blog đã xóa mềm
        Route::patch('/restore/{id}', [BlogController::class, 'restore'])->name('blogs.restore');

        // Route cho xóa cứng blog
        Route::delete('/{id}/hard-delete', [BlogController::class, 'hardDeleteBlog'])->name('blogs.hardDelete');

        // Route cho xóa mềm blog values (nếu có blog values)
        Route::delete('/values/{id}', [BlogController::class, 'destroyValue'])->name('blogValues.destroy');

        // Route cho xóa cứng blog values (nếu có blog values)
        Route::delete('/values/{id}/hard-delete', [BlogController::class, 'hardDeleteBlogValue'])->name('blogValues.hardDelete');

        // Route cho xóa nhiều blog
        Route::post('/delete-multiple', [BlogController::class, 'deleteMultiple'])->name('blogs.deleteMultiple');

        Route::get('/blogshortdeleted', [BlogController::class, 'showSotfDelete'])->name('blogs.blogshortdeleted');
    });

    // statistic
    Route::prefix('statistics')->as('statistics.')->group(
        function () {
            Route::get('/', [StatsController::class, 'index'])->name('index');
            Route::get('/categories', [CategoryStatisticsController::class, 'index'])->name('categories');
        }
    );

    // profile
    Route::group(
        [
            'prefix' => 'profile',
            'as' => 'profile.'
        ],
        function () {
            Route::get('/', [ProfileController::class, 'index'])->name('index');
            Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('edit');
            Route::post('/profile/update', [ProfileController::class, 'update'])->name('update');
            Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('change.password');
        }
    );

    //footer
    Route::group(
        [
            'prefix' => 'footer',
            'as' => 'footer.'
        ],
        function () {
            Route::get('footer/edit', [FooterController::class, 'edit'])->name('edit');
            Route::post('footer/update', [FooterController::class, 'update'])->name('update');
        }
    );

    //thongbao(announcement)
    Route::group(
        [
            'prefix' => 'announcement',
            'as' => 'announcement.'
        ],
        function () {
            Route::get('/announcement/edit', [AnnouncementController::class, 'edit'])->name('edit');
            Route::post('/announcement/update', [AnnouncementController::class, 'update'])->name('update');
        }
    );

    //////info_boxes
    Route::group(
        [
            'prefix' => 'info-boxes',
            'as' => 'info_boxes.',
        ],
        function () {
            Route::get('info_boxes/edit', [InfoBoxController::class, 'edit'])->name('edit');
            Route::post('info_boxes/update', [InfoBoxController::class, 'update'])->name('update');
        }
    );

    //////popuphome
    Route::group(
        [
            'prefix' => 'popuphome',
            'as' => 'popuphome.',
        ],
        function () {
            Route::get('popuphome/edit', [PopuphomeController::class, 'edit'])->name('edit');
            Route::post('popuphome/update', [PopuphomeController::class, 'update'])->name('update');
        }
    );

    //////comment
    Route::group(
        [
            'prefix' => 'comment',
            'as' => 'comment.',
        ],
        function () {
            Route::get('/comment', [UserReviewController::class, 'index'])->name('index');
            Route::post('/comment/{id}/reply', [UserReviewController::class, 'reply'])->name('reply');
        }
    );

    // Export Import
    Route::group([
        'prefix' => 'export-import',
        'as' => 'export-import.'
    ], function () {
        Route::get('/', [ExportImportController::class, 'exportAndImport'])->name('view-export-import');
        // export
        Route::get('export-category', [ExportImportController::class, 'exportCategory'])->name('exportCategory');
        Route::post('export-categories', [ExportImportController::class, 'exportCategories'])->name('exportCategories');

        Route::get('export-product', [ExportImportController::class, 'exportProduct'])->name('exportProduct');
        Route::post('export-products', [ExportImportController::class, 'exportProducts'])->name('exportProducts');

        Route::get('export-post', [ExportImportController::class, 'exportPost'])->name('exportPost');
        Route::post('export-posts', [ExportImportController::class, 'exportPosts'])->name('exportPosts');

        // import
        Route::get('import-category', [ExportImportController::class, 'importCategory'])->name('importCategory');
        Route::post('import-categories', [ExportImportController::class, 'importCategories'])->name('importCategories');

        Route::get('import-product', [ExportImportController::class, 'importProduct'])->name('importProduct');
        Route::post('import-products', [ExportImportController::class, 'importProducts'])->name('importProducts');

        Route::get('import-post', [ExportImportController::class, 'importPost'])->name('importPost');
        Route::post('import-posts', [ExportImportController::class, 'importPosts'])->name('importPosts');
    });

    // Email
    Route::group([
        'prefix' => 'email',
        'as' => 'email.'
    ], function () {
        Route::get('/', [EmailController::class, 'viewEmail'])->name('viewEmail');
        Route::post('send-email', [EmailController::class, 'sendEmail'])->name('sendEmail');
    });
    Route::prefix('feedbacks')->group(function () {
        Route::get('/', [FeedbackController::class, 'index'])->name('feedbacks.index');
        Route::get('/{feedback_id}', [FeedbackController::class, 'show'])->name('feedbacks.show');
        Route::patch('/{feedback_id}/update-status', [FeedbackController::class, 'updateStatus'])->name('feedbacks.updateStatus');
        Route::delete('/{id}', [FeedbackController::class, 'destroy'])->name('feedbacks.destroy');
        Route::get('/soft-deleted', [FeedbackController::class, 'showSoftDeleted'])->name('feedbacks.deleted');
        Route::patch('/restore/{id}', [FeedbackController::class, 'restore'])->name('feedbacks.restore');
        Route::delete('/{id}/hard-delete', [FeedbackController::class, 'hardDelete'])->name('feedbacks.hardDelete');
        Route::delete('/content/{id}', [FeedbackController::class, 'destroyContent'])->name('feedbackContent.destroy');
        Route::delete('/content/{id}/hard-delete', [FeedbackController::class, 'hardDeleteContent'])->name('feedbackContent.hardDelete');
        Route::post('/delete-multiple', [FeedbackController::class, 'deleteMultiple'])->name('feedbacks.deleteMultiple');
    });
});
Route::get('/admin/logs',                       [AdminActivityLogController::class, 'index'])->name('admin.logs.index');
