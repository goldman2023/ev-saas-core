<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Qirolab\Theme\Theme as Theme;

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

            // Get tenant info
            // dd(tenant());
            // $domain =
            $domain = Cache::remember('domain_'.tenant()->id, 60 * 60 * 24, function () {
                return tenant()->domains()->first();
            });

            /* TODO: Make this to run somewhere else, but this fixes the real time facades issues */
            tenant()->run(function ($tenant) {
                $storage_path = storage_path();
                try {
                    mkdir("$storage_path/framework/", 0775, true);
                    mkdir("$storage_path/framework/cache", 0775, true);
                } catch (\Exception $e) {
                }
            });

            if ($domain) {
                // Set active theme
                /* Set parent theme for tailwind child themes */
                if (str_contains($domain->theme, 'tailwind')) {
                    Theme::set($domain->theme, 'EvTailwind');

                    session(['style_framework' => 'tailwind']);

                /*
                    TODO: Define this better but dashboard allways uses boostrap version for now
                */
                } else {
                    Theme::set($domain->theme, 'EvTailwind');
                    session(['style_framework' => 'tailwind']);
                }
            }
        }

        // NOTE: Check if this approach is OK...

        // if(request()->is('dashboard') || request()->is('dashboard/*')) {
        //     session(['style_framework' => 'bootstrap']);
        // }

        // if(request()->is('livewire/*') && str_contains(request()->header('referer'), 'dashboard')) {
        //     // Is a livewire request? - Is it a 1) livewire request from dashboard or 2) from frontend?
        //     session(['style_framework' => 'bootstrap']);
        // }

        return $next($request);
    }
}
