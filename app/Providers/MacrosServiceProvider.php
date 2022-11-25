<?php

namespace App\Providers;

use App\Builders\ProductsBuilder;
use App\Models\Product;
use App\Support\MacroableModels;
use Categories;
use Illuminate\Cache\Repository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Routing\Route;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;


class MacrosServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
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

    protected function setCacheRepositoryMacros(): void
    {
        // These macros are used like this: Cache::store()->{macro()}; (NOT like this: Cache::{macro()})
        // Reason for that is: We cannot register macros to CacheManager class (Cache facade), only Cache\Repository class (Cache::store() object/class) - #justLaravelThings

        Repository::macro('getModelCacheKey', function ($model_class, $model_id) {
            return tenant('id').'-'.($model_class).'-'.$model_id;
            // e.g. 5469dff5-3707-417d-b152-d9950de45daf-App\Models\Product-7
        });
    }

    protected function setCollectionMacros(): void
    {
        /* Add Collection RecursiveApply marco function */
        Collection::macro('recursiveApply', function ($property_name, ...$method) {
            return $this->whenNotEmpty($recursive = function (&$items) use (&$recursive, $property_name, $method) {
                if ($items->isEmpty()) {
                    return collect([]);
                }

                foreach ($method as $m) {
                    $items = $items->{$m['fn']}(...$m['params']);
                }

                foreach ($items as $key => &$item) {
                    if ($item->relationLoaded($property_name)) {
                        // if relation
                        $item->setRelation($property_name, $recursive($item->{$property_name}));
                    } else {
                        // if property
                        $item->{$property_name} = $recursive($item->{$property_name});
                    }
                }

                return $items;
            });
        });

        // Static version of `recursiveApply` function. Models, Collections, arrays and objects can be used as $items!
        Collection::macro('recursiveApplyStatic', function ($items, $property_name, ...$method) {
            // If given $items are Collection type, call `recursiveApply` macro
            if ($items instanceof Collection) {
                return $items->recursiveApply($property_name, $method);
            }

            $recursive = function (&$items, $property_name, $methods) use (&$recursive) {
                if (empty($items)) {
                    return [];
                }

                foreach ($methods as $m) {
                    $items = collect($items)->{$m['fn']}(...$m['params'])->all();
                }

                foreach ($items as &$item) {
                    if ($item instanceof Model) {
                        if ($item->relationLoaded($property_name)) {
                            $item->setRelation($property_name, $recursive($item->{$property_name}, $property_name, $methods));
                        } else {
                            $item->{$property_name} = $recursive($item->{$property_name}, $property_name, $methods);
                        }
                    } elseif (is_object($item)) {
                        $item->$property_name = $recursive($item->$property_name, $property_name, $methods);
                    } elseif (is_array($item)) {
                        $item[$property_name] = $recursive($item[$property_name], $property_name, $methods);
                    }
                }

                return $items;
            };

            return $recursive($items, $property_name, $method); // $method here is actually an array of methods because in macro function we have ...$method
        });

        /* Add Collection RecursiveFind marco function */
        Collection::macro('recursiveFind', function ($property_name, $key, $value) {
            return $this->whenNotEmpty($recursive = function (&$items) use (&$recursive, $property_name, $key, $value) {
                if (empty($items) || @$items->isEmpty()) {
                    return null;
                }

                $target = $items->where($key, $value)->first();

                if (empty($target)) {
                    foreach ($items as &$item) {
                        $new_items = $item->{$property_name};
                        $obj = $recursive($new_items);
                        if (empty($obj)) {
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

        Collection::macro('sortByOrderProperty', function () {
            return $this->sortBy(function ($item) {
                if (!isset($item['order']) || empty($item['order'] ?? null) || (isset($item['order']) && $item['order'] == 0)) {
                    return PHP_INT_MAX;
                }

                return $item['order'];
            });
        });

        // Change all Models `connection` property (usually needed for Livewire collections manipulations)
        \Illuminate\Database\Eloquent\Collection::macro('setConnection', function () {
            return $this->map(function ($item, $key) {
                return $item->setConnection(config('tenancy.database.tenant_connection'));
            });
        });
    }

    protected function setEloquentBuilderMacros(): void
    {
        Builder::macro('restrictByCategories', function ($categories) {
            // Pass categories_ids to Eloquent Builder by pointer!
            Categories::restrictByCategories($categories, $this);
        });

        // For Builders which use Cacher Trait
        Builder::macro('noCache', function () {
            if (method_exists($this, 'disableCacher')) {
                $this->disableCacher();
            }

            return $this;
        });

        Builder::macro('fromCache', function () {
            if (method_exists($this, 'enableCacher')) {
                $this->enableCacher();
            }

            return $this;
        });

        Str::macro('readDuration', function(...$text) {
            $totalWords = str_word_count(implode(" ", $text));
            $minutesToRead = round($totalWords / 200);

            return (int)max(1, $minutesToRead);
        });
    }

    protected function setEloquentRelationMacros(): void
    {
        Relation::macro('noCache', function () {
            // Changes here are done by pointer, not by reference!
            $this->getQuery()->noCache();
            // ^^^ IMPORTANT: It looks like applying functions to the Builder with getQuery()->{chained fs), actually changes Builder used for relation by reference!
            return $this;
        });
        Relation::macro('fromCache', function () {
            // Changes here are done by pointer, not by reference!
            $this->getQuery()->fromCache();
            // ^^^ IMPORTANT: It looks like applying functions to the Builder with getQuery()->{chained fs), actually changes Builder used for relation by reference!
            return $this;
        });
    }
}
