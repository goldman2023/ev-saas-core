<?php

namespace App\Console\Commands\Tenancy;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Attribute\AsCommand;
use Stancl\Tenancy\Contracts\Tenant;


#[AsCommand(name: 'tenants:route:clear')]
class RouteClearCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'tenants:route:clear';

    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     *
     * @deprecated
     */
    protected static $defaultName = 'tenants:route:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove the core route cache file and tenant route cache files';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Create a new route clear command instance.
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
        $this->files->delete($this->laravel->getCachedRoutesPath());
        

        // VUKASIN CODE - Tenancy routes and themes
        $cache_folder = dirname($this->laravel->getCachedRoutesPath());
        $tenants_cache_folder = $cache_folder.'/tenants';
        $tenants_routes_cache_folder = $cache_folder.'/tenants/routes';

        tenancy()
            ->query()
            ->cursor()
            ->each(function (Tenant $tenant) use($tenants_routes_cache_folder) {
                $this->files->delete($tenants_routes_cache_folder.'/tenant-'.$tenant->getTenantKey().'-routes.php');
            });

        $this->components->info('Route caches cleared successfully.');
    }
}
