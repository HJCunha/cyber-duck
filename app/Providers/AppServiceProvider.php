<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            $route = \Request::route();
            $current_route_name = "Page";
            if (!empty($route)) {
                $current_route_name = \Request::route()->getName();
            }

            $view->with('current_route_name', $current_route_name);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
