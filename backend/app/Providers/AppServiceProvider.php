<?php

namespace App\Providers;

use App\Models\Announcement;
use Carbon\Carbon;
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
}
}
