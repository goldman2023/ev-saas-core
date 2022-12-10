<?php

declare(strict_types=1);

namespace App\Console\Commands\Tenancy;

use Illuminate\Database\Console\Migrations\RollbackCommand;
use Illuminate\Database\Migrations\Migrator;
use Stancl\Tenancy\Concerns\DealsWithMigrations;
use Stancl\Tenancy\Concerns\ExtendsLaravelCommand;
use Stancl\Tenancy\Concerns\HasATenantsOption;
use Stancl\Tenancy\Events\DatabaseRolledBack;
use Stancl\Tenancy\Events\RollingBackDatabase;

// TODO: Rollback tenant/theme specific migrations for each tenant (if any)
class Rollback extends RollbackCommand
{
    use HasATenantsOption, DealsWithMigrations, ExtendsLaravelCommand;

    protected static function getTenantCommandName(): string
    {
        return 'tenants:rollback';
    }

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rollback migrations for tenant(s) (with theme specific migrations).';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Migrator $migrator)
    {
        parent::__construct($migrator);

        $this->specifyTenantSignature();
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

            event(new RollingBackDatabase($tenant));

            // Rollback
            parent::handle();

            event(new DatabaseRolledBack($tenant));

            // Reset path to default (without $theme_migrations_file_path)
            $this->input->setOption('path', config('tenancy.migration_parameters')['--path']);
        });
    }
}
