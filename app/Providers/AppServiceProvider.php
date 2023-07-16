<?php

namespace App\Providers;

use App\Components\BasketManager;
use App\Components\OrderManager;
use Illuminate\Support\ServiceProvider;
use Yajra\DataTables\Html\Builder;

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
        $this->app->bind('basket.service', function ($app) {
            return new BasketManager();
        });
        $this->app->bind('order.service', function ($app) {
            return new OrderManager();
        });

        Builder::useVite();
    }
}
