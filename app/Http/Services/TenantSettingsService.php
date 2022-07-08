<?php

namespace App\Http\Services;
use App\Models\Central\CentralSetting;
use App\Models\TenantSetting;
use Cache;
use App\Models\Currency;
use App\Models\Upload;
use Illuminate\Support\Facades\Request;

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
        // dd($this->getAll()); // testing castValuesForGet
    }

    public function get($name, $default = null) {
        return isset($this->settings[$name]) ? ($this->settings[$name] ?? $default) : $default;
    }

    public function getModel($name) {
        return TenantSetting::firstOrNew([
            'type' => $name
        ]);
    }

    public function getAll() {
        return $this->settings;
    }

    public function createMissingSettings() {
        /* TODO: How to make this not trigger when creating tenancy */

        if(Request::getHost() == config('tenancy.primary_central_domain')) {
            return true;
        }
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

    public function setAll($test = false) {
        if(Request::getHost() == config('tenancy.primary_central_domain')) {
            return true;
        }
        $this->createMissingSettings(); // it'll clear the cache and add missing settings if there are missing settings

        $cache_key = !empty(tenant()) ? tenant('id') . '_tenant_settings' : 'central_settings';
        $settings = Cache::get($cache_key.'a', null);
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
        $app_settings = [
            // General
            'site_logo' => Upload::class,
            'site_logo_dark' => Upload::class,
            'site_icon' => Upload::class,
            'site_name' => 'string',
            'site_motto' => 'string',
            'site_contact_email' => 'string',
            'maintenance_mode' => 'boolean',
            'contact_details' => 'array',

            // Content Types
            'brands_ct_enabled' => 'boolean',

            'documentation_url' => 'string',
            'tos_url' => 'string',
            'cookies_url' => 'string',
            'eula_url' => 'string',
            'returns_and_refunds_url' => 'string',
            'shipping_policy_url' => 'string',


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
                'typography-1' => 'string',
                'typography-2' => 'string',
                'typography-3' => 'string',
                'typography-4' => 'string',
                'background-1' => 'string',
                'background-2' => 'string',
                'background-3' => 'string',
                'background-4' => 'string',
                'indigo-100' => 'string',
                'indigo-200' => 'string',
                'indigo-300' => 'string',
                'indigo-400' => 'string',
                'indigo-500' => 'string',
                'indigo-600' => 'string',
                'indigo-700' => 'string',
                'indigo-800' => 'string',
                'indigo-900' => 'string',
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

            // Features
            'feed_enabled' => 'boolean',
            'multiplan_purchase' => 'boolean', // Buying multiple plans and distributing them among other users
            'onboarding_flow' => 'boolean',
            'chat_feature' => 'boolean',
            'addresses_feature' => 'boolean',
            'weedit_feature' => 'boolean',
            'wishlist_feature' => 'boolean',
            'vendor_mode_feature' => 'boolean',
            'plans_trial_mode' => 'boolean',
            'plans_trial_duration' => 'integer',

            'force_email_verification' => 'boolean',
            'register_redirect_url' => 'string',
            'login_redirect_url' => 'string', //
            'login_dynamic_redirect' => 'string', //
            'register_dynamic_redirect' => 'string', //

            // Integrations
            'mailerlite_api_token' => 'string',
            'mailersend_api_token' => 'string',
            'google_analytics_enabled' => 'boolean',
            'gtag_id' => 'string',
            'google_recaptcha_enabled' => 'boolean',
            'google_recaptcha_site_key' => 'string',
            'google_recaptcha_secret_key' => 'string',

            'facebook_pixel_enabled' => 'string',
            'facebook_pixel_id' => 'string',

            'google_tag_manager_enabled' => 'boolean',
            'google_tag_manager_id' => 'string',

            // Standard WP Blog Posts and categories
            'wordpress_api_enabled' => 'boolean',
            'wordpress_api_route' => 'string',

            // Mail
            'smtp_mail_enabled' => 'boolean',
            'smtp_mail_host' => 'string',
            'smtp_mail_port' => 'string',
            'smtp_mail_username' => 'string',
            'smtp_mail_password' => 'string',

            'mail_from_address' => 'string',
            'mail_from_name' => 'string',
            'mail_reply_to_address' => 'string',
            'mail_reply_to_name' => 'string',
            'transactional_email_templates_list' => [
                // TODO: Generate possible fields here based on amount of Languages enabled on site - each language can have it's own email template in MailerSend!!!
                'user_welcome_email' => [
                    'en' => 'string'
                ],
                'user_forgot_your_password_email' => [
                    'en' => 'string'
                ],
                'user_verification_email' => [
                    'en' => 'string'
                ],
                'order_received_email' => [
                    'en' => 'string'
                ],
                'invoice_created_email' => [
                    'en' => 'string'
                ],
                'invoice_paid_email' => [
                    'en' => 'string'
                ],
                'invoice_payment_failed_email' => [
                    'en' => 'string'
                ],
                'new_follower_email' => [
                    'en' => 'string'
                ],
                'new_message_email' => [
                    'en' => 'string'
                ],
            ],

            // Advanced
            'user_meta_fields_in_use' => 'array',

            // Notifications
            'system_notifications_list' => []
        ];

        // System Notifications
        $system_notifications_list_array = [
            'user_welcome', 'user_forgot_your_password', 'user_verification', 'user_password_changed', 'user_invite', 'user_finalize_verification',
            'subscription_updated', 'subscription_canceled',
            'order_received',
            'invoice_created', 'invoice_paid', 'invoice_payment_failed',
            'new_follower', 'new_message',
        ];
        foreach($system_notifications_list_array as $key => $value) {
            $app_settings['system_notifications_list'][$value] = [
                'enabled' => 'boolean',
                'to_causer' => 'boolean',
                'to_admin' => 'boolean',
                'via' => 'array',
            ];
        }

        return apply_filters( 'app-settings-definition', $app_settings );
    }
}
