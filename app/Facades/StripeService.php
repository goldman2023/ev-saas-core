<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class StripeService extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'stripe_service'; }
}
