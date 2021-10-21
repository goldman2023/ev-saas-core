<?php

namespace App\Http\Services;

use Cache;
use Session;
use EVS;
use App\Models\Currency;

class FXService
{
    public Currency $currency;
    public string $currency_symbol;

    public function __construct($app) {
        $this->setCurrency();
    }

    public function setCurrency() {
        $code = Cache::remember(tenant('id').'_system_default_currency',  config('cache.stores.redis.ttl_redis_cache', 60), function () {
            return Currency::findOrFail(get_setting('system_default_currency'))->code;
        });

        if (Session::has('currency_code')) {
            $selected_code = Session::get('currency_code', $code);

            $currency =  Cache::remember(tenant('id').'_'.$selected_code . '_cache', 86400, function () use ($selected_code) {
                return Currency::where('code', $selected_code)->first();
            });
        } else {
            $currency = Currency::where('code', $code)->first();
        }

        $this->currency = $currency;
        $this->currency_symbol = $currency->symbol ?? '';
    }

    public function formatPrice($price)
    {
        if (get_setting('decimal_separator') == 1) {
            $formatted_price = number_format($price, get_setting('no_of_decimals'));
        } else {
            $formatted_price = number_format($price, get_setting('no_of_decimals'), ',', ' ');
        }

        if (get_setting('symbol_format') == 1) {
            return $this->currency_symbol . $formatted_price;
        }

        return $formatted_price . $this->currency_symbol;
    }

    public function convertPrice($price)
    {
        $system_default_currency = get_setting('system_default_currency');

        if ($system_default_currency != null) {
            $currency = Currency::find($system_default_currency);
            $price = (float) $price / (float) $this->currency->exchange_rate;
        }

        $code = Cache::remember(tenant('id').'_system_default_currency', config('cache.stores.redis.ttl_redis_cache', 60), function () {
            return \App\Models\Currency::findOrFail(get_setting('system_default_currency'))->code;
        });

        if (Session::has('currency_code')) {
            $currency = Currency::where('code', Session::get('currency_code', $code))->first();
        } else {
            $currency = Currency::where('code', $code)->first();
        }

        $price = (float) $price * (float) $currency->exchange_rate;

        return $price;
    }
}
