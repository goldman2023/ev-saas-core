<?php

namespace App\Listeners\Tenancy;

use App\Facades\TenantSettings;
use Stancl\Tenancy\Events\TenancyBootstrapped;
use Qirolab\Theme\Theme;
use App;

class BootstrapThemeFunctions
{
    public function handle(TenancyBootstrapped $event)
    {
        /**
         * Point of this listener is to register theme specific functions service provider.
         * If a theme requires specific hooks/filters/actions etc. they should be registered inside `themes/{theme_name}/app/Providers/ThemeFunctionsServiceProvider.php`
         */
        if(tenant()->domains()->first()) {
            $theme_folder = tenant()->domains()->first()->theme;
            $theme_functions_file_path = base_path().'/themes/'.$theme_folder.'/app/Providers/ThemeFunctionsServiceProvider.php';

            // Check if ThemeFunctionsServiceProvider exists in `themes/{theme_name}/app/Providers/` and boot it
            if(file_exists($theme_functions_file_path)) {
                require_once($theme_functions_file_path);

                App::register(\ThemeFunctionsServiceProvider::class);
            }
        }

    }
}
