<?php

namespace App\Providers;

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
    public function boot(): void
    {
        \Illuminate\Support\Facades\View::composer('partials.header', function ($view) {
            $view->with('globalCategories', \App\Models\Category::all());
        });
        // hiện phân trang theo Bootstrap 5
        // Thêm dòng này để phân trang hiển thị đẹp theo Bootstrap 5
        \Illuminate\Pagination\Paginator::useBootstrapFive();
    }
}
