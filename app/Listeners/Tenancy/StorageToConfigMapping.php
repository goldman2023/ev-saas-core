<?php

namespace App\Listeners\Tenancy;

use App\Facades\TenantSettings;
use Stancl\Tenancy\Events\TenancyBootstrapped;

use Qirolab\Theme\Theme;

class StorageToConfigMapping
{
    public function handle(TenancyBootstrapped $event)
    {
        tenant()->setSocialServiceMappings();
    }
}
