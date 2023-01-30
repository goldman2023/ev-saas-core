<?php

namespace App\Providers;

use App\Models\Shop;
use App\Rules\IfIDExists;
use App\Rules\MatchPassword;
use DebugBar\DebugBar;
use Mpociot\VatCalculator\Facades\VatCalculator;
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
        $this->registerMigratorSingleton();
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

        Validator::extend('check_eu_vat_number', function ($attribute, $value, $parameters, $validator) {
            $country_field_name = $parameters[0];
            $meta_field_name = explode('.', $attribute)[0];

            $country = $validator->getData()[$meta_field_name][$country_field_name];

            if(!empty($country) && !empty(\Countries::get(code: $country)) && \Countries::isEU($country)) {
                try { 
                    // VAT Number MUST INCLUDE COUNTRY TWO-LETTER CODE AT THE BEGINNING
                    $validVAT = VatCalculator::isValidVATNumber($value);
                    
                    // Check if VAT number country is aligned with user selected country (compare codes)
                    // if($validVAT) {
                    //     $validVAT = strtoupper(substr($value, 0, 2)) === strtoupper($country);
                    // }
                } catch (VATCheckUnavailableException $e) {
                    // The VAT check API is unavailable...
                    \Log::warning($e);
                }

                if($validVAT) {
                    return true;
                }

                return false;
            } else if(empty($country) || (!empty($country) && empty(\Countries::get(code: $country)))) {
                return false;
            }

            return true;
        });

        Validator::extend('validate_state', function ($attribute, $value, $parameters, $validator) {
            $country_field_name = $parameters[0];
            $meta_field_name = explode('.', $attribute)[0];

            $country = $validator->getData()[$meta_field_name][$country_field_name];
            
            if(!empty($country) && !empty(\Countries::get(code: $country))) {
                return \Countries::validateState($country, $value);
            }

            return true;
        });
    }

    public function registerCustomBladeExtensions() {
        Blade::if('admin', function ($user = null) {
            if(empty($user)) $user = auth()->user();

            return $user?->isAdmin() ?? false;
        });

        Blade::if('me', function ($user = null) {
            return ($user?->id ?? null) === (auth()->user()?->id ?? false);
        });

        Blade::if('can_access', function ($types, $permissions) {
            return Permissions::canAccess($types, $permissions, false);
        });

        Blade::if('owner', function ($user) {
            return ($user?->id ?? null) === (auth()->user()?->id ?? null);
        });

        Blade::if('shopowner', function ($shop) {
            return ($shop?->id ?? null) === (auth()->user()?->shop->first()?->id ?? null);
        });

        // Hooks system
        // TODO: Make $arg into ...$args and check if everything works as expected...
        Blade::directive('do_action', function ($args) {
            return "<?php do_action($args); ?>";
        });

        Blade::directive('ob_start', function () {
            return "<?php ob_start(); ?>";
        });

        Blade::directive('ob_do_action', function ($args) {
            return '<?php $html = ob_get_clean(); ob_do_action('.$args.', $html); ?>';
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

    public function registerMigratorSingleton() {
        // This is important for artisan commands using Migrator:
        // Laravel's migrate command works because the command is registered in the IoC container by Illuminate\Foundation\Providers\ArtisanServiceProvider, 
        // and this is where the migrator dependency is injected. 
        // Following this logic, you should register your own command in your AppServiceProvider (or other service provider you setup) 
        // to inject the migrator...
        // BUT ALSO: you could also just register the Migrator class name in the IoC container, 
        // and then Laravel should be able to resolve the dependency without having to manually register the command:
        $this->app->singleton(\Illuminate\Database\Migrations\Migrator::class, function ($app) {
            return $app['migrator'];
        });
    }
}
