<?php

namespace App\Console\Commands;

use App\Models\Central\Tenant;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Console\Migrations\FreshCommand;
use Illuminate\Database\Migrations\Migrator;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Stancl\Tenancy\Concerns\DealsWithMigrations;
use Stancl\Tenancy\Concerns\HasATenantsOption;
use Stancl\Tenancy\Events\DatabaseMigrated;
use Stancl\Tenancy\Events\MigratingDatabase;
use Symfony\Component\Console\Input\InputOption;

class PullTenants extends FreshCommand
{
    use HasATenantsOption, DealsWithMigrations;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates demo tenant, migrates tables and seeds data OR pulls tenants from Central App, migrates tables and seeds data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->setName('tenants:pull');
        $this->addOption('--type', '-t', InputOption::VALUE_REQUIRED, 'Determines the type of pull: demo | real', 'demo');
        $this->addOption('--fetch', '-fe', InputOption::VALUE_REQUIRED, 'Determines the fetch type: local | production', 'local');
        $this->specifyParameters();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Specify Default options
        foreach (config('tenancy.pull_parameters') as $parameter => $value) {
            if (! $this->input->hasParameterOption($parameter)) {
                $this->input->setOption(ltrim($parameter, '-'), $value);
            }
        }

        if (! $this->confirmToProceed()) {
            return;
        }

        //$force = $this->input->getOption('force'); // Force is TRUE by default
        $type = $this->input->getOption('type');
        $fetch = $this->input->getOption('fetch');

        if($type === 'demo') {
            $tenant = Tenant::find('demo');

            if(!empty($tenant)) {
                //DB::statement("DROP DATABASE IF EXISTS ".$tenant->tenancy_db_name); // this is just in case.

                // TODO: Change tenant_id foreign key in domains table to have a RESTRICT onDelete constraint
                $tenant->domains()->delete(); // Remove domains manually since they should be in RESTRICTED onDelete constraint
                $tenant->delete(); // remove tenant itself - this will remove tenant DB too - Check: TenancyServiceProvider -> Events\TenantDeleted::class
            }

            // Create "demo" Tenant and it's domain AND Migrate tables. Database creation and migration will take place once Events\TenantCreated is fired!
            $tenant = Tenant::create([
                'id' => 'demo',
                'tenancy_db_name' => 'demo_tenant',
                'stripe_id' => '123',
                'email' => 'demo@example.com',
                'card_brand' => 'visa',
                'card_last_four' => '0000',
                'trial_ends_at' => date('Y-m-d',strtotime('+999 day'))
            ]);
            $tenant->domains()->create(['domain' => 'demo-ev.localhost']);

            $tenant->save();

            $this->info('Demo Tenant successfully created and migrated.');

            // Seed Demo tenant
            Artisan::call('tenants:seed');

            $this->info('Demo Tenant successfully seeded.');
        } else if($type === 'real') {
            if($fetch === 'local') {
                $tenants = Tenant::all();

                if(empty($tenants)) {
                    $this->error('Cannot create tenants from local Central DB because there are no tenants rows in tenants table');
                    return false;
                }

                // Fresh Migrate each existing tenant
                tenancy()->runForMultiple($this->option('tenants'), function ($tenant) {
                    $this->line("Tenant: {$tenant['id']}");

//                    $user = config('database.connections.tenant.username');
//                    $pass = config('database.connections.tenant.password');
//                    $db = config('database.connections.tenant.database');
//                    $port = config('database.connections.tenant.port');
//
//                    $output = shell_exec('echo "SELECT \'CREATE DATABASE '.$db.'\' WHERE NOT EXISTS (SELECT FROM pg_database WHERE datname = \''.$db.'\')\gexec" | psql "host=pgsql port='.$port.' dbname='.$db.' user='.$user.' password='.$pass.'"');
//                    - don't forget to delete bash history after command like this ^^^!

                    event(new MigratingDatabase($tenant));

                    // Fresh Migrate the current Tenant
                    parent::handle();

                    event(new DatabaseMigrated($tenant));
                });

                // Seed tenants from Central App
                Artisan::call('tenants:seed');

                $this->info('Tenants successfully seeded.');
            } else if($fetch === 'production') {
                // TODO: Download tenants DBs and import to local env

            }
        }
    }
}
