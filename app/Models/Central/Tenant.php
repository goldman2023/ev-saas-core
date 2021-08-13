<?php

namespace App\Models\Central;

use App\Exceptions\NoPrimaryDomainException;
use Laravel\Cashier\Billable;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Illuminate\Database\Eloquent\Collection;

/**
 * @property-read string $plan_name The tenant's subscription plan name
 * @property-read bool $on_active_subscription Is the tenant actively subscribed (not on grace period)
 * @property-read bool $can_use_app Can the tenant use the application (is on trial or subscription)
 *
 * @property-read Domain[]|Collection $domains
 */
class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains, Billable;

    protected $casts = [
        'trial_ends_at' => 'datetime',
    ];

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'email',
            'stripe_id',
            'card_brand',
            'card_last_four',
            'trial_ends_at',
        ];
    }

    public function primary_domain()
    {
        return $this->hasOne(Domain::class)->where('is_primary', true);
    }

    public function fallback_domain()
    {
        return $this->hasOne(Domain::class)->where('is_fallback', true);
    }

    public function route($route, $parameters = [], $absolute = true)
    {
        if (! $this->primary_domain) {
            throw new NoPrimaryDomainException;
        }

        $domain = $this->primary_domain->domain;

        $parts = explode('.', $domain);
        if (count($parts) === 1) { // If subdomain
            $domain = Domain::domainFromSubdomain($domain);
        }

        return tenant_route($domain, $route, $parameters, $absolute);
    }

    public function impersonationUrl($user_id): string
    {
        $token = tenancy()->impersonate($this, $user_id, $this->route('tenant.info'), 'web')->token;

        return $this->route('tenant.impersonate', ['token' => $token]);
    }

    /**
     * Get the tenant's subscription plan name.
     *
     * @return string
     */
    public function getPlanNameAttribute(): string
    {
        return config('saas.plans')[$this->subscription('default')->stripe_plan];
    }

    /**
     * Is the tenant actively subscribed (not on grace period).
     *
     * @return string
     */
    public function getOnActiveSubscriptionAttribute(): bool
    {
        return $this->subscribed('default') && ! $this->subscription('default')->cancelled();
    }

    /**
     * Can the tenant use the application (is on trial or subscription).
     *
     * @return boolean
     */
    public function getCanUseAppAttribute(): bool
    {
        return $this->onTrial() || $this->subscribed('default');
    }
}
