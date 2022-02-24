<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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
                /* Set parent theme for tailwind child themes */
                if(str_contains($domain->theme, 'tailwind')) {
                    Theme::set($domain->theme, 'ev-tailwind');
                    /*
                        TODO: Define this better but dashboard allways uses boostrap version for now
                    */
                    // dd(Route::current());
                    if(isset(Route::current()->action['prefix'])) {
                        if( str_contains(Route::current()->action['prefix'],'dashboard')) {
                            Theme::set('ev-saas-guns', 'ev-saas-default');
                        }
                    };

                } else {
                    Theme::set($domain->theme, 'ev-saas-default');
                }

            }

        }



        return $next($request);
    }
}
