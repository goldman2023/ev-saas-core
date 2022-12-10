<?php

declare(strict_types=1);

namespace App\Console\Commands\Tenancy;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Console\Migrations\MigrateCommand;
use Illuminate\Database\Migrations\Migrator;
use Stancl\Tenancy\Concerns\DealsWithMigrations;
use Stancl\Tenancy\Concerns\ExtendsLaravelCommand;
use Stancl\Tenancy\Concerns\HasATenantsOption;
use Stancl\Tenancy\Events\DatabaseMigrated;
use Stancl\Tenancy\Events\MigratingDatabase;

class Migrate extends MigrateCommand
{
    use HasATenantsOption, DealsWithMigrations, ExtendsLaravelCommand;

    protected $description = 'Run migrations for tenant(s) (with theme specific migrations)';

    protected static function getTenantCommandName(): string
    {
        return 'tenants:migrate';
    }

    public function __construct(Migrator $migrator, Dispatcher $dispatcher)
    {
        parent::__construct($migrator, $dispatcher);

        $this->specifyParameters();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach (config('tenancy.migration_parameters') as $parameter => $value) {
            if (! $this->input->hasParameterOption($parameter)) {
                $this->input->setOption(ltrim($parameter, '-'), $value);
            }
        }

        if (! $this->confirmToProceed()) {
            return;
        }

        tenancy()->runForMultiple($this->option('tenants'), function ($tenant) {
            $this->line("Tenant: {$tenant->getTenantKey()}");

            // Include current tenant theme migrations too!
            if(!empty(tenant()->domains->first())) {
                $theme_folder = tenant()->domains->first()->theme;
                $theme_migrations_file_path = base_path().'/themes/'.$theme_folder.'/database/migrations';

                if(is_dir($theme_migrations_file_path)) {
                    $this->input->setOption('path', array_merge(config('tenancy.migration_parameters')['--path'], [$theme_migrations_file_path]));
                }
            }

            event(new MigratingDatabase($tenant));

            // Migrate
            parent::handle();

            event(new DatabaseMigrated($tenant));

            // Reset path to default (without $theme_migrations_file_path)
            $this->input->setOption('path', config('tenancy.migration_parameters')['--path']);
        });
    }
}
