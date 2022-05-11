<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Support\Hooks;
use Illuminate\Support\Facades\View;
use TenantSettings;

abstract class WeThemeFunctionsServiceProvider extends ServiceProvider
{
    protected $theme_root;
    protected $theme_helpers;

    /**
     * Used to define Tenan
     */
    abstract protected function getTenantAppSettings() : array;

    protected function extendAppSettings() {
        if (function_exists('add_filter')) {
            // Add Tenant Settings
            add_filter( 'app-settings-definition', function($app_settings) { 
                return array_merge($app_settings, $this->getTenantAppSettings());
            }, 20, 1);
        }

        // Create Missing Tenant Settings
        TenantSettings::setAll(true);
    }

    /**
     * Bootstrap the theme function services.
     */
    public function boot()
    {
        $this->extendAppSettings();
    }

    /**
     * Register all directives.
     *
     * @return void
     */
    public function register()
    {
        if (!empty(tenant()->domains->first())) {
            // Set `theme_root` and `theme_helpers` paths
            $this->theme_root = base_path() . '/themes/' . tenant()->domains->first()->theme;
            $this->theme_helpers = $this->theme_root . '/app/Helpers/*.php';

            // Loop through all helper functions in the theme, and require each php file laoded with functions!
            if(!empty($theme_helpers = glob($this->theme_helpers))) {
                foreach ($theme_helpers as $filename) {
                    require_once($filename);
                }
            }      
        }
    }
}