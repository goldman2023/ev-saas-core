<?php
namespace App\Traits\Eloquent;

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
    public bool $from_cache;

    /**
     * Initialize the trait
     *
     * @return void
     */
    public function initCacher(): void
    {
        $this->from_cache = true;

        // Select only IDs
        $this->withGlobalScope($this->cacher_scope_identifier, function (Builder $builder) {
            $builder->select($builder->getModel()->getTable().'.id');
        });
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
        if($this->from_cache) {
            $instance = $this->newModelInstance();

            // $items are only Model IDs in this case, because the 'force_cached_data' scope is active($cacher_scope_identifier).
            // We'll
            $cache_keys = [];
            foreach($items as $item) {
                if(!empty($item->id)) {
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
            if($missing_models->isNotEmpty()) {
                $missing_ids = [];
                foreach($missing_models as $key => $value) {
                    $missing_ids[] = $this->generateModelCacheKey($key, true);
                }

                $missing_builder = $this->nocache()->applyScopes()->whereIn($this->getModel()->getTable().'.id', $missing_ids);
                $missing_items = $missing_builder->getQuery()->get()->all();

                $missing_collection = $instance->newCollection(array_map(function ($item) use ($missing_items, $instance) {
                    $model = $instance->newFromBuilder($item);

                    if (count($missing_items) > 1) {
                        $model->preventsLazyLoading = Model::preventsLazyLoading();
                    }

                    return $model;
                }, $missing_items))->keyBy(function ($item) {
                    // Store missing models in cache!
                    $item->cache()->regenerate(60 * 60 * 24 * 5, true);

                    // Change key to use model cache key
                    return $this->generateModelCacheKey($item->id);
                });

                // Merge missing models with already cached using generated cache key and reset keys to start from 0 onward
                return new Collection(collect($cached_models)->merge($missing_collection)->values());
            }

            return $cached_models->values();
        }

        return parent::hydrate($items);
    }

    public function generateModelCacheKey($model_id, bool $reverse = false, $cast_to = 'int'): mixed
    {
        if($reverse) {
            $id = Str::replace(tenant()->id.'-'.get_class($this->getModel()).'-', '', $model_id);
            settype($id, $cast_to);

            return $id;
        }

        return tenant()->id.'-'.get_class($this->getModel()).'-'.$model_id;
    }
}
