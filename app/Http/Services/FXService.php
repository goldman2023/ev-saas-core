<?php

namespace App\Http\Services;

use App\Models\Currency;
use Cache;
use WE;
use Illuminate\Support\Facades\Cache as FacadesCache;
use Session;

class FXService
{
    public mixed $currencies;

    public Currency $currency;

    public Currency $default_currency;

    public string $currency_symbol;

    public function __construct($app)
    {
        $this->setAllCurrencies();
        $this->setCurrency();
    }

    protected function setAllCurrencies()
    {
        $this->currencies = Cache::remember(tenant('id').'_all_currencies', 60 * 60 * 24, function () {
            return $this->currencies = Currency::get();
        }); // Get all currencies with fx_rates
    }

    public function getAllCurrencies($only_enabled = true, $formatted = false)
    {
        // When only_enabled is true, we will return only Currencies with status: 1, otherwise all currencies will be returned
        if ($only_enabled) {
            $this->currencies = $this->currencies->filter(fn ($item) => $item->status === true);
        }

        if ($formatted) {
            return $this->currencies->keyBy('code')->map(fn ($item) => $item->code.' ('.$item->symbol.')')->toArray();
        }

        return $this->currencies;
    }

    protected function setCurrency()
    {
        $code = get_tenant_setting('system_default_currency'); // Already converted to Currency in TenantSettingsService

        if ($code) {
            $code = $code->code;
        } else {
            $code = Currency::find(1)->code;
        }

        $this->default_currency = Currency::where('code', $code)->first(); // set system default currency

        if (Session::has('currency_code')) {
            $selected_code = Session::get('currency_code', $code); // get currently selected currency code, otherwise use system_default_code

            $this->currency = Cache::remember(tenant('id').'_'.$selected_code.'_cache', 86400, function () use ($selected_code) {
                return Currency::where('code', $selected_code)->first();
            });
        } else {
            $this->currency = FacadesCache::remember(tenant('id').'_'.$code.'_cache', 86400, function () use ($code) {
                return Currency::where('code', $code)->first();
            });
        }

        $this->currency_symbol = $this->currency->symbol ?? '';
    }

    public function getCurrency($symbol = null)
    {
        return $this->currency;
    }

    public function getDefaultCurrency()
    {
        return $this->default_currency;
    }

    public function convertPrice($price, $base_currency = null)
    {
        // If the base_currency of the purchasable item is same as current currency, conversion is 1:1 aka. just return $price;
        if (($base_currency === $this->currency->code) || empty($base_currency)) {
            return $price;
        }

        // TODO: Create proper Currency Converter that will store FX rates in CENTRAL app and in non-tenant-related Cache
        $price = (float) $price / (float) $this->default_currency->exchange_rate;

        return (float) $price * (float) $this->currency->exchange_rate;
    }

    public function formatPrice($price, $decimals = null, $base_currency = null, $convert = true)
    {
        if ($convert) {
            $price = $this->convertPrice($price, $base_currency);
        }

        $decimals = is_int($decimals) ? $decimals : get_tenant_setting('no_of_decimals');

        if (get_tenant_setting('decimal_separator') === 1) {
            $formatted_price = number_format($price, $decimals);
        } else {
            $formatted_price = number_format($price, $decimals, ',', '.');
        }

        if (get_tenant_setting('symbol_format') === 1) {
            return $this->currency_symbol.$formatted_price;
        }

        return $formatted_price.$this->currency_symbol;
    }

    public function reductionPercentage($full, $part)
    {
        return 100 - ($part * 100 / $full);
    }

    public function formatDecimals($price, $decimals = null) {
        $decimals = is_int($decimals) ? $decimals : get_tenant_setting('no_of_decimals');

        return round($price, $decimals);
    }
}
