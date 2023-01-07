<?php

namespace App\Http\Services\Stripe\Traits\Webhooks;

use Log;
use App\Http\Services\StripeService;
use App\Http\Services\Stripe\StripeEngine;

trait WebhookMagics
{
    public function __get(string $key)
    {
        $forwarded_properties = array_values(array_merge(array_keys(get_class_vars(StripeEngine::class)), array_keys(get_class_vars(StripeService::class))));

        if(in_array($key, $forwarded_properties)) {
            return app('stripe_service')->{$key};
        }

        throw new \Exception('Class '. self::class.' does not have a property "'.$key.'" nor it can forward it to another object. Only following properties are forwarded: '.implode(', ', $forwarded_properties));
    }

    public function __call($method, $arguments)
    {
        $forwarded_methods = array_values(array_diff(get_class_methods(StripeEngine::class), getPhpMagicMethods()));

        if(in_array($method, $forwarded_methods)) {
            return $this->forwardCallTo(
                app('stripe_service'), $method, $arguments
            );
        }
        
        throw new \Exception('Class '. self::class.' does not have a method "'.$method.'" nor it can forward it to another object. Only following methods are allowed: '. implode(', ', $forwarded_methods));
    }
}
