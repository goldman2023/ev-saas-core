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

        /* Add Collection RecursiveApply marco function */
        Collection::macro('recursiveApply', function ($property_name, $method = []) {
            return $this->whenNotEmpty($recursive = function (&$items) use (&$recursive, $property_name, $method) {

                if($items->isEmpty()) {
                    return null;
                }

                $items = $items->{$method['fn']}(...$method['params']);

                foreach($items as &$item) {
                    $new_items = $item->{$property_name};
                    $item->{$property_name} = $recursive($new_items);
                }

                return $items;
            });
        });

        /* Add Collection RecursiveFind marco function */
        Collection::macro('recursiveFind', function ($property_name, $key, $value) {
            return $this->whenNotEmpty($recursive = function (&$items) use (&$recursive, $property_name, $key, $value) {

                if(empty($items) || @$items->isEmpty()) {
                    return null;
                }

                $target = $items->where($key, $value)->first();

                if(empty($target)) {
                    foreach($items as &$item) {
                        $new_items = $item->{$property_name};
                        $obj = $recursive($new_items);
                        if(empty($obj)) {
                            continue;
                        }
                        return $obj;
                    }
                }

                return $target;
            });
        });

        /* Add Collection FlattenTree marco function */
        Collection::macro('flattenTree', function ($childrenField) {
            $result = collect();

            foreach ($this->items as $item) {
                $result->push($item);

                if ($item->{$childrenField} instanceof Collection && $item->{$childrenField}->isNotEmpty()) {
                    $result = $result->merge($item->{$childrenField}->flattenTree($childrenField));
                }
            }

            return $result;
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