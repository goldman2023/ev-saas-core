<?php

namespace App\Http\Services;
use App\Models\Central\CentralSetting;
use App\Models\TenantSetting;
use Cache;
use App\Models\Currency;
use App\Models\Upload;

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

    protected function createMissingSettings() {
        $settings  = (!empty(tenant()) ? app(TenantSetting::class) : app(CentralSetting::class))->select('id','setting','value')->get()->keyBy('setting')->toArray();
        $data_types = $this->settingsDataTypes();

        $missing = array_diff_key($data_types, $settings);
        if(!empty($missing)) {
            foreach($missing as $key => $type) {
                $setting = new TenantSetting();
                $setting->setting = $key;
                $setting->value = null;
                $setting->save();
            }
        }
    }

    protected function setAll() {
        $cache_key = !empty(tenant()) ? tenant('id') . '_tenant_settings' : 'central_settings';
        $settings = Cache::get($cache_key, null); // TODO: Remove 'asd'
        $default = [];
        $data_types = $this->settingsDataTypes();

        if (empty($settings)) {
            $this->createMissingSettings($settings);
            $settings  = (!empty(tenant()) ? app(TenantSetting::class) : app(CentralSetting::class))->select('id','setting','value')->get()->keyBy('setting')->toArray();
            
            // Set data types for settings
            foreach($settings as $key => $setting) {
                $data_type = $data_types[$key] ?? null;
                $value = $settings[$key]['value'] ?? null;

                if(empty($value)) {
                    $settings[$key]['value'] = ($data_type === 'boolean') ? false : null;
                    continue;
                }
                
                if(isset($settings[$key]) && !empty($value)) {
                    if($data_type === Upload::class) {
                        $settings[$key]['value'] = Upload::find($value);
                    } else if($data_type === Currency::class) {
                        $settings[$key]['value'] = Currency::find($value);
                    } else if($data_type === 'string') {
                        $settings[$key]['value'] = $value;
                    } else if($data_type === 'int') {
                        $settings[$key]['value'] = ctype_digit($value) ? ((int) $value) : $value;
                    } else if($data_type === 'boolean') {
                        $settings[$key]['value'] = ($value == 0 || $value == "0") ? false : true;
                    } else if($data_type === 'array') {
                        $settings[$key]['value'] = json_decode($value, true);
                    } 
                }
                
            }
            // dd($settings);
            // Cache the settings if they are found in DB
            if (!empty($settings)) {
                Cache::forget($cache_key);
                Cache::put($cache_key, $settings);
            }
        }

        $this->settings = !empty($settings) ? $settings : $default;
    }

    protected function settingsDataTypes() {
        return [
            'site_logo' => Upload::class,
            'site_icon' => Upload::class,
            'site_name' => 'string',
            'site_motto' => 'string',
            'maintenance_mode' => 'boolean',
            'contact_details' => 'array',
            'colors' => 'array',
            'header' => 'array',
            'footer' => 'array',
            'show_currency_switcher' => 'boolean',
            'system_default_currency' => Currency::class,
            'show_language_switcher' => 'boolean',
            'currency_format' => 'int',
            'symbol_format' => 'int',
            'no_of_decimals' => 'int',
            'decimal_separator' => 'string',
            'google_login' => 'boolean',
            'facebook_login' => 'boolean',
            'twitter_login' => 'boolean',
            'linkedin_login' => 'boolean',
            'github_login' => 'boolean',
            'guest_checkout_active' => 'boolean',
        ];
    }

    public function castSettingSave($key, $setting) {
        $data_types = $this->settingsDataTypes();
        
        $data_type = $data_types[$key] ?? null;
        $value = $setting['value'] ?? null;
        
        if($data_type === Upload::class && $data_type === Currency::class) {
            $value = ctype_digit($value) ? $value : null;
        }  else if($data_type === 'int') {
            $value = ctype_digit($value) ? ((int) $value) : $value;
        } else if($data_type === 'boolean') {
            $value = $value ? 1 : 0;
        } else if($data_type === 'array') {
            $value = json_encode($value);
        } 

        return $value;
    }

    public function clearCache() {
        $cache_key = !empty(tenant()) ? tenant('id') . '_tenant_settings' : 'central_settings';
        Cache::forget($cache_key);
    }
}
