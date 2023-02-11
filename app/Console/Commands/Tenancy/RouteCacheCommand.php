<?php

namespace App\Console\Commands\Tenancy;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\Kernel as ConsoleKernelContract;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Routing\RouteCollection;
use Symfony\Component\Console\Attribute\AsCommand;
use Stancl\Tenancy\Contracts\Tenant;
use Illuminate\Container\Container;

#[AsCommand(name: 'tenants:route:cache')]
class RouteCacheCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'tenants:route:cache';

    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     *
     * @deprecated
     */
    protected static $defaultName = 'tenants:route:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a route cache file for faster route registration';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Create a new route command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->callSilent('tenants:route:clear');

        $cache_folder = dirname($this->laravel->getCachedRoutesPath());
        $tenants_cache_folder = $cache_folder.'/tenants';
        $tenants_routes_cache_folder = $cache_folder.'/tenants/routes';

        if(!File::isDirectory($tenants_cache_folder)) {
            File::makeDirectory($tenants_cache_folder, 0755, true, true);
        }

        if(!File::isDirectory($tenants_routes_cache_folder)) {
            File::makeDirectory($tenants_routes_cache_folder, 0755, true, true);
        }

        tenancy()
            ->query()
            ->cursor()
            ->each(function (Tenant $tenant) use($tenants_routes_cache_folder) {
                $fresh_app = tap(require $this->laravel->bootstrapPath().'/app.php', function ($app) use($tenant) {
                    $app->make(ConsoleKernelContract::class)->bootstrap();
                    tenancy()->initialize($tenant);
                });

                $routes = tap($fresh_app['router']->getRoutes(), function ($routes) {
                    $routes->refreshNameLookups();
                    $routes->refreshActionLookups();
                });

                if (count($routes) === 0) {
                    return $this->components->error("Your application doesn't have any routes.");
                }
        
                foreach ($routes as $route) {
                    $route->prepareForSerialization();
                }
        
                $this->files->put(
                    $tenants_routes_cache_folder.'/tenant-'.$tenant->getTenantKey().'-routes.php', $this->buildRouteCacheFile($routes)
                );
        
                $this->components->info("[Tenant] {$tenant->getTenantKeyName()}: {$tenant->getTenantKey()} => Routes cached successfully.");

                $storage_path = storage_path();
                try {
                    mkdir("$storage_path/framework/", 0775, true);
                    mkdir("$storage_path/framework/cache", 0775, true);
                } catch (\Exception $e) {
                }
            });

        // Cache core app routes
        $routes = $this->getFreshApplicationRoutes();

        if (count($routes) === 0) {
            return $this->components->error("Your application doesn't have any routes.");
        }

        foreach ($routes as $route) {
            $route->prepareForSerialization();
        }

        $this->files->put(
            $this->laravel->getCachedRoutesPath(), $this->buildRouteCacheFile($routes)
        );

        $this->components->info('Routes cached successfully.');
    }

    /**
     * Boot a fresh copy of the application and get the routes.
     *
     * @return \Illuminate\Routing\RouteCollection
     */
    protected function getFreshApplicationRoutes()
    {
        return tap($this->getFreshApplication()['router']->getRoutes(), function ($routes) {
            $routes->refreshNameLookups();
            $routes->refreshActionLookups();
        });
    }

    /**
     * Get a fresh application instance.
     *
     * @return \Illuminate\Contracts\Foundation\Application
     */
    protected function getFreshApplication()
    {
        return tap(require $this->laravel->bootstrapPath().'/app.php', function ($app) {
            $app->make(ConsoleKernelContract::class)->bootstrap();
        });
    }

    /**
     * Build the route cache file.
     *
     * @param  \Illuminate\Routing\RouteCollection  $routes
     * @return string
     */
    protected function buildRouteCacheFile(RouteCollection $routes)
    {
        $stub = $this->files->get(__DIR__.'/stubs/routes.stub');

        return str_replace('{{routes}}', var_export($routes->compile(), true), $stub);
    }
}
