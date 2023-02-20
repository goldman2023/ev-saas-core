<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class TaxService extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'tax_service';
    }
}
