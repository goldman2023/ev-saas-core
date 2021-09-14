<?php

namespace App\Providers;

use Illuminate\Container\Container;
use App\Http\Services\CategoryService;
use Illuminate\Support\ServiceProvider;
use App\Http\Services\EVService;
use App\Http\Services\BusinessSettingsService;
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
        $this->app->singleton('ev', function($app) {
            return new EVService($app);
        });

        // Register BusinessSetting Service Singleton
        $this->app->singleton('business_settings', function() {
            return new BusinessSettingsService(fn () => Container::getInstance());
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
