<?php

namespace App\Providers;

use App\Models\Shop;
use App\Rules\IfIDExists;
use App\Rules\MatchPassword;
use DebugBar\DebugBar;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Qirolab\Theme\Theme;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Schema::defaultStringLength(191);
        Paginator::useBootstrap();

        if ($this->app->environment('production')) {
            \URL::forceScheme('https');
        }

        $this->registerCustomValidaionRules();

        \App\Builders\BaseBuilder ::macro('reorder', function ($column = null, $direction = 'asc') {
            $this->orders = null;
            $this->unionOrders = null;
            $this->bindings['order'] = [];
            $this->bindings['unionOrder'] = [];
            
            if ($column) {
               return $this->orderBy($column, $direction);
            }
         
            return $this;
         });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (config('app.debug_bar')) {
            \Debugbar::enable();
        } else {
            \Debugbar::disable();
        }
    }

    public function registerCustomValidaionRules()
    {
        Validator::extend('is_true', function ($attribute, $value, $parameters, $validator) {
            return $value === true;
        });

        Validator::extend('match_password', function ($attribute, $value, $parameters, $validator) {
            return (new MatchPassword($parameters, $validator))->passes($attribute, $value);
        });

        Validator::extend('if_id_exists', function ($attribute, $value, $parameters, $validator) {
            return (new IfIDExists($parameters, $validator))->passes($attribute, $value);
        });

        Validator::extend('check_array', function ($attribute, $value, $parameters, $validator) {
            return count(array_filter($value, function ($var) use ($parameters) {
                return ($var && $var >= $parameters[0] && strlen($var) >= $parameters[1]);
            }));
        });
    }
}
