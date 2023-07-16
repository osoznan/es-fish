<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        // Specify available languages for routes.
        Route::pattern('locale', \implode('|', ['ru', 'en', 'ua']));

        Route::matched(function (RouteMatched $event) {

            // Get language from route.
            $locale = $event->route->parameter('locale');

            // Ensure, that all built urls would have "_locale" parameter set from url.
            url()->defaults(array('locale' => $locale));

            // Change application locale.
            app()->setLocale($locale);
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->prefix('{locale}')
                ->group(base_path('routes/web.php'));
        });
    }
}
