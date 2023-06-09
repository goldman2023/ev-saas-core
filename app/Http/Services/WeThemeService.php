<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Route;

/**
 * WeThemeService
 *
 * This class has all important information about the the tenant theme currently used
 */
class WeThemeService
{
    public $app;
    public $theme_name = '';
    public $theme_root_class = '';
    public $theme_root_path = '';
    public $theme_root_helpers_path = '';
    public $theme_root_routes_path = '';
    public $bootstrap_cache_tenant_routes_path = '';

    public $theme_controllers_class = '';

    public $all_themes = [];

    public function __construct($app, $theme_data = [])
    {
        $this->app = $app(); // $app is a clousre which returns LATEST APPLICATION instance (this is important for Octane later on...)
        $this->theme_name = $theme_data['theme_name'] ?? '';
        $this->theme_root_class = $theme_data['theme_root_class'] ?? '';
        $this->theme_root_path = $theme_data['theme_root_path'] ?? '';
        $this->theme_root_helpers_path = $theme_data['theme_root_helpers_path'] ?? '';
        $this->theme_root_routes_path = $theme_data['theme_root_routes_path'] ?? '';

        $this->theme_controllers_class = $theme_data['theme_root_class'] . '\App\Http\Controllers\\';
        if(tenant()) {
            $this->bootstrap_cache_tenant_routes_path = base_path('bootstrap/cache/tenants/routes/tenant-'.tenancy()->tenant->id.'-routes.php');
        }

        $this->all_themes = collect(array_values(array_diff(scandir(base_path().'/themes'), ['..', '.'])))->keyBy(function ($item) {
            return $item;
        })->map(function($item, $key) {
            return [
                'tailwind_config_json' => file_exists(base_path().'/themes/'.$key.'/tailwind.config.json') ? base_path().'/themes/'.$key.'/tailwind.config.json' : null,
                'tailwind_config_js' => file_exists(base_path().'/themes/'.$key.'/tailwind.config.js') ? base_path().'/themes/'.$key.'/tailwind.config.js' : null,
                'webpack_mix_config' => file_exists(base_path().'/themes/'.$key.'/webpack.mix.js') ? base_path().'/themes/'.$key.'/webpack.mix.js' : null,
            ];
        });
    }

    public function getThemeName() {
        return $this->theme_name;
    }

    public function getAllThemes($for_selection = false) {
        return $for_selection ? $this->all_themes->map(fn($item, $key) => $key)->toArray() : $this->all_themes->toArray();
    }

    public function loadCachedTenantRoutes() {
        if(file_exists($this->bootstrap_cache_tenant_routes_path)) {
            // Load new routes
            require_once $this->bootstrap_cache_tenant_routes_path;

            request()->headers->set('WE-TENANT-ROUTES-LOADED', 1); // set header about tenant routes loaded to 1
        }
    }

    public function getThemeController($controller_basename = '') {
        $controller = null;
        $controller_basename = ltrim($controller_basename, '\\');

        try {
            $controller = $this->app->make($this->theme_controllers_class . $controller_basename);
        } catch(\Exception $e) {

        }

        return $controller;
    }
}
