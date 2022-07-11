<?php

use App\Models\User;
use App\Models\Plan;
use App\Models\Product;
use App\Facades\StripeService;

if (!function_exists('get_user_by_stripe_customer_id')) {
    function get_user_by_stripe_customer_id($stripe_customer_id) {
        return User::join('core_meta', function($join) {
            $join->on('users.id', '=', 'core_meta.subject_id');
            $join->on('core_meta.subject_type', '=', DB::raw("'".User::class."'") );
        })
        ->where([
            ['key', StripeService::getStripeMode().'stripe_customer_id'],
            ['value', empty($stripe_customer_id) ? '-1' : $stripe_customer_id]
        ])->first();
    }
}

if (!function_exists('get_plan_by_stripe_price_id')) {
    function get_plan_by_stripe_price_id($stripe_price_id) {
        return Plan::join('core_meta', function($join) {
            $join->on('plans.id', '=', 'core_meta.subject_id');
            $join->on('core_meta.subject_type', '=', DB::raw("'".Plan::class."'") );
        })
        ->where([
            ['value', empty($stripe_price_id) ? '-1' : $stripe_price_id]
        ])->first();
    }
}

if (!function_exists('get_product_by_stripe_price_id')) {
    function get_product_by_stripe_price_id($stripe_price_id) {
        return Plan::join('core_meta', function($join) {
            $join->on('products.id', '=', 'core_meta.subject_id');
            $join->on('core_meta.subject_type', '=', DB::raw("'".Product::class."'") );
        })
        ->where([
            ['key', StripeService::getStripeMode().'stripe_price_id'],
            ['value', empty($stripe_price_id) ? '-1' : $stripe_price_id]
        ])->first();
    }
}

if (!function_exists('get_product_by_stripe_product_id')) {
    function get_product_by_stripe_product_id($stripe_product_id) {
        return Plan::join('core_meta', function($join) {
            $join->on('products.id', '=', 'core_meta.subject_id');
            $join->on('core_meta.subject_type', '=', DB::raw("'".Product::class."'") );
        })
        ->where([
            ['key', StripeService::getStripeMode().'stripe_product_id'],
            ['value', empty($stripe_product_id) ? '-1' : $stripe_product_id]
        ])->first();
    }
}

if (!function_exists('get_model_by_stripe_product_id')) {
    function get_model_by_stripe_product_id($stripe_product_id) {
        return Plan::join('core_meta', function($join) {
            $join->on('products.id', '=', 'core_meta.subject_id');
        })
        ->where([
            ['key', StripeService::getStripeMode().'stripe_product_id'],
            ['value', empty($stripe_product_id) ? '-1' : $stripe_product_id]
        ])->first();
    }
}