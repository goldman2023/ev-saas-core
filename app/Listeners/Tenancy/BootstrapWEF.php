<?php

namespace App\Listeners\Tenancy;

use Stancl\Tenancy\Events\TenancyBootstrapped;
use App;

class BootstrapWEF
{
    public function handle(TenancyBootstrapped $event)
    {
        /**
         * Point of this listener is to register WEFs (WeFields) AFTER theme funtions service provider is bootstrapped - cuz we want to use WEFs throughout the theme files and hooks!
         * WeFields are: 
         * 1. Stored in `core_meta` table
         * 2. Depend on wef-json structure files stored for each tenant (like acf-json)
         * 3. Fallback: to basic core_meta value if no key for wef is defined in json (basically, fetches core_meta row for given key without casting to specific data type)
         * 4. Used for replacing model_core_meta and hard-coded dataTypes for various different core_meta(s)
         * 5. Are editable through CRUD form - like ACF (and each time new structure is saved, wef-json file for the wef group is saved and redis cache is cleared)
         */
        if(!empty(tenant()->id)) {
            App::register("\App\Providers\WEFServiceProvider");
        }

    }
}
