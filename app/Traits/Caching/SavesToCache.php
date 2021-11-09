<?php
namespace App\Traits\Caching;

use Illuminate\Contracts\Cache\Repository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use LogicException;

trait SavesToCache
{
    /**
     * Saves the current object to the cache.
     *
     * @param  string|null  $key
     * @param  \DateTimeInterface|\DateInterval|int|null  $ttl
     * @return bool
     */
    public function saveToCache(string $key = null, $ttl = 60): bool
    {
        return $this->defaultCache()->put($key ?? $this->defaultCacheKey(), $this->toCache(), $ttl);
    }

    /**
     * The Cache Store to use to store this object.
     *
     * @return Repository
     */
    protected function defaultCache() : Repository
    {
        return Cache::store();
    }

    /**
     * The cache key name to use by default.
     *
     * @return string
     */
    protected function defaultCacheKey() : string
    {
        /* Default Cache key for the Modal */
        if($this instanceof Model) {
            return tenant()->id.'-'.get_class($this).'-'.$this->id;
            // e.g. 5469dff5-3707-417d-b152-d9950de45daf-App\Models\Product-7
        }

        throw new LogicException('The class ' . static::class . ' has no default cache key.');
    }

    /**
     * The data to insert into the cache.
     *
     * @return $this
     */
    protected function toCache()
    {
        return $this;
    }
}
