<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\TenantSettingCollection;
use App\Models\TenantSetting;

class TenantSettingController extends Controller
{
    public function index()
    {
        return new TenantSettingCollection(TenantSetting::all());
    }
}
