<?php

namespace App\Http\Services;
use App\Models\Central\CentralSetting;
use App\Models\TenantSetting;
use Cache;

/**
 * We are getting all Tenant Settings from the cache, or DB.
 * This is a singleton service, which means it'll be loaded only once during one request lifecycle.
 * This reduces the number of calls to both Redis/cache and DB.
 * There will be only one request to get all business settings cuz this class instance is reused everywhere in app if accessed via:
 * 1. Facade: App\Facades\TenantSettings
 * 2. helper: get_setting('{name}')
 *
 * All tenant settings are loaded into $settings variable and each of them can be accessed with get() function from this class OR using Facade - TenantSetting::get().
 */
class TenantSettingsService
{
    public $app;
    public $settings;

    public function __construct($app) {
        $this->app = $app;

        $this->setAll();
    }

    public function get($name, $default = null) {
        return isset($this->settings[$name]) ? ($this->settings[$name]['value'] ?? $default) : $default;
    }

    public function getModel($name) {
        return TenantSetting::firstOrNew([
            'type' => $name
        ]);
    }

    public function getAll() {
        return $this->settings;
    }

    protected function setAll() {
        $cache_key = !empty(tenant()) ? tenant('id') . '_tenant_settings' : 'central_settings';
        $settings = Cache::get($cache_key, null);
        $default = [];

        if (empty($settings)) {
            $settings  = (!empty(tenant()) ? app(TenantSetting::class) : app(CentralSetting::class))->select('id','setting','value')->get()->keyBy('setting')->toArray();
            
            // Cache the settings if they are found in DB
            if (!empty($settings)) {
                Cache::forget($cache_key);
                Cache::put($cache_key, $settings);
            }
        }

        $this->settings = !empty($settings) ? $settings : $default;
    }
}
