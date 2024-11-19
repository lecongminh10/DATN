<?php

namespace App\Providers;

use App\Models\Announcement;
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
    // view()->composer('*', function ($view) {
    //     $view->with('announcements', Announcement::first());
    // });
}
}
