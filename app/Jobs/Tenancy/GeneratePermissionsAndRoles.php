<?php

namespace App\Jobs\Tenancy;

use Stancl\Tenancy\Contracts\Tenant;
use Illuminate\Support\Facades\Artisan;
use DB;
use App\Models\User;
use Spatie\Permission\Models\Role;

class GeneratePermissionsAndRoles
{
    protected $tenant;

    public function __construct(Tenant $tenant)
    {
        $this->tenant = $tenant;
    }

    public function handle()
    {
        Artisan::call('permissions:populate', [
            '--tenant_id' => $this->tenant->id,
        ]);

        // After permissions and roles are populated, find all seeded `seller` users and attach all `Owner` permissions to them
        $this->tenant->run(function ($tenant) {
            tenancy()->initialize($tenant);

            // Select sellers and attach owner permissions to all of them
            DB::beginTransaction();

            try {
                $sellers = User::where('user_type', 'seller')->get();
                $owner_permissions = Role::where('name', 'Owner')->first()->permissions->pluck('id');

                foreach($sellers as $seller) {
                    // assign all permissions to sellers
                    foreach($owner_permissions as $perm_id) {
                        $seller->givePermissionTo($perm_id);
                    }

                    $seller->assignRole(Role::where('name', 'Owner')->first()->id); // asign Owner role to seller
                }
                
                DB::commit();
            } catch(\Exception $e) {
                DB::rollback();
                dd($e);
            }
        });
    }
}
