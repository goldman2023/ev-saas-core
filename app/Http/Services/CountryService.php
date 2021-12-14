<?php

namespace App\Http\Services;

use App\Models\Country;
use Cache;
use Str;

class CountryService
{
    protected $countries;

    public function __construct($app) {
        $this->setAll();
    }

    public function getAll() {
        return $this->countries;
    }

    public function getExcept(?array $except) {
        return $this->countries->whereNotIn('code', $except);
    }

    public function getOnly(?array $only) {
        return $this->countries->whereIn('code', $only);
    }

    public function getCodesAll($as_array = false) {
        $codes = $this->countries->pluck('code');
        return $as_array ? $codes->toArray() : $codes;
    }

    public function get($id = null, $code = null) {
        if($id) {
            return $this->firstWhere('id', $id);
        } else if($code) {
            return $this->firstWhere('code', $code);
        } else {
            return null;
        }
    }

    protected function setAll() {
        $cache_key = tenant('id') . '_countries';
        $countries = Cache::get($cache_key, null);

        if (empty($countries)) {
            $countries = Country::where('status', 1)->get();

            // Cache the countries if they are found in DB
            if ($countries->isNotEmpty()) {
                Cache::forget($cache_key);
                Cache::put($cache_key, $countries);
            }
        }

        $this->countries = $countries->isNotEmpty() ? $countries : collect([]);
    }
}
