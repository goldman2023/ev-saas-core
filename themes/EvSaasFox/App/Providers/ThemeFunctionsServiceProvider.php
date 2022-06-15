<?php

namespace WeThemes\EvSaasFox\App\Providers;

use App\Providers\WeThemeFunctionsServiceProvider;
use App\Support\Hooks;
use Illuminate\Support\Facades\View;
use Livewire;

class ThemeFunctionsServiceProvider extends WeThemeFunctionsServiceProvider
{
    protected function getTenantAppSettings(): array {
        return [];
    }

    protected function getMenuLocations(): array {
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

    protected function registerLivewireComponents() {}

    /**
     * Bootstrap the theme function services.
     */
    public function boot()
    {
        parent::boot();

        // $this->loadRoutesFrom('../../routes.php');

        if (function_exists('add_action')) {
            // Actions
        }

        if (function_exists('add_filter')) {
            // Filters

            // FoxAsk uses usernames
            add_filter('user.show-username', fn() => true, 20, 0);
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
