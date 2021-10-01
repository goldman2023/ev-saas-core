<?php

namespace App\Observers;

use App\Facades\BusinessSettings;
use App\Models\BusinessSetting;
use App\Models\User;
use Cache;

class BusinessSettingsObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public $afterCommit = true;

    /**
     * Handle the Business Settings "saved" event.
     *
     * @param  \App\Models\BusinessSetting  $setting
     * @return void
     */
    public function saved(BusinessSetting $setting)
    {
        // When Business Settings model is saved, remove tenant business settings cached object and set it again
        $cache_key = tenant('id') . '_business_settings';
        $settings = Cache::get($cache_key, null);

        if(!empty($settings)) {
            Cache::forget($cache_key);
            Cache::put($cache_key, $settings);
        }

        BusinessSettings::setAll(); // Set cache again in BusinessSettingsService singleton
    }
}
