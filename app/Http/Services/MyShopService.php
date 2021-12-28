<?php

namespace App\Http\Services;

use App\Models\Shop;
use App\Models\ShopSetting;
use App\Models\TenantSetting;
use App\Models\User;
use Cache;
use Illuminate\Database\Eloquent\Collection;
use Session;
use EVS;
use FX;

class MyShopService
{
    protected $shop = null;
    protected $settings = [];

    public function __construct($app)
    {
        $this->init();
    }

    protected function init() {
        // TODO: Cache Shop with all necessary relations (like payment_methods and payment_methods_universal etc.)!
        if(auth()->user() instanceof User) {
            if (auth()->user()->isSeller() || auth()->user()->isStaff() || auth()->user()->isAdmin()) {
                $this->shop = auth()->user()->shop->first();

                $this->setSettings();
            }
        }
    }

    public function getShop() {
        return $this->shop;
    }


    /*
     * Shop Settings
     */
    public function getSetting($name, $default = null) {
        return isset($this->settings[$name]) ? ($this->settings[$name]['value'] ?? $default) : $default;
    }

    public function getAllSettings() {
        return $this->settings;
    }

    protected function setSettings() {
        // Construct the cache key: {tenant_id}-App\Models\ShopSetting-App\Models\Shop-{shop_id}
        $cache_key = Cache::store()->getModelCacheKey(ShopSetting::class.'-'.Shop::class, $this->shop->id);
        $settings = Cache::get($cache_key, null);

        // If cache is empty, add settings array to the cache and return settings
        if (empty($settings)) {
            $settings = $this->shop->settings()->select(['id','shop_id','setting','value'])->get()->keyBy('setting')->toArray();

            // Cache the settings if they are found in DB
            if (!empty($settings)) {
                Cache::forget($cache_key);
                Cache::put($cache_key, $settings);
            }
        }

        $this->settings = !empty($settings) ? $settings : [];
    }

}
