<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Resources\V2\TenantSettingCollection;
use App\Models\TenantSetting;

class TenantSettingController extends Controller
{
    public function index()
    {
        return new TenantSettingCollection(TenantSetting::all());
    }
}
