<?php

namespace App\Traits\Caching;

use App\Support\CacheRegenerator;
use Illuminate\Contracts\Cache\Repository;

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
            'store' => $this->defaultCache(),
            'key' => $this->defaultCacheKey(),
        ]);
    }

    /**
     * The Cache Store to use to store this object.
     *
     * @return Repository
     */
    abstract protected function defaultCache() : Repository;

    /**
     * The cache key name to use by default.
     *
     * @return string
     */
    abstract protected function defaultCacheKey() : string;
}
