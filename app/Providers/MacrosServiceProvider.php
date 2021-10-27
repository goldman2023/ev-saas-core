<?php

namespace App\Providers;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use App\Support\MacroableModels;
use Categories;

class MacrosServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Builder::macro('restrictByCategories', function($categories) {
            // Pass categories_ids to Eloquent Builder by pointer!
            Categories::restrictByCategories($categories, $this);
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
