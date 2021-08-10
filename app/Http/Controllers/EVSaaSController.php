<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;

class EVSaaSController extends Controller
{
    // Funtion to display tenant info
    public function info() {
        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    }

    public function create() {
        $tenant1 = Tenant::create(['id' => 'eim']);
        $tenant1->domains()->create(['domain' => 'eim.localhost']);

        $tenant1->save();

        dd($tenant1);
        return view('core.tenants.create');
    }

    public function store(Request $request) {
        $tenant1 = Tenant::create(['id' => 'foo']);
        $tenant1->domains()->create(['domain' => 'foo.localhost']);

        $tenant1->save();

        dd($tenant1);
    }
}
