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

            if (!empty($model->attributes[$routeKeyName] ?? null) && Route::has(get_class($model).'.single')) {
                $model->permalink = route(get_class($model).'.single', $model->attributes[$routeKeyName]);
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
