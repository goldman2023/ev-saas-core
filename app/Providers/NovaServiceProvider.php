<?php

namespace App\Providers;

use App\Nova\Central\Domain;
use App\Nova\Central\Tenant as TenantResource;
use App\Nova\Tenant\User;
use App\Models\Tenant;
use App\Nova\Central\Section;
use App\Nova\Tenant\Blog;
use App\Nova\Tenant\Shop;
use App\Nova\Tenant\Wishlist;
use App\Nova\Tenant\Product;
use App\Nova\Tenant\Activity;
use App\Nova\Tenant\PaymentMethodUniversal;
use App\Nova\Tenant\ShopSetting;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Nova::serving(function () {
            Tenant::creating(function (Tenant $tenant) {
                $tenant->ready = false;
            });

            Tenant::created(function (Tenant $tenant) {
                $tenant->createAsStripeCustomer();
            });
        });
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes(['tenant', 'universal'])
                ->withAuthenticationRoutes(['tenant', 'universal'])
                ->withPasswordResetRoutes(['tenant', 'universal'])
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {   
        Gate::define('viewNova', function ($user) {
            
            if ($user instanceof \App\Models\User) {
                return $user->isOwner();
            }

            /** @var \App\Models\Admin $user */

            return true;
        });
    }

    /**
     * Get the cards that should be displayed on the default Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [
            new Help,
        ];
    }

    /**
     * Get the extra dashboards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        if (tenancy()->initialized) {
            return [
                new \OptimistDigital\MenuBuilder\MenuBuilder,
                // new \Bolechen\NovaActivitylog\NovaActivitylog(),
            ];
        } else {
            return [
                new \OptimistDigital\MenuBuilder\MenuBuilder,
                // new \Tighten\NovaStripe\NovaStripe,
            ];
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    protected function resources()
    {
        if (tenancy()->initialized) {
            Nova::resources([
                Shop::class,
                Blog::class,
                User::class,
                Product::class,
                Activity::class,
                Wishlist::class,
                ShopSetting::class,
                PaymentMethodUniversal::class,
            ]);
        } else {
            Nova::resources([
                // Admin::class,
                TenantResource::class,
                Domain::class,
                Section::class,
                // SubscriptionCancelation::class,
            ]);
        }
    }
}
