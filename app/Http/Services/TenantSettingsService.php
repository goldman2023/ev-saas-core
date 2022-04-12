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
            $this->clearCache();

            foreach($missing as $key => $type) {
                TenantSetting::updateOrCreate(
                    ['setting' => $key],
                    ['value' => $type === 'boolean' ? false : null]
                );
            }
        }
    }

    protected function setAll() {
        $this->createMissingSettings(); // it'll clear the cache and add missing settings if there are missing settings

        $cache_key = !empty(tenant()) ? tenant('id') . '_tenant_settings' : 'central_settings';
        $settings = Cache::get($cache_key.'asdasd', null); // TODO: Remove 'asd'
        $default = [];
        $data_types = $this->settingsDataTypes();


        if (empty($settings)) {
            $settings  = (!empty(tenant()) ? app(TenantSetting::class) : app(CentralSetting::class))->select('id','setting','value')->get()->keyBy('setting')->toArray();

            castValuesForGet($settings, $data_types);

            // dd($settings);
            // Cache the settings if they are found in DB
            if (!empty($settings)) {
                Cache::forget($cache_key);
                Cache::put($cache_key, $settings);
            }
        }

        $this->settings = !empty($settings) ? $settings : $default;
    }



    public function clearCache() {
        $cache_key = !empty(tenant()) ? tenant('id') . '_tenant_settings' : 'central_settings';
        Cache::forget($cache_key);
    }

    public function settingsDataTypes() {
        return [
            'site_logo' => Upload::class,
            'site_logo_dark' => Upload::class,
            'site_icon' => Upload::class,
            'site_name' => 'string',
            'site_motto' => 'string',
            'maintenance_mode' => 'boolean',
            'contact_details' => 'array',

            'colors' => [
                'primary' => 'string',
                'primary-hover' => 'string',
                'primary-light' => 'string',
                'primary-dark' => 'string',
                'secondary' => 'string',
                'secondary-hover' => 'string',
                'secondary-light' => 'string',
                'secondary-dark' => 'string',
                'info' => 'string',
                'info-light' => 'string',
                'success' => 'string',
                'success-light' => 'string',
                'warning' => 'string',
                'warning-light' => 'string',
                'danger' => 'string',
                'danger-light' => 'string',
                'sidebar-bg' => 'string',
            ],

            'header' => 'array',
            'footer' => 'array',
            'show_language_switcher' => 'boolean',
            'show_currency_switcher' => 'boolean',
            'system_default_currency' => Currency::class,
            'currency_format' => 'int',
            'symbol_format' => 'int',
            'no_of_decimals' => 'int',
            'decimal_separator' => 'string',
            'enable_social_logins' => 'boolean',
            'facebook_app_id' => 'string',
            'facebook_app_secret' => 'string',
            'google_oauth_client_id' => 'string',
            'google_oauth_client_secret' => 'string',
            'linkedin_client_id' => 'string',
            'linkedin_client_secret' => 'string',
            'google_login' => 'boolean',
            'facebook_login' => 'boolean',
            'twitter_login' => 'boolean',
            'linkedin_login' => 'boolean',
            'github_login' => 'boolean',
            'guest_checkout_active' => 'boolean',

            // Payments
            'stripe_enabled' => 'boolean',
            'stripe_pk_test_key' => 'string',
            'stripe_sk_test_key' => 'string',
            'stripe_pk_live_key' => 'string',
            'stripe_sk_live_key' => 'string',

            // Features
            'feed_enabled' => 'boolean',
            'multiplan_purchase' => 'boolean', // Buying multiple plans and distributing them among other users
            

        ];
    }
}
