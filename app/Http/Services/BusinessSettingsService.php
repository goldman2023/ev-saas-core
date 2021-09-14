<?php

namespace App\Http\Services;

use App\Models\BusinessSetting;
use Cache;

/**
 * We are getting all Business Settings from the cache, or DB.
 * This is a singleton service, which means it'll be loaded only once during one request lifecycle.
 * This reduces the number of calls to both Redis/cache and DB.
 * There will be only one request to get all business settings cuz this class instance is reused everywhere in app if accessed via:
 * 1. Facade: App\Facades\BusinessSettings
 * 2. helper: get_setting('{name}')
 * All settings are loaded into $settings variable and each of them can be accessed with get() function.
 */
class BusinessSettingsService
{
    public $app;
    public $settings;

    public function __construct($app) {
        $this->app = $app;

        $cache_key = tenant('id') . '_business_settings';
        $settings = Cache::get($cache_key, null);
        $default = [];

        if (empty($settings)) {
            $settings = BusinessSetting::select('id','type AS name','value')->get()->keyBy('name')->toArray();

            // Cache the settings if they are found in DB
            if (!empty($settings)) {
                Cache::forget($cache_key);
                Cache::put($cache_key, $settings);
            }
        }

        $this->settings = !empty($settings) ? $settings : $default;
    }

    public function get($name, $default = null) {
        return isset($this->settings[$name]) ? ($this->settings[$name]['value'] ?? $default) : $default;
    }

    public function getAll() {
        return $this->settings;
    }
}
