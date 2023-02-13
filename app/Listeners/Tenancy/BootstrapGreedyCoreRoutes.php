<?php

namespace App\Listeners\Tenancy;

use App;
use WeTheme;
use Qirolab\Theme\Theme;
use App\Http\Middleware\SetDashboard;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Events\TenancyBootstrapped;

/**
 * BootstrapGreedyCoreRoutes
 * 
 * In this listener we append greedy core routes to routes list after tenant is initialized and after theme routes are added!
 */
class BootstrapGreedyCoreRoutes
{
    public static $controllerNamespace = '\App\Http\Controllers';

    public function handle(TenancyBootstrapped $event)
    { 
        $this->mapGreedyCoreRoutes();
    }

    protected function mapGreedyCoreRoutes()
    {
        /* Note: Do not include central app routes here ever. Because of midlewares applied in: makeTenancyMiddlewareHighestPriority */
        if (file_exists(base_path('routes/greedy-tenant.php'))) {
            Route::namespace(static::$controllerNamespace)
                ->middleware([
                    \Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains::class,
                ])
                ->group(base_path('routes/greedy-tenant.php'));
        }

        if (file_exists(base_path('routes/greedy-dashboard.php'))) {
            Route::namespace(static::$controllerNamespace)
                ->middleware([
                    \Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains::class,
                    SetDashboard::class,
                ])
                ->group(base_path('routes/greedy-dashboard.php'));
        }
    }
}