<?php

namespace App\Traits;

use Route;

trait PermalinkTrait
{
    abstract public static function getRouteName();

    public function getPermalink() {
        $routeKeyName = method_exists($this, 'getRouteKeyName') ? $this->getRouteKeyName() : 'slug';

        if (!empty($this->attributes[$routeKeyName] ?? null) && Route::has($this->getRouteName())) {
            return route($this->getRouteName(), $this->attributes[$routeKeyName]);
        }

        return route('home');
    }
}
