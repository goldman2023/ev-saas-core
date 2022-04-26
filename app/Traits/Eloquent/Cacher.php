<?php

namespace App\Traits\Eloquent;

use App\Builders\ProductsBuilder;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use LogicException;
use Str;

trait Cacher
{
    public string $cacher_scope_identifier = 'force_cached_data';

    public bool $from_cache = false;

    public array $applied_named_scopes = [];

    /**
     * Init Cacher
     *
     * @return void
     */
    public function enableCacher(): void
    {
        $this->from_cache = true;

        // Select only IDs (because models themselves will be fetched from cache based on corresponding cache keys)
        $this->withGlobalScope($this->cacher_scope_identifier, function (Builder $builder) {
            $builder->select($builder->getModel()->getTable().'.id');
        });
    }

    //
    public function disableCacher(): void
    {
        $this->from_cache = false;
        $this->withoutGlobalScope($this->cacher_scope_identifier);
    }

    /**
     * Execute the query as a "select" statement.
     *
     * @param  array|string  $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function get($columns = ['*'])
    {
        $builder = $this->applyScopes(); //$this->applyScopes();

        // If we actually found models we will also eager load any relationships that
        // have been specified as needing to be eager loaded, which will solve the
        // n+1 query issue for the developers to avoid running a lot of queries.
        if (count($models = $builder->getModels($columns)) > 0) {
            $models = $builder->eagerLoadRelations($models);
        }

        return $builder->getModel()->newCollection($models);
    }

    /**
     * Get the hydrated models without eager loading.
     *
     * @param  array|string  $columns
     * @return \Illuminate\Database\Eloquent\Model[]|static[]
     */
    public function getModels($columns = ['*'])
    {
        // DO NOT FORWARD THE CALL USING THE $this->model->hydrate(...), instead use current builder!!! $this->>hydrate(...)
        return $this->hydrate(
            $this->query->get($columns)->all()
        )->all();
    }

    /**
     * Create a collection of models from plain arrays based on data from cache or DB
     *
     * @param  array  $items
     * @return Collection
     */
    public function hydrate(array $items)
    {

        // $items are sorted based on SQL query. $items may be just IDs
        if ($this->from_cache) {
            $instance = $this->newModelInstance();

            // $items are only Model IDs in this case, because the 'force_cached_data' scope is active($cacher_scope_identifier).
            // We'll
            $cache_keys = [];
            foreach ($items as $item) {
                if (! empty($item->id)) {
                    $cache_keys[] = $this->generateModelCacheKey($item->id ?? null);
                }
            }

            // Get the data from Cache
            $cached_models = new Collection(Cache::store()->many($cache_keys)); // contains both present models and missing models (key=>empty)

            // Check which caches are missing
            $missing_models = $cached_models->filter(function ($value, $key) {
                return empty($value);
            });

            //If there are missing models from the Cache, get them directly from the DB and save them to Cache!
            if ($missing_models->isNotEmpty()) {
                $missing_ids = [];
                foreach ($missing_models as $key => $value) {
                    $missing_ids[] = $this->generateModelCacheKey($key, true);
                }

                // We have the missing IDs now, so we are going to fetch models with IDs using fresh noCache Builder
                $missing_builder = $this->getModel()->noCache()->whereIn($this->getModel()->getTable().'.id', $missing_ids);
                $missing_items = $missing_builder->get()->keyBy(function ($item) {
                    // Store missing models in cache!
                    $item->cache()->regenerate(60 * 60 * 24 * 5, true);

                    // Change key to use model cache key so we can properly merge $cached_models with $missing_items
                    return $this->generateModelCacheKey($item->id);
                });

                // Merge missing models with already cached using generated cache key and reset keys to start from 0 onward
                return new Collection(collect($cached_models)->merge($missing_items)->values());
            }

            return $cached_models->values();
        }

        return parent::hydrate($items);
    }

    public function generateModelCacheKey($model_id, bool $reverse = false, $cast_to = 'int'): mixed
    {
        if ($reverse) {
            $id = Str::replace(tenant('id').'-'.($this->getModel()::class).'-', '', $model_id);
            settype($id, $cast_to);

            return $id;
        }

        return tenant('id').'-'.($this->getModel()::class).'-'.$model_id;
    }
}
