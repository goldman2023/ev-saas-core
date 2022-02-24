<?php

namespace App\Providers;

use App\Models\Shop;
use DebugBar\DebugBar;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Qirolab\Theme\Theme;
use Categories;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        View::composer('*', function ($view) {
            /* Check if it's not central app */
            if (tenant() != null) {
                // $view->with('categories', Categories::getAll());
            }
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
