<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\Page;
use App\Models\Order;
use App\Models\Announcement;
use App\Observers\OrderObserver;
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
    }

}
