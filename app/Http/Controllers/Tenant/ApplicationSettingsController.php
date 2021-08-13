<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApplicationSettingsController extends Controller
{
    public function show()
    {
        return view('tenant.settings.application');
    }

    public function storeConfiguration(Request $request)
    {
        $validated = $this->validate($request, [
            'company' => 'required|string|max:255',
        ]);

        tenant()->update($validated);

        return redirect()->back()->with('success', 'Configuration updated.');
    }    
}
