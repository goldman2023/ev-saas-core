<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Theme
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


        // Get tenant info
        $domain = tenant()->domains()->first();

        if($domain) {
            // Set active theme
            \Qirolab\Theme\Theme::set($domain->theme);
        }


        return $next($request);
    }
}
