<?php

namespace App\Traits\ServiceProviders;

trait RegisterObservers
{
    /**
     * Registers an array of Eloquent Model observers.
     *
     * @return void
     */
    protected function registerObservers(): void
    {
        foreach ($this->observers ?? [] as $model => $handlers) {
            foreach ((array)$handlers as $handler) {
                $model::observe($handler);
            }
        }
    }
}
