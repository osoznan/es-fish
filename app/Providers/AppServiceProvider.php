<?php

namespace App\Providers;

use App\Components\BasketManager;
use App\Components\CartManagerAuth;
use App\Components\helpers\Telegram;
use App\Components\OrderManager;
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
        $this->app->bind('basket.service', function ($app) {
            return auth()->user() ? new CartManagerAuth() : new BasketManager();
        });
        $this->app->bind('order.service', function ($app) {
            return new OrderManager();
        });
        $this->app->bind('telegram.service', function ($app) {
            return new Telegram();
        });

        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }
}
