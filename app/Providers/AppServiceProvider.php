<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Category;

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
        view()->composer(['home', 'cart', 'result', 'auth/login', 'auth/register', 'details', 'products/categories', 'purchase'], function($view) {
            $view->with('menus', Category::menus());
        });

        if(config('app.env') === 'production') {
            \URL::forceScheme('https');
        }
    }
}
