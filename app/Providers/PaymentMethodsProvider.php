<?php

namespace App\Providers;

use Illuminate\Container\Container;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use App\Http\Services\PaymentMethodsUniversalService;

class PaymentMethodsProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Register Universal Payment Methods Service singleton
        $this->app->singleton('universal_payment_methods', function() {
            return new PaymentMethodsUniversalService(fn () => Container::getInstance());
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
