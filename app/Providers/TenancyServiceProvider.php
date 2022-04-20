<?php

declare(strict_types=1);

namespace App\Providers;

use App\Listeners\Tenancy\StorageToConfigMapping;
use App\Models\Shop;
use App\Models\SocialAccount;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Stancl\JobPipeline\JobPipeline;
use Stancl\Tenancy\Events;
use Stancl\Tenancy\Features\TenantConfig;
use Stancl\Tenancy\Jobs;
use Stancl\Tenancy\Listeners;
use Stancl\Tenancy\Middleware;
use Stancl\Tenancy\Resolvers\DomainTenantResolver;

class TenancyServiceProvider extends ServiceProvider
{
    // By default, no namespace is used to support the callable array syntax.
    public static string $controllerNamespace = '';

    public function events()
    {
        return [
            // Tenant events
            Events\CreatingTenant::class => [],
            Events\TenantCreated::class => [
                JobPipeline::make([
                    Jobs\CreateDatabase::class,
                    Jobs\MigrateDatabase::class,
                    Jobs\SeedDatabase::class,

                    // Your own jobs to prepare the tenant.
                    // Provision API keys, create S3 buckets, anything you want!

                    \App\Jobs\Tenancy\CreateFrameworkDirectoriesForTenant::class, // Create framework/cache directory for each tenant, because they need it for temp file storage
                    \App\Jobs\Tenancy\GeneratePermissionsAndRoles::class, // generate permissions and roles and attach permissions to roles

                    // TODO: Populate Exchange Rates with FetchLatestFXRates::class
                ])->send(function (Events\TenantCreated $event) {
                    return $event->tenant;
                })->shouldBeQueued(false), // `false` by default, but you probably want to make this `true` for production.
            ],
            Events\SavingTenant::class => [],
            Events\TenantSaved::class => [],
            Events\UpdatingTenant::class => [],
            Events\TenantUpdated::class => [],
            Events\DeletingTenant::class => [],
            Events\TenantDeleted::class => [
                JobPipeline::make([
                    Jobs\DeleteDatabase::class,
                ])->send(function (Events\TenantDeleted $event) {
                    return $event->tenant;
                })->shouldBeQueued(false), // `false` by default, but you probably want to make this `true` for production.
            ],

            // Domain events
            Events\CreatingDomain::class => [],
            Events\DomainCreated::class => [],
            Events\SavingDomain::class => [],
            Events\DomainSaved::class => [],
            Events\UpdatingDomain::class => [],
            Events\DomainUpdated::class => [],
            Events\DeletingDomain::class => [],
            Events\DomainDeleted::class => [],

            // Database events
            Events\DatabaseCreated::class => [],
            Events\DatabaseMigrated::class => [],
            Events\DatabaseSeeded::class => [],
            Events\DatabaseRolledBack::class => [],
            Events\DatabaseDeleted::class => [],

            // Tenancy events
            Events\InitializingTenancy::class => [],
            Events\TenancyInitialized::class => [
                Listeners\BootstrapTenancy::class,
            ],

            Events\EndingTenancy::class => [],
            Events\TenancyEnded::class => [
                Listeners\RevertToCentralContext::class,
            ],

            Events\BootstrappingTenancy::class => [],
            Events\TenancyBootstrapped::class => [
                StorageToConfigMapping::class,
            ],
            Events\RevertingToCentralContext::class => [],
            Events\RevertedToCentralContext::class => [],

            // Resource syncing
            Events\SyncedResourceSaved::class => [
                Listeners\UpdateSyncedResource::class,
            ],

            // Fired only when a synced resource is changed in a different DB than the origin DB (to avoid infinite loops)
            Events\SyncedResourceChangedInForeignDatabase::class => [],
        ];
    }

    public function register()
    {
        //
    }

    public function boot()
    {
        $this->mapStorageToConfig();
        $this->bootEvents();
        $this->mapRoutes();
        //        $this->enableTenantCacheLookup();

        $this->makeTenancyMiddlewareHighestPriority();
    }

    /**
     * avoid making a query to the central database on each tenant request — for tenant identification.
     * Even though the queries are very simple, the app has to establish a connection with the central database which is expensive.
     */
    public function enableTenantCacheLookup()
    {
        // enable cache lookup
        DomainTenantResolver::$shouldCache = true;

        // seconds, 3600 is the default value
        DomainTenantResolver::$cacheTTL = 3600;

        // specify some cache store
        // null resolves to the default cache store
        DomainTenantResolver::$cacheStore = 'redis';
    }

    protected function bootEvents()
    {
        foreach ($this->events() as $event => $listeners) {
            foreach (array_unique($listeners) as $listener) {
                if ($listener instanceof JobPipeline) {
                    $listener = $listener->toListener();
                }

                Event::listen($event, $listener);
            }
        }
    }

    protected function mapRoutes()
    {
        /* Note: Do not include central app routes here ever. Because of midlewares applied in: makeTenancyMiddlewareHighestPriority */
        if (file_exists(base_path('routes/tenant.php'))) {
            Route::namespace(static::$controllerNamespace)
                ->group(base_path('routes/tenant.php'));
        }

        if (file_exists(base_path('routes/dashboard.php'))) {
            Route::namespace(static::$controllerNamespace)
                ->group(base_path('routes/dashboard.php'));
        }
    }

    protected function mapStorageToConfig()
    {
        $social_template = collect(config('services'))->filter(fn ($item, $key) => array_key_exists($key, SocialAccount::$available_providers))->toArray();
        $mapping = [];

        /**
         * Explanation:
         *
         * $mappings is consisted of Tenant Model properties and corresponding config properties which we want to override when Tenant is bootstrapped.
         * Please remember that Tenant Model properties DO NOT EXIST YET, BUT WILL BE ADDED ON TenancyBootstrapped event (inside StorageToConfigMapping listener).
         * Function responsible for populating Tenant model properties is: tenant()->setSocialServiceMappings(); (inside StorageToConfigMapping listener)
         *
         * Flow:
         * 1. mapStorageToConfig() - where just tenant model property names are mapped to desired config settings (only names, not values, cuz tenancy is not even initialized here)
         * 2. TenancyInitialized
         * 3. TenancyBootstrapped
         * 4. StorageToConfigMapping (tenant()->setSocialServiceMappings()) - desired values from tenant_settings are assigned to custom Tenant model properties
         * 5. TenantConfig::$storageToConfigMap - finally, VALUES under mapped tenant model property NAMES are assigned to config data
         *
         * BOOM: config('{something}') returns data for current Tenant, not global data!
         */
        foreach ($social_template as $provider => $data) {
            foreach ($data as $key => $value) {
                $mapping[$provider.'_'.$key] = 'services.'.$provider.'.'.$key;
            }
        }

        TenantConfig::$storageToConfigMap = $mapping;
    }

    protected function makeTenancyMiddlewareHighestPriority()
    {

        /* TODO: Destroy this code */
        $tenancyMiddleware = [
            // Even higher priority than the initialization middleware
            Middleware\PreventAccessFromCentralDomains::class,

            // IMPORTANT: This one is needed in order to consider both vendor and tenant domains when resolving a tenant!
            \App\Http\Middleware\InitializeTenancyByDomainAndVendorDomains::class,
            Middleware\InitializeTenancyByDomain::class,
            Middleware\InitializeTenancyBySubdomain::class,
            Middleware\InitializeTenancyByDomainOrSubdomain::class,
            Middleware\InitializeTenancyByPath::class,
            Middleware\InitializeTenancyByRequestData::class,
        ];

        foreach (array_reverse($tenancyMiddleware) as $middleware) {
            $this->app[\Illuminate\Contracts\Http\Kernel::class]->prependToMiddlewarePriority($middleware);
        }
    }
}
