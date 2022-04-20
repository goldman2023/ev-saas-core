<?php

namespace App\Http\Resources\V2;

use App\Models\Currency;
use App\Models\TenantSetting;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SettingsCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function ($data) {
                return [
                    'name' => $data->name,
                    'logo' => $data->logo,
                    'facebook' => $data->facebook,
                    'twitter' => $data->twitter,
                    'instagram' => $data->instagram,
                    'youtube' => $data->youtube,
                    'google_plus' => $data->google_plus,
                    'currency' => [
                        'name' => Currency::findOrFail(get_setting('system_default_currency'))->name,
                        'symbol' => Currency::findOrFail(get_setting('system_default_currency'))->symbol,
                        'exchange_rate' => (float) $this->exchangeRate(Currency::findOrFail(get_setting('system_default_currency'))),
                        'code' => Currency::findOrFail(get_setting('system_default_currency'))->code,
                    ],
                    'currency_format' => $data->currency_format,
                ];
            }),
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
            'status' => 200,
        ];
    }

    public function exchangeRate($currency)
    {
        $base_currency = Currency::find(get_setting('system_default_currency'));

        return $currency->exchange_rate / $base_currency->exchange_rate;
    }
}
