<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class WeBuilder extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'we_builder_sections'; }
}
