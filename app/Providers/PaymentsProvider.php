<?php

namespace App\Providers;

use App\Http\Services\PaymentsService;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class PaymentsProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Register PaymentsService singleton
        $this->app->singleton('payments', function () {
            return new PaymentsService(fn () => Container::getInstance());
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
