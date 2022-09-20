<?php

namespace WeThemes\WeBaltic\App\Providers;

// Because this file service provider is loaded after tenant is initated and has no namespace, it cannot use Aliases from `app.php`, like: use Log or use File; Instead full namespaces must be used!
use App\Providers\WeThemeFunctionsServiceProvider;
use App\Support\Hooks;
use Illuminate\Support\Facades\View;
use Livewire;
use TenantSettings;
use Log;

class ThemeFunctionsServiceProvider extends WeThemeFunctionsServiceProvider
{
    protected function getTenantAppSettings(): array
    {
        return [];
    }

    protected function getMenuLocations(): array
    {
        return [
            'header' => [
                'name' => 'Header',
                'unique' => true,
                'max_depth' => 3,
                'menu_item_types' => []
            ],
            'footer_1' => [
                'name' => 'Footer 1',
                'unique' => true,
                'max_depth' => 1,
                'menu_item_types' => []
            ],
            'footer_2' => [
                'name' => 'Footer 2',
                'unique' => true,
                'max_depth' => 1,
                'menu_item_types' => []
            ],
            'footer_3' => [
                'name' => 'Footer 3',
                'unique' => true,
                'max_depth' => 1,
                'menu_item_types' => []
            ],
        ];
    }

    protected function registerLivewireComponents()
    {
    }

    /**
     * Bootstrap the theme function services.
     */
    public function boot()
    {
        parent::boot();

        if (function_exists('add_filter')) {
            // Filter







            add_filter('dashboard.sidebar.menu', function ($menu) {
                $included_items = [
                    'dashboard',
                    'attributes.index',
                    'categories.index',
                    'orders.index',
                    'invoices.index',
                    'blog.posts.index',
                    'pages.index',
                    'crm.all_customers',
                    'my.account.settings',
                    'my.orders.all',
                    'settings.staff_settings',
                    'settings.app_settings',
                    'settings.super_admin',
                    'we-edit.index'
                ];


                /* TODO: Use this approach for overiding child themes, menu */
                foreach ($menu as $menuKey => $items) {
                    foreach ($items['items'] as $key => $item) {
                        if (isset($item['route_name'])) {
                            if (in_array($item['route_name'], $included_items)) {
                            } else {
                                unset($menu[$menuKey]['items'][$key]);
                            }
                        }
                    }
                }
                return $menu;
            }, 10, 1);
        }
    }

    /**
     * Register all directives.
     *
     * @return void
     */
    public function register()
    {
        parent::register();
    }
}
