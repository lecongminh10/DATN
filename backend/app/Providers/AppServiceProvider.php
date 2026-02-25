<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\Page;
use App\Observers\OrderObserver;
use App\Models\Announcement;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Thiết lập ngôn ngữ mặc định của Carbon là tiếng Việt
        Carbon::setLocale('vi');
        Order::observe(OrderObserver::class);

        // Tự động chia sẻ danh sách trang (pages) tới tất cả views client
        View::composer('client.*', function ($view) {
            if (!isset($view->getData()['pages'])) {
                $pages = Page::where('is_active', true)
                    ->select('name', 'permalink')
                    ->get();
                $view->with('pages', $pages);
            }
        });
    }

}
