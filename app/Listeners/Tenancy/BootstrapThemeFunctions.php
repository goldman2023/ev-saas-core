<?php

namespace App\Listeners\Tenancy;

use App;
use WeTheme;
use Qirolab\Theme\Theme;
use App\Facades\TenantSettings;
use Stancl\Tenancy\Events\TenancyBootstrapped;

class BootstrapThemeFunctions
{
    public function handle(TenancyBootstrapped $event)
    { 
        /**
         * Point of this listener is to register theme specific functions service provider.
         * If a theme requires specific hooks/filters/actions etc. they should be registered inside `themes/{theme_name}/app/Providers/ThemeFunctionsServiceProvider.php`
         */
        if(!empty(tenant()->domains->first())) {
            $theme_folder = tenant()->domains->first()->theme; // Find a better way to get theme (Also Theme::active() returns parent theme for some reason here)
            $theme_functions_file_path = base_path().'/themes/'.$theme_folder.'/App/Providers/ThemeFunctionsServiceProvider.php';
            
            // Check if ThemeFunctionsServiceProvider exists in `themes/{theme_name}/app/Providers/` and boot it
            if(file_exists($theme_functions_file_path)) { 
                // Note: No need to require file if namespacing is correct! App::register() will find it and register it.
                // FIXED (w)ith appropriate namespaces):  Find a way to bypass tenats:migration duplicate class initialization after tenant is manually changed in the function...
                App::register($this->guessThemeFunctionsNamespace($theme_folder));

                WeTheme::loadCachedTenantRoutes();
            }
        }
    }

    protected function guessThemeFunctionsNamespace($theme_folder) {
        return "\WeThemes\\".$theme_folder."\App\Providers\ThemeFunctionsServiceProvider";
    }
}
