<?php

namespace App\Traits;

use Route;

trait PermalinkTrait
{
    public string $permalink = '#';

    /**
     * Boot the trait
     *
     * @return void
     */
    protected static function bootPermalinkTrait()
    {
        // When model data is retrieved, populate $permalink
        static::retrieved(function ($model) {
            $routeKeyName = method_exists($model, 'getRouteKeyName') ? $model->getRouteKeyName() : 'slug';
            $routeName = app($model::class)::ROUTING_SINGULAR_NAME_PREFIX.'.single';

            if (!empty($model->attributes[$routeKeyName] ?? null) && Route::has($routeName)) {
                $model->permalink = route($routeName, $model->attributes[$routeKeyName]);
            }
        });
    }

    /**
     * Initialize the trait
     *
     * @return void
     */
    protected function initializePermalinkTrait(): void
    {
        $this->append(['permalink']);
    }

    /**
     * Get the ContentType permalink
     *
     * @return string $permalink
     */
    public function getPermalinkAttribute()
    {
        return $this->permalink;
    }
}
