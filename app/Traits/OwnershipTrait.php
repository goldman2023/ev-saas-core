<?php

namespace App\Traits;

use App\Models\Ownership;

trait OwnershipTrait
{
    public function owned_assets() {
        return $this->hasMany(Ownership::class, 'owner_id')->where('owner_type', $this::class)->with(['subject']);
    }
}