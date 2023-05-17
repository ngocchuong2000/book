<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\ParentCategory;
use Illuminate\Support\Facades\View;
use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use App\Models\Author;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        View::share('parentCategories', ParentCategory::all());
        View::share('authors', Author::all());
        View::share('setting', Setting::first());
        view()->composer('admin.layouts.index', function ($view) {
            $data = \DB::select(
                'SELECT DATE_FORMAT(o.created_at,"%d/%m/%Y") order_day, SUM(o.total) total_price FROM orders o WHERE o.status = 2 GROUP BY order_day'
            );
            $data1 =  \DB::select(
                'SELECT MONTH(o.created_at) order_month, SUM(o.total) total_price FROM orders o WHERE o.status = 2 GROUP BY order_month'
            );
            $data2 = \DB::select(
                'SELECT YEAR(o.created_at) order_year, SUM(o.total) total_price FROM orders o WHERE o.status = 2 GROUP BY order_year'
            );
            $view->with(['data' => $data, 'data1' => $data1, 'data2' => $data2]);
        });
    }
}
