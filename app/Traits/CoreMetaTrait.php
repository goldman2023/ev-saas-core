<?php

namespace App\Traits;

use Log;
use Route;
use StripeService;
use WEF;
use App\Models\CoreMeta;
use App\Enums\ProductTypeEnum;

trait CoreMetaTrait
{
    public function core_meta()
    {
        return $this->morphMany(CoreMeta::class, 'subject');
    }

    public function isStripeProduct()
    {
        if ($this->core_meta()->where('key', 'live_stripe_product_id')->first()) {
            return true;
        }

        if ($this->core_meta()->where('key', 'test_stripe_product_id')->first()) {
            return true;
        }

        return false;
    }

    public function getCoreMeta($key, $fresh = false, $ad_hoc_data_type = null)
    {
        $setting = $fresh ? $this->core_meta()->where('key', $key)->get()->keyBy('key')->toArray() : $this->core_meta->where('key', $key)->keyBy('key')->toArray();
        
        if(empty($ad_hoc_data_type)) {
            $data_types = WEF::getWEFDataTypes($this);
        } else {
            $data_types = [$key => $ad_hoc_data_type];
        }
        
        if(!empty($data_types)) {
            return castValuesForGet($setting, $data_types)[$key] ?? null;
        } else {
            if($fresh) {
                return $this->core_meta()->where('key', $key)?->first()?->value ?? null;
            } else {
                return $this->core_meta->where('key', $key)?->first()?->value ?? null;
            }
        }
    }

    public function getWEF($key, $fresh = false, $ad_hoc_data_type = null) {
        return $this->getCoreMeta($key, $fresh, $ad_hoc_data_type);
    }

    public function saveCoreMeta($key, $value, $ad_hoc_data_type = null)
    {
        if(empty($ad_hoc_data_type)) {
            $data_types = WEF::getWEFDataTypes($this);
        } else {
            $data_types = [$key => $ad_hoc_data_type];
        }

        try {
            CoreMeta::updateOrCreate(
                [
                    'subject_id' => $this->id,
                    'subject_type' => $this::class,
                    'key' => $key,
                ],
                [
                    'value' => $value === null ? $value : castValueForSave($key, $value, $data_types),
                ]
            );

            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage);
        }
    }

    public function setWEF($key, $value, $ad_hoc_data_type = null) {
        return $this->saveCoreMeta($key, $value, $ad_hoc_data_type);
    }

    // Specific CoreMeta
    public function getStripeCustomerID() {
        return $this->getCoreMeta(stripe_prefix('stripe_customer_id'));
    }

    public function getStripeProductID() {
        return $this->getCoreMeta(stripe_prefix('stripe_product_id'));
    }
    
    public function getStripePriceID() {
        return $this->getCoreMeta(stripe_prefix('stripe_price_id'));
    }

    public function getStripeAnnualPriceID() {
        return $this->getCoreMeta(stripe_prefix('stripe_annual_price_id'));
    }

    public function getStripeMonthlyPriceID() {
        return $this->getCoreMeta(stripe_prefix('stripe_monthly_price_id'));
    }
}
