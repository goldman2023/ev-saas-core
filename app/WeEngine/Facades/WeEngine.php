<?php

namespace App\WeEngine\Facades;

use Illuminate\Support\Facades\Facade;

class WeEngine extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'we_engine';
    }
}
