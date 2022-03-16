<?php

namespace App\Http\Controllers\Central;

use App\Actions\CreateTenantAction;
use App\Http\Controllers\Controller;
use App\Tenant;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class RegisterTenantController extends Controller
{
    public function show()
    {
        return view('central.tenants.register');
    }

    public function submit(Request $request)
    {
        $data = $this->validate($request, [
            'domain' => 'required|string|unique:domains',
            'email' => 'required|email|max:255|unique:tenants',
            'password' => 'required|string|confirmed|max:255',
        ]);


        $data['password'] = bcrypt($data['password']);

        $domain = $data['domain'] . '.' . config('tenancy.central_domains.0');
        unset($data['domain']);

        $tenant = (new CreateTenantAction)($data, $domain);

        // We impersonate user with id 1. This user will be created by the CreateTenantAdmin job.
        return redirect($tenant->impersonationUrl(1));
    }

    public function createDemoTenant() {
        // $sellers = User::where('user_type', 'seller')->get();
        // $owner_permissions = Role::where('name', 'Owner')->first()->permissions->pluck('id')->toArray();
        // dd($owner_permissions);

        $tenant = (new CreateTenantAction)([
            'email' => 'jockovicvukasin@gmail.com',
            'password' => '1234',
            'name' => 'Pix-Pro',
            'company' => 'Pix-pro',
            'tenancy_db_name' => 'pix-pro'
        ], 'pix-pro.' . config('tenancy.central_domains.0'));

        return redirect($tenant->impersonationUrl(1));
    }
}
