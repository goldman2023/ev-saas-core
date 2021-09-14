<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;
use App\Http\Services\EVService;
use App\Http\Services\CategoryService;
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

        // Register Categories Service Singleton
        $this->app->singleton('ev_categories', function() {
            return new CategoryService(fn () => Container:: getInstance());
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
