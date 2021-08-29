<?php

namespace App\Providers;

use Blade;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

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
