<?php

namespace App\Providers;

use Illuminate\Container\Container;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use App\Facades\PaymentMethodsUniversal;

class PaymentMethodsProvider extends ServiceProvider
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

        // Register Universal Payment Methods Service singleton
        $this->app->singleton('universal_payment_methods', function() {
            return new PaymentMethodsUniversal(fn () => Container::getInstance());
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
