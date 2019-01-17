<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
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
        Schema::defaultStringLength(191);
        /* Custom component for datatables */
        Blade::component('components.DTGeneric');

        /* Make the route name available on all pages so we can have a user-friendly title */
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
