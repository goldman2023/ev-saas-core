<?php

namespace App\Providers;

use App\Http\Services\IMGProxyService;
use App\Http\Services\VendorService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container;
use App\Http\Services\CategoryService;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use App\Http\Services\EVService;
use App\Http\Services\TenantSettingsService;
use App\Http\Services\FXService;
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

        // Register IMG (IMGProxy) Singleton
        $this->app->singleton('imgproxy', function() {
            return new IMGProxyService(fn () => Container::getInstance());
        });

        // Register TenantSetting Service Singleton
        $this->app->singleton('tenant_settings', function() {
            return new TenantSettingsService(fn () => Container::getInstance());
        });

        // Register Categories Service Singleton
        $this->app->singleton('ev_categories', function() {
            return new CategoryService(fn () => Container:: getInstance());
        });

        // Register FX Singleton
        $this->app->singleton('fx', function() {
            return new FXService(fn () => Container::getInstance());
        });

        // Register EV Singleton
        $this->app->singleton('ev', function() {
            return new EVService(fn () => Container::getInstance());
        });

        // Register Vendor Singleton
        $this->app->singleton('vendor', function() {
            return new VendorService(fn () => Container::getInstance());
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
