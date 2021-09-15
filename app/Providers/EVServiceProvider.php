<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use App\Http\Services\EVService;
use Blade;

class EVServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Add EV dynamic components to EV namespace
        Blade::componentNamespace('App\\View\\Components\\EV', 'ev');

        // Register EV Facade
        \App::bind('ev', function() {
            return new EVService();
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
