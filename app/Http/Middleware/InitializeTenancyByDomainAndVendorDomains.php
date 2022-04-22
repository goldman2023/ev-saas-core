<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Tenancy\Resolvers\ExtendedDomainTenantResolver;
use Closure;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Tenancy;

class InitializeTenancyByDomainAndVendorDomains extends InitializeTenancyByDomain
{
    /** @var callable|null */
    public static $onFail;

    /** @var Tenancy */
    protected $tenancy;

    /** @var ExtendedDomainTenantResolver */
    protected $resolver;

    public function __construct(Tenancy $tenancy, ExtendedDomainTenantResolver $resolver)
    {
        $this->tenancy = $tenancy;
        $this->resolver = $resolver;
    }
}
