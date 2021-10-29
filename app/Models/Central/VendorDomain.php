<?php

namespace App\Models\Central;

use Illuminate\Database\Eloquent\Model;

class VendorDomain extends Model
{
    protected $table = 'vendor_domains';

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }
}
