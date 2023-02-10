<?php

namespace App\Providers;

use App\WeEngine\WeEngine;
use App\Http\Services\EVService;
use App\Http\Services\FXService;
use App\Http\Services\CartService;
use Illuminate\Support\Collection;
use App\Http\Services\MediaService;
use Illuminate\Container\Container;
use App\Http\Services\MailerService;
use App\Http\Services\MyShopService;
use App\Http\Services\StripeService;
use App\Http\Services\VendorService;
use App\Http\Services\CountryService;
use App\Http\Services\WeThemeService;
use Illuminate\Support\Facades\Blade;
use App\Http\Services\CategoryService;
use App\Http\Services\IMGProxyService;
use App\Http\Services\WeEngineService;
use App\Http\Services\WeBuilderService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use App\Http\Services\AttributesService;
use App\Http\Services\TenantSettingsService;


class WeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Add EV dynamic components to EV namespace
        // DEPRECATED!
        Blade::componentNamespace('App\\View\\Components\\EV', 'ev');

        $this->bootDefaultWeTheme();

        // MyShop
        $this->app->singleton('myshop', function() {
            return new MyShopService(fn () => Container::getInstance());
        });

        // Register Media Singleton
        $this->app->singleton('media_service', function() {
            return new MediaService(fn () => Container::getInstance());
        });

        // Register Mailer Singleton
        $this->app->singleton('mailer_service', function() {
            return new MailerService(fn () => Container::getInstance());
        });

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

        // Register Attributes Service Singleton
        $this->app->singleton('ev_attributes', function() {
            return new AttributesService(fn () => Container:: getInstance());
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

        // Register Cart Singleton
        $this->app->singleton('cart', function() {
            return new CartService(fn () => Container::getInstance());
        });

        // Register Countries Singleton
        $this->app->singleton('ev_countries', function() {
            return new CountryService(fn () => Container::getInstance());
        });

        // WeBuilder
        $this->app->singleton('we_builder_sections', function() {
            return new WeBuilderService(fn () => Container::getInstance());
        });

        // Register Countries Singleton
        $this->app->singleton('stripe_service', function() {
            return new StripeService(fn () => Container::getInstance());
        });

        // WeEngine
        $this->app->singleton('we_engine', function() {
            return new WeEngine(fn () => Container::getInstance());
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
    
    /**
     * bootDefaultWeTheme
     *
     * This method registered a singleton `we_theme_service` which boots default theme (WeTailwind) first.
     * Singleton `we_theme_service` will be overriden by registering the same singleton in WeThemeFunctionsServiceProvider if current theme has it.
     * Otherwise, it'll stay as WeTailwind
     * 
     * @return void
     */
    protected function bootDefaultWeTheme() {
        $theme_root = base_path() . '/themes/WeTailwind';
        $theme_helpers = $theme_root . '/App/Helpers/';
        $theme_name = basename($theme_root);
        $theme_root_class = 'WeThemes\\'.$theme_name;

        $theme_data = [
            'theme_name' => $theme_name,
            'theme_root_class' => $theme_root_class,
            'theme_root_path' => $theme_root,
            'theme_root_helpers_path' => $theme_helpers,
        ];

        $this->app->singleton('we_theme_service', function() use ($theme_data) {
            return new WeThemeService(fn () => Container::getInstance(), $theme_data);
        });
    }
}
