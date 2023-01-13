<?php
namespace App\Providers;

use TenantSettings;
use App\Support\Hooks;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use App\Http\Services\WeThemeService;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;


abstract class WeThemeFunctionsServiceProvider extends ServiceProvider
{
    protected $theme_name;
    protected $theme_root;
    protected $theme_helpers;
    protected $theme_root_class;

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
        TenantSettings::setAll(re_evaluate: true);
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

        // Autoload theme Components
        Blade::componentNamespace('WeThemes\\'.$this->theme_name.'\\App\\View\\Components', 'theme');

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
            $this->theme_helpers = $this->theme_root . '/App/Helpers/*.php';
            $this->theme_name = basename($this->theme_root);
            $this->theme_root_class = 'WeThemes\\'.$this->theme_name;

            // Loop through all helper functions in the theme, and require each php file laoded with functions!
            if(!empty($theme_helpers = glob($this->theme_helpers))) {
                foreach ($theme_helpers as $filename) {
                    require_once($filename);
                }
            }
        }

        // Register WeThemeService, use it throughout the theme files as: WeTheme::{something}
        $theme_data = [
            'theme_name' => $this->theme_name,
            'theme_root_class' => '\\'. trim($this->theme_root_class ?? '', '\\'),
            'theme_root_path' => $this->theme_root,
            'theme_root_helpers_path' => $this->theme_helpers,
        ];
        $this->app->singleton('we_theme_service', function() use ($theme_data) {
            return new WeThemeService(fn () => Container::getInstance(), $theme_data);
        });
    }
}
