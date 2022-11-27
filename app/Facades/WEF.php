<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class WEF extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'wef_service';
    }
}
