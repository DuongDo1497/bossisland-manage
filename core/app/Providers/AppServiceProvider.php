<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $general = gs();
        $viewShare['general']            = $general;
        $viewShare['emptyMessage']       = 'Data not found';
        view()->share($viewShare);

        Paginator::useBootstrapFour();
    }
}
