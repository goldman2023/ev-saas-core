<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Tenant;
use Illuminate\Http\Request;

class LoginTenantController extends Controller
{
    public function show()
    {
        return view('central.tenants.login');
    }

    public function submit(Request $request)
    {
        $this->validate($request, [
            'email' => 'exists:tenants',
        ]);

        /** @var Tenant $tenant */
        $tenant = Tenant::where('email', $email = $request->post('email'))->firstOrFail();

        return redirect(
            $tenant->route('tenant.login', ['email' => $email]),
        );
    }
}
