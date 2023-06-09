<?php

namespace App\Actions;

use App\Jobs\Tenancy\CreateFrameworkDirectoriesForTenant;
use App\Jobs\Tenancy\GeneratePermissionsAndRoles;
use App\Models\Central\Domain;
use App\Models\Central\Tenant;

/**
 * Create a tenant with the necessary information for the application.
 *
 * We don't use a listener here, because we want to be able to create "simplified" tenants in tests.
 * This action is only used when we need to create the tenant properly (with billing logic etc).
 */
class CreateTenantAction
{
    public function __invoke(array $data, string $domain, bool $createStripeCustomer = true): Tenant
    {
        $tenant = Tenant::create($data + [
            'ready' => false,
            'trial_ends_at' => now()->addDays(config('saas.trial_days')),
        ]);

        $tenant->domains()->create(['domain' => $domain, 'theme' => 'WeTailwind']); // Set default theme to: WeTailwind

        $tenant->save();

        \Artisan::call('tenants:migrate', [
            '--tenants' => [$tenant->getTenantKey()],
        ]);

        \Artisan::call('tenants:seed', [
            '--tenants' => [$tenant->getTenantKey()],
        ]);

        /* Fuck you TODO: @vukasin */
        $tenant->run(function ($tenant) {
            $storage_path = storage_path();
            if(!file_exists("$storage_path/framework/cache")) {
                mkdir("$storage_path/framework/cache", 0775, true);
            }
        });

        if ($createStripeCustomer) {
            // $tenant->createAsStripeCustomer(); // TODO: Enable this logic when Spark and Central App are properly set!
        }

        return $tenant;
    }
}
