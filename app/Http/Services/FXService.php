<?php

namespace App\Http\Services;

use Cache;
use Session;
use EVS;
use App\Models\Currency;

class FXService
{
    public Currency $currency;
    public Currency $default_currency;
    public string $currency_symbol;

    public function __construct($app) {
        $this->setCurrency();
    }

    public function setCurrency() {
        $code = Cache::remember(tenant('id').'_system_default_currency',  config('cache.stores.redis.ttl_redis_cache', 60), function () {
            return Currency::findOrFail(get_setting('system_default_currency'))->code;
        });

        $this->default_currency = Currency::where('code', $code)->first(); // set system default currency

        if (Session::has('currency_code')) {
            $selected_code = Session::get('currency_code', $code); // get currently selected currency code, otherwise use system_default_code

            $this->currency =  Cache::remember(tenant('id').'_'.$selected_code . '_cache', 86400, function () use ($selected_code) {
                return Currency::where('code', $selected_code)->first();
            });
        } else {
            $this->currency = Currency::where('code', $code)->first();
        }

        $this->currency_symbol = $this->currency->symbol ?? '';
    }

    public function convertPrice($price)
    {
        // TODO: Create proper Currency Converter that will store FX rates in CENTRAL app and in non-tenant-related Cache
        $price = (float) $price / (float) $this->default_currency->exchange_rate;
        return (float) $price * (float) $this->currency->exchange_rate;
    }

    public function formatPrice($price, $convert = true)
    {
        if($convert) {
            $price = $this->convertPrice($price);
        }

        if (get_setting('decimal_separator') === 1) {
            $formatted_price = number_format($price, get_setting('no_of_decimals'));
        } else {
            $formatted_price = number_format($price, get_setting('no_of_decimals'), ',', ' ');
        }

        if (get_setting('symbol_format') === 1) {
            return $this->currency_symbol . $formatted_price;
        }

        return $formatted_price . $this->currency_symbol;
    }

    public function reductionPercentage($full, $part) {
        return 100-($part*100/$full);
    }
}
