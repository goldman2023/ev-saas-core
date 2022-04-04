<?php

namespace App\Observers;

use App\Facades\TenantSettings;
use App\Models\TenantSetting;
use App\Models\User;
use Cache;

class TenantSettingsObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public bool $afterCommit = true;

    /**
     * Handle the Business Settings "saved" event.
     *
     * @param TenantSetting $setting
     * @return void
     */
    public function saved(TenantSetting $setting)
    {
        TenantSettings::clearCache(); // Clear cache
    }
}
