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
        // When Business Settings model is saved, remove tenant business settings cached object and set it again
        $cache_key = tenant('id') . '_tenant_settings';
        $settings = Cache::get($cache_key, null);

        if(!empty($settings)) {
            Cache::forget($cache_key);
            Cache::put($cache_key, $settings);
        }

        TenantSettings::setAll(); // Set cache again in TenantSettingsService singleton
    }
}
