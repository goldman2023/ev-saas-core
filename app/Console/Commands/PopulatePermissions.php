<?php

namespace App\Console\Commands;

use App\Http\Services\PermissionsService;
use App\Models\Central\Tenant;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PopulatePermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:populate {--tenant_id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populates permissions table based on permissions defined in PermissionsService';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $tenant_id = $this->option('tenant_id');
        $tenant = Tenant::findOrFail($tenant_id); // Fail if tenant is not found!

        // init tenant
        tenancy()->initialize($tenant);

        // Populate Permissions
        $permissions = new PermissionsService(init: true);
        $all_permissions = $permissions->getAllPossiblePermissions();
        $default_guard = config('auth.defaults.guard', 'web');

        $existing_permissions = app(config('permission.models.permission'))->where('guard_name', $default_guard)->get();

        $existing_keys = $existing_permissions->pluck('name');
        $all_keys = $all_permissions->keys();

        $now = Carbon::now('utc')->toDateTimeString();
        $missing_permissions = $all_permissions->filter(fn($item, $key) => $all_keys->diff($existing_keys)->contains($key))
        ->map(fn($item, $key) => [
            'name' => $key,
            'guard_name' => $default_guard,
            'created_at' => $now,
            'updated_at' => $now
        ])->values();

        // insert missing permissions
        DB::beginTransaction();

        try {
            app(config('permission.models.permission'))->insert($missing_permissions->toArray());

            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            $this->error('Something went wrong while inserting missing permissions: '.$e->getMessage());
            Log::debug('Something went wrong while inserting missing permissions: '.$e->getMessage());
        }

        $this->info('Missing permissions inserted properly! Number of new permissions added: '.$missing_permissions->count());


        // Populate Roles
        $this->info('Inserting roles now...');

        $all_roles = $permissions->getRoles(from_db: false);
        $existing_roles = app(config('permission.models.role'))->where('guard_name', $default_guard)->get();

        $existing_roles_keys = $existing_roles->pluck('name');
        $all_roles_keys = $all_roles->keys();

        $missing_roles = $all_roles->filter(fn($item, $key) => $all_roles_keys->diff($existing_roles_keys)->contains($key))
            ->map(fn($item, $key) => [
                'name' => $key,
                'guard_name' => $default_guard,
                'created_at' => $now,
                'updated_at' => $now
            ])->values();


        // insert missing roles
        DB::beginTransaction();

        try {
            app(config('permission.models.role'))->insert($missing_roles->toArray());

            $this->info('Missing roles inserted properly! Number of new roles added: '.$missing_roles->count());

            // Attaching permissions to roles
            foreach($all_roles_keys as $key => $role_name) {
                $role_permissions = collect($all_roles->get($role_name))->keys();
                $role = app(config('permission.models.role'))->where('name', $role_name)->first();

                if(!empty($role)) {
                    foreach($role_permissions as $perm) {
                        $role->givePermissionTo($perm);
                    }
                    $this->info('Following permissions added to role `'.$role_name.'` (total of '.$role_permissions->count().' permissions): '. $role_permissions->join(','));
                }
            }

            $this->info('Permissions added to all roles successfully!');

            DB::commit();
        } catch(\Throwable $e) {
            DB::rollback();
            $this->error('Something went wrong while inserting missing roles: '.$e->getMessage());
            Log::debug('Something went wrong while inserting missing roles: '.$e->getMessage());
        }



        return Command::SUCCESS;
    }
}
