<?php

namespace App\Traits\Caching;

use App\Support\CacheRegenerator;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use LogicException;

trait RegeneratesCache
{
    /**
     * Cache Regenerator instance.
     *
     * @var CacheRegenerator|null
     */
    protected ?CacheRegenerator $regenerator = null;

    /**
     * Returns a cache regenerator.
     *
     * @return CacheRegenerator
     */
    public function cache(): CacheRegenerator
    {
        return $this->regenerator ??= app(CacheRegenerator::class, [
            'object' => $this,
            'store' => $this->defaultCacheStore(),
            'key' => $this->defaultCacheKey(),
        ]);
    }

    /**
     * Saves the current object to the cache.
     *
     * @param  string|null  $key
     * @param  \DateTimeInterface|\DateInterval|int|null  $ttl
     * @return bool
     */
    public function saveToCache(string $key = null, $ttl = 60): bool
    {
        return $this->defaultCacheStore()->put($key ?? $this->defaultCacheKey(), $this->toCache(), $ttl);
    }

    /**
     * The Cache Store to use to store this object.
     *
     * @return Repository
     */
    protected function defaultCacheStore() : Repository
    {
        return Cache::store();
    }

    /**
     * The cache key name to use by default.
     *
     * @return string
     */
    public function defaultCacheKey() : string
    {
        /* Default Cache key for the Modal */
        if ($this instanceof Model) {
            return Cache::store()->getModelCacheKey($this::class, $this->id);
        }

        throw new LogicException('The class '.static::class.' has no default cache key.');
    }

    /**
     * The data to insert into the cache.
     *
     * @return $this
     */
    public function toCache()
    {
        return $this;
    }
}
