<?php

namespace App\Providers;

use App\Http\Services\WEFService;
use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;

class WEFServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // WEFs
        $this->app->singleton('wef_service', function() {
            return new WEFService(fn () => Container::getInstance());
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
