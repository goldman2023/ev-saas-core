<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container;
use App\Http\Services\CategoryService;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use App\Http\Services\EVService;
use App\Http\Services\BusinessSettingsService;
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

        // Register EV Facade
        $this->app->singleton('ev', function($app) {
            return new EVService($app);
        });

        // Register BusinessSetting Service Singleton
        $this->app->singleton('business_settings', function() {
            return new BusinessSettingsService(fn () => Container::getInstance());
        });

        // Register Categories Service Singleton
        $this->app->singleton('ev_categories', function() {
            return new CategoryService(fn () => Container:: getInstance());
        });


        /* Add Collection Recursive Marco function */
        Collection::macro('recursive_apply', function ($property_name, $method = [], $type = 'array') {
            return $this->whenNotEmpty($recursive = function (&$item, $index = null) use (&$recursive, $property_name, $method, $type) {
                if(is_array($item) && isset($item['id'])) {
                    // Model
                    if(!empty($property_name)) {
                        if($type === 'array') {
                            $item[$property_name] = $recursive($item[$property_name], $property_name);
                        } else {
                            $item = (object) $item;
                            $item->{$property_name} = $recursive($item->{$property_name}, $property_name);
                        }
                    }
                } elseif(is_array($item) && !isset($item['id'])) {
                    $collection = new Collection($item);
                    return $recursive($collection, $index);
                } elseif($item instanceof Collection) {
                    $item = $item->{$method['fn']}(...$method['params']);

                    $item->transform(static function ($collection, $key) use ($recursive, $item, $property_name) {
                        return $item->{$key} = $recursive($collection, $property_name);
                    });
                }

                return $item;
            });
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
