<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Tenancy;
use App\Tenancy\Resolvers\ExtendedDomainTenantResolver;

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
