<?php

namespace App\Tenancy\Resolvers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Stancl\Tenancy\Contracts\Domain;
use Stancl\Tenancy\Contracts\Tenant;
use Stancl\Tenancy\Exceptions\TenantCouldNotBeIdentifiedOnDomainException;
use Stancl\Tenancy\Resolvers\DomainTenantResolver;

class ExtendedDomainTenantResolver extends DomainTenantResolver
{
    public function resolveWithoutCache(...$args): Tenant
    {
        $domain = $args[0];

        /** @var Tenant|null $tenant */
        $tenant = Cache::remember('cache_tenant_' . $domain, 6400, function() use($domain) {
            return config('tenancy.tenant_model')::query()
            ->whereHas('domains', function (Builder $query) use ($domain) {
                $query->where('domain', $domain);
            })
            ->orWhereHas('vendor_domains', function (Builder $query) use ($domain) {
                $query->where('domain', $domain);
            })
            ->with('domains')
            ->first();
        });


        if ($tenant) {
            $this->setCurrentDomain($tenant, $domain);

            return $tenant;
        } else {
            // return abort(404);
        }

        throw new TenantCouldNotBeIdentifiedOnDomainException($args[0]);
    }
}
