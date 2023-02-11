<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Stancl\Tenancy\Tenancy;
use App\Tenancy\Resolvers\ExtendedDomainTenantResolver;
use Stancl\Tenancy\Middleware\IdentificationMiddleware;

class InitializeTenancyByDomainAndVendorDomains extends IdentificationMiddleware
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

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if((int) $request->header('WE-SKIP-PREV-MIDDLEWARES', 0) === 1) {
            return $next($request);
        }

        return $this->initializeTenancy(
            $request, $next, $request->getHost()
        );
    }
}
