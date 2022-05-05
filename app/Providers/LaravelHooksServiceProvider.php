<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Support\Hooks;

class LaravelHooksServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        //
    }

    /**
     * Register all directives.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('hooks', function ($app) {
            return new Hooks();
        });
    }
}