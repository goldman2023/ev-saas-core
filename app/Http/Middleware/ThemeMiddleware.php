<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Qirolab\Theme\Theme as Theme;
use Illuminate\Container\Container;

class ThemeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if multitenancy is enabled
        if (tenant()) {

            // Check if tenant/theme routes are loaded
            if(((int) $request->header('WE-TENANT-ROUTES-LOADED', 0) === 1) && ((int) $request->header('WE-SKIP-PREV-MIDDLEWARES', 0) === 0)) {
                // Set $request header to skip initialization of tenant again, cuz tenant is already initialized - AND skip other previously done middlewares!
                $request->headers->set('WE-SKIP-PREV-MIDDLEWARES', 1); // set header about skipping prev middlewares to 1
                
                // Since new routes are loaded, send request through router dispatcher again!
                return Container::getInstance()['router']->dispatch($request);
            }

            // Set domain info
            $domain = Cache::remember('domain_'.tenant()->id, 60 * 60 * 24, function () {
                return tenant()->domains()->first();
            });

            if ($domain) {
                Theme::set($domain->theme, 'WeTailwind');
                session(['style_framework' => 'tailwind']);
            }
        }

        return $next($request);
    }
}
