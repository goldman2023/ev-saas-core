<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use \Qirolab\Theme\Theme as Theme;

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
        if(tenant()) {

        // Get tenant info

            $domain = tenant()->domains()->first();

            if($domain) {
                // Set active theme
                Theme::set($domain->theme);

            }

        }



        return $next($request);
    }
}
