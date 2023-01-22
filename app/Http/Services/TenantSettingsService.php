<?php

namespace App\Http\Services;

use App\Models\Central\CentralSetting;
use App\Models\TenantSetting;
use Cache;
use App\Models\Currency;
use App\Models\Upload;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;

/**
 * We are getting all Tenant Settings from the cache, or DB.
 * This is a singleton service, which means it'll be loaded only once during one request lifecycle.
 * This reduces the number of calls to both Redis/cache and DB.
 * There will be only one request to get all business settings cuz this class instance is reused everywhere in app if accessed via:
 * 1. Facade: App\Facades\TenantSettings (::get('{name}'))
 * 2. helper: get_tenant_setting('{name}') or get_setting('{name}')
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
    
    /**
     * createMissingSettings
     * 
     * This function compares tenant settings from redis (cached for current tenant) and list of hardcoded tenant settings from settingsDataTypes().
     * If there are missing properties (existin $data_types, but not in redis cache or DB):
     * 1. Clear tenant settings cache in Redis
     * 2. Create or update missing tenant settings in DB
     * 3. Run setAll() again in order to get all tenant settings (including previously missing ones) and store them in Redis cache
     *
     * @return void
     */
    public function createMissingSettings($re_evaluate = false) {
        /* TODO: How to make this not trigger when creating tenancy? */

        if(Request::getHost() == config('tenancy.primary_central_domain')) {
            return true;
        }

        $data_types = $this->settingsDataTypes();
        $missing = array_diff_key($data_types, $this->getAll());

        if(!empty($missing)) {
            $this->clearCache(); // Clear tenant settings cache

            // Add missing tenant settings to the DB
            foreach($missing as $key => $type) {
                TenantSetting::updateOrCreate(
                    ['setting' => $key],
                    ['value' => $type === 'boolean' ? false : null]
                );
            }

            // Set tenant settings again with along with previously missing ones
            $this->setAll($re_evaluate);
        }
    }

    public function setAll($re_evaluate = false) {
        if(Request::getHost() == config('tenancy.primary_central_domain')) {
            return true;
        }

        $cache_key = !empty(tenant()) ? tenant('id') . '_tenant_settings' : 'central_settings';
        $settings = Cache::get($cache_key, null);
        $default = [];
        $data_types = $this->settingsDataTypes();

        // TODO: Find a proper way to integrate ThemeFunctions settings injection through add_filter() by using setting

        if (empty($settings) || $re_evaluate) {
            $settings = collect(DB::connection()->getPdo()
                ->query("SELECT `id`, `setting`, `value` FROM ".(!empty(tenant()) ? app(TenantSetting::class) : app(CentralSetting::class))->getTable())
                ->fetchAll(\PDO::FETCH_ASSOC))
                ->keyBy('setting')
                ->toArray();

            castValuesForGet($settings, $data_types);

            // Cache the settings if they are found in DB
            if (!empty($settings)) {
                Cache::forget($cache_key);
                Cache::put($cache_key, $settings);
            }
        }

        $this->settings = !empty($settings) ? $settings : $default;

        // it'll clear the cache and add missing settings if there are missing settings and update the current settings
        $this->createMissingSettings($re_evaluate); 
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


            'company_name' => 'string',
            'company_address' => 'string',
            'company_city' => 'string',
            'company_country' => 'string',
            'company_postal_code' => 'string',
            'company_number' => 'string',
            'company_vat' => 'string',
            'company_email' => 'string',

            'company_tax_rate' => 'decimal',

            // SEO
            'seo_meta_image' => Upload::class,

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
            'invoice_prefix' => 'string',
            'installments_deposit_amount' => 'decimal',

            // Design
            'product_page_style' => 'string',
            'footer_style' => 'string',



            // Features
            'feed_enabled' => 'boolean',
            'multiple_subscriptions_enabled' => 'boolean', // Allowing users to have multiple subscriptions (needed for multi-vendor apps AND if you want to allow users to buy different interval subscriptions)
            'multi_item_subscription_enabled' => 'boolean', // Buying multiple plans/products (licenses/seats/whatever) under ONE subscription
            'subscription_items_distribution_enabled' => 'boolean', // Allow owner of subscription(s) to distribute subscription items(licenses/seats/whatever) among other users
            'teams_feature' => 'boolean', // (NOT IMPLEMENTED YET, but let it stay here for future) Allows grouping users inside teams and managing teams by team owner(s) and users who have permissions for it
            'onboarding_flow' => 'boolean',
            'chat_feature' => 'boolean',
            'addresses_feature' => 'boolean',
            'notifications_feature' => 'boolean',
            'weedit_feature' => 'boolean',
            'wishlist_feature' => 'boolean',
            'vendor_mode_feature' => 'boolean',
            'plans_trial_mode' => 'boolean',
            'plans_trial_duration' => 'int',

            'force_email_verification' => 'boolean',
            'register_redirect_url' => 'string',
            'login_redirect_url' => 'string', //
            'login_dynamic_redirect' => 'boolean', //
            'register_dynamic_redirect' => 'boolean', //
            'user_entity_choice' => 'boolean', // enables individual or company radio buttons


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

            // WooCommerce Import Variables
            'woo_import_enabled' => 'boolean',
            'woo_import_api_key' => 'string',
            'woo_import_rest_api_secret_key' => 'string',

            // WooCommerce Export Variables
            'woo_export_enabled' => 'boolean',
            'woo_export_api_key' => 'string',
            'woo_export_rest_api_secret_key' => 'string',

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
            'include_phone_number_in_registration' => 'boolean',
            'require_phone_number_in_registration' => 'boolean',
            'enable_phone_number_login' => 'boolean',
            'enable_2fa' => 'boolean',


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
        $tasks_enabled = [
            'tasks_enabled' => 'boolean',
        ];

        $app_settings = array_merge($app_settings,$tasks_enabled);

        return apply_filters( 'app-settings-definition', $app_settings );
    }
}
