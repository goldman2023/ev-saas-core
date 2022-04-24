<?php

namespace App\Listeners\Tenancy;

use App\Facades\TenantSettings;
use Stancl\Tenancy\Events\BootstrappingTenancy;
use Stancl\Tenancy\Events\TenancyBootstrapped;
use Stancl\Tenancy\Events\TenancyInitialized;
use Stancl\Tenancy\Features\TenantConfig;

class StorageToConfigMapping
{
    public function handle(TenancyBootstrapped $event)
    {
        tenant()->setSocialServiceMappings();
    }
}
