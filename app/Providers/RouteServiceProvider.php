<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapAdminRoutes();

        $this->mapWebRoutes();
    }

    protected function mapUpdateRoutes()
    {
        Route::middleware('web')
       ->namespace($this->namespace)
       ->group(base_path('routes/update.php'));
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        /**
         * Error: php artisan route:cache (names of different routes already exist)
         *
         * Fix: Only one central domain
         *
         * Explanation (From Laravel Tenancy: https://tenancyforlaravel.com/docs/v3/routes):
         * If you're using multiple central domains, you can't use route names,
         * because different routes (= different combinations of domains & paths) can't share the same name.
         * If you need to use a different central domain for testing, use config()->set() in your TestCase setUp().
         */
        foreach ($this->centralDomains() as $domain) {
            Route::middleware('web')
                ->domain($domain)
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        }
    }

    /**
     * Define the "admin" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapAdminRoutes()
    {
        Route::middleware('web')
       ->namespace($this->namespace)
       ->group(base_path('routes/admin.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        /**
         * Error: php artisan route:cache (names of different routes already exist)
         *
         * Fix: Only one central domain
         *
         * Explanation (From Laravel Tenancy: https://tenancyforlaravel.com/docs/v3/routes):
         * If you're using multiple central domains, you can't use route names,
         * because different routes (= different combinations of domains & paths) can't share the same name.
         * If you need to use a different central domain for testing, use config()->set() in your TestCase setUp().
         */
        foreach ($this->centralDomains() as $domain) {
            Route::prefix('api')
                ->domain($domain)
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));
        }
    }

    protected function centralDomains(): array
    {
        return config('tenancy.central_domains');
    }
}
