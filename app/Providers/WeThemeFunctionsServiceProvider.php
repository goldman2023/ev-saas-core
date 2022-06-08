<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Support\Hooks;
use Illuminate\Support\Facades\View;
use TenantSettings;
use Illuminate\Support\Facades\File;


abstract class WeThemeFunctionsServiceProvider extends ServiceProvider
{
    protected $theme_root;
    protected $theme_helpers;

    /**
     * Used to define Tenant
     */
    abstract protected function getTenantAppSettings() : array;
    abstract protected function getMenuLocations() : array;
    abstract protected function registerLivewireComponents();

    /**
     * This function extends App/Tenant settings with custom settings required in a specific theme (for a specific tenant)!
     */
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
     * Registers all possible locations for dynamic menus in a theme.
     * This function overrides the nova-menu.menus setting from config files
     * and forces nova to take into consideration registered menu locations from the theme instead.
     * If getMenuLocations() retuns empty array, default menu locations from config will be used!
     *
     * Template e.g:
     *
     * 'header' => [
     *       'name' => 'Header',
     *       'unique' => true,
     *       'max_depth' => 10,
     *       'menu_item_types' => []
     *   ]
     */
    protected function registerMenuLocations() {
        $this->app['config']->set('nova-menu.menus', !empty($this->getMenuLocations()) ? $this->getMenuLocations() : $this->app['config']->get('nova-menu.menus', []));
    }

    /**
     * Bootstrap the theme function services.
     */
    public function boot()
    {
        $this->extendAppSettings();
        $this->registerMenuLocations();
        $this->registerLivewireComponents();

        // Add Theme specific sections to GrapeJS
        add_filter('theme-section-components', function($base_sections) {
            if(file_exists($this->theme_root.'/views/components/custom/')) {
                return array_merge(File::allFiles($this->theme_root.'/views/components/custom/'), $base_sections);
            } else {
                return [];
            }
        }, 10, 1);
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
