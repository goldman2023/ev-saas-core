<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class WeTheme extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'we_theme_service';
    }
}
