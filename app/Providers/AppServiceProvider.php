<?php

namespace App\Providers;

use App\Models\Shop;
use App\Rules\IfIDExists;
use App\Rules\MatchPassword;
use DebugBar\DebugBar;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Qirolab\Theme\Theme;
use Permissions;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Schema::defaultStringLength(191);
        Paginator::useBootstrap();

        if ($this->app->environment('production')) {
            \URL::forceScheme('https');
        }

        $this->registerCustomValidaionRules();
        $this->registerCustomBladeExtensions();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    public function registerCustomValidaionRules()
    {
        Validator::extend('is_true', function ($attribute, $value, $parameters, $validator) {
            return $value === true;
        });

        Validator::extend('match_password', function ($attribute, $value, $parameters, $validator) {
            return (new MatchPassword($parameters, $validator))->passes($attribute, $value);
        });

        Validator::extend('if_id_exists', function ($attribute, $value, $parameters, $validator) {
            return (new IfIDExists($parameters, $validator))->passes($attribute, $value);
        });

        Validator::extend('check_array', function ($attribute, $value, $parameters, $validator) {
            return count(array_filter($value, function ($var) use ($parameters) {
                return ($var && $var >= $parameters[0] && strlen($var) >= $parameters[1]);
            }));
        });
    }

    public function registerCustomBladeExtensions() {
        Blade::if('can_access', function ($types, $permissions) {
            return Permissions::canAccess($types, $permissions, false);
        });

        // Hooks system
        Blade::directive('do_action', function ($name, $arg = '') {
            return "<?php do_action($name, $arg); ?>";
        });

        // Define 'UserMeta in use' blade extensions
        Blade::if('usermeta', function ($meta_key) {
            return isset(get_tenant_setting('user_meta_fields_in_use', [])[$meta_key]);
        });
        Blade::if('usermeta_required', function ($meta_key) {
            return isset(get_tenant_setting('user_meta_fields_in_use', [])[$meta_key])
                    && isset(get_tenant_setting('user_meta_fields_in_use', [])[$meta_key]['required'])
                    && get_tenant_setting('user_meta_fields_in_use', [])[$meta_key]['required'];
        });
        Blade::if('usermeta_onboarding', function ($meta_key) {
            return isset(get_tenant_setting('user_meta_fields_in_use', [])[$meta_key])
                    && isset(get_tenant_setting('user_meta_fields_in_use', [])[$meta_key]['onboarding'])
                    && get_tenant_setting('user_meta_fields_in_use', [])[$meta_key]['onboarding'];
        });
        Blade::if('usermeta_registration', function ($meta_key) {
            return isset(get_tenant_setting('user_meta_fields_in_use', [])[$meta_key])
                    && isset(get_tenant_setting('user_meta_fields_in_use', [])[$meta_key]['regstration'])
                    && get_tenant_setting('user_meta_fields_in_use', [])[$meta_key]['regstration'];
        });

        // Facebook Pixel
        Blade::if('fbpix', function () {
            return !empty(get_tenant_setting('facebook_pixel_enabled')) && get_tenant_setting('facebook_pixel_enabled') && !empty(get_tenant_setting('facebook_pixel_id'));
        });

        // Google Recaptcha Enabled
        Blade::if('recaptcha', function () {
            return get_tenant_setting('google_recaptcha_enabled') && !empty(get_tenant_setting('google_recaptcha_site_key')) && !empty(get_tenant_setting('google_recaptcha_secret_key'));
        });

        // WooCommerce Import Enabled
        Blade::if('woo_import', function () {
            return get_tenant_setting('woo_import_enabled') && !empty(get_tenant_setting('woo_import_wp_url')) && !empty(get_tenant_setting('google_recaptcha_wp_rest_api'));
        });
    }
}
