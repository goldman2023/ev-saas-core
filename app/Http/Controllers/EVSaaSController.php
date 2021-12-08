<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;

class EVSaaSController extends Controller
{
    public function index()
    {
        return view('core.index');
    }
    // Funtion to display tenant info
    public function info()
    {
        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    }

    public function create()
    {
        $tenant1 = Tenant::create(['id' => 'tailwind']);

        /* !Important, on local development server, you need to point the tenant domain in your /etc/hosts file to 127.0.01   domain.localhost*/
        $tenant1->domains()->create(['domain' => 'tailwind.localhost']);

        $tenant1->save();

        dd($tenant1);
        return view('core.tenants.create');
    }

    public function store(Request $request)
    {
        $tenant1 = Tenant::create(['id' => 'foo']);
        $tenant1->domains()->create(['domain' => 'foo.localhost']);

        $tenant1->save();

        dd($tenant1);
    }

    public function design_settings()
    {
        return view('frontend.dashboard.settings.design-settings');
    }

    public function design_settings_store(Request $request)
    {
        $domain = tenant()->domains()->first();
        $domain->theme = $request->theme;
        $domain->save();


        return redirect()->back();
    }


    public function domain_settings()
    {
        return view('frontend.dashboard.settings.domain-settings');
    }
}
