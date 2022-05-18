<?php

namespace App\Providers;

use Codexshaper\WooCommerce\WooCommerceApi;
use Illuminate\Support\ServiceProvider;
use Codexshaper\WooCommerce\WooCommerceServiceProvider as Woo;
use Illuminate\Support\Facades\Log;

class WooCommerceServiceProvider extends Woo
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {

        $this->publishes([
            __DIR__.'/config/woocommerce.php' => config_path('woocommerce.php'),
        ], 'woocommerce');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        /* TODO: @vukasin load these configs from tenant settings */
        $this->mergeConfigFrom(
            __DIR__.'/../../config/woocommerce.php',
            'woocommerce'
        );

        $this->app->singleton('WooCommerceApi', function () {
            return new WooCommerceApi();
        });


        $this->app->alias('Codexshaper\Woocommerce\WooCommerceApi', 'WooCommerceApi');
    }
}
