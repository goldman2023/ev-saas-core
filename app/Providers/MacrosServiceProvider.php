<?php

namespace App\Providers;

use App\Builders\ProductsBuilder;
use App\Models\Product;
use Illuminate\Cache\Repository;
use Illuminate\Database\Eloquent\Relations\Relation;
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
        $this->setRouteMacros();
        $this->setEloquentBuilderMacros();
        $this->setEloquentRelationMacros();
        $this->setCollectionMacros();
        $this->setCacheRepositoryMacros();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    protected function setRouteMacros(): void
    {

    }

    protected function setCacheRepositoryMacros(): void {
        // These macros are used like this: Cache::store()->{macro()}; (NOT like this: Cache::{macro()})
        // Reason for that is: We cannot register macros to CacheManager class (Cache facade), only Cache\Repository class (Cache::store() object/class) - #justLaravelThings

        Repository::macro('getModelCacheKey', function($model_class, $model_id) {
            return tenant()->id.'-'.($model_class).'-'.$model_id;
            // e.g. 5469dff5-3707-417d-b152-d9950de45daf-App\Models\Product-7
        });
    }

    protected function setCollectionMacros(): void
    {
        /* Add Collection RecursiveApply marco function */
        Collection::macro('recursiveApply', function ($property_name, $method = []) {
            return $this->whenNotEmpty($recursive = function (&$items) use (&$recursive, $property_name, $method) {

                if($items->isEmpty()) {
                    return [];
                }

                $items = $items->{$method['fn']}(...$method['params']);

                foreach($items as &$item) {
                    $new_items = $item->{$property_name};
                    $item->{$property_name} = $recursive($new_items);
                }

                return $items;
            });
        });

        // Static version of `recursiveApply` function. Collections, arrays and objects can be used as $items!
        Collection::macro('recursiveApplyStatic', function ($items, $property_name, $method = []) {
            // If given $items are Collection type, call `recursiveApply` macro
            if($items instanceof Collection) {
                return $items->recursiveApply($property_name, $method);
            }

            $recursive = function (&$items, $property_name, $method) use (&$recursive) {

                if(empty($items)) {
                    return [];
                }

                $items = collect($items)->{$method['fn']}(...$method['params'])->all();

                foreach($items as &$item) {
                    if(is_object($item)) {
                        $new_items = $item->$property_name;
                        $item->$property_name = $recursive($new_items, $property_name, $method);
                    } else if(is_array($item)) {
                        $new_items = $item[$property_name];
                        $item[$property_name] = $recursive($new_items, $property_name, $method);
                    }
                }

                return $items;
            };

            return $recursive($items, $property_name, $method);
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

        // Change all Models `connection` property (usually needed for Livewire collections manipulations)
        \Illuminate\Database\Eloquent\Collection::macro('setConnection', function() {
            return $this->map(function($item, $key) {
                return $item->setConnection(config('tenancy.database.tenant_connection'));
            });
        });
    }

    protected function setEloquentBuilderMacros(): void
    {
        Builder::macro('restrictByCategories', function($categories) {
            // Pass categories_ids to Eloquent Builder by pointer!
            Categories::restrictByCategories($categories, $this);
        });

        // For Builders which use Cacher Trait
        Builder::macro('noCache', function() {
            if(method_exists($this, 'disableCacher')) {
                $this->disableCacher();
            }

            return $this;
        });

        Builder::macro('fromCache', function() {
            if(method_exists($this, 'enableCacher')) {
                $this->enableCacher();
            }

            return $this;
        });
    }

    protected function setEloquentRelationMacros(): void {
        Relation::macro('noCache', function() {
            // Changes here are done by pointer, not by reference!
            $this->getQuery()->noCache();
            // ^^^ IMPORTANT: It looks like applying functions to the Builder with getQuery()->{chained fs), actually changes Builder used for relation by reference!
            return $this;
        });
        Relation::macro('fromCache', function() {
            // Changes here are done by pointer, not by reference!
            $this->getQuery()->fromCache();
            // ^^^ IMPORTANT: It looks like applying functions to the Builder with getQuery()->{chained fs), actually changes Builder used for relation by reference!
            return $this;
        });
    }
}
