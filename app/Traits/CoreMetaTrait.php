<?php

namespace App\Traits;

use App\Models\CoreMeta;
use App\Enums\ProductTypeEnum;
use Route;
use StripeService;
use Log;

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

    public function getCoreMeta($key, $fresh = false)
    {
        // TODO: Implement castValuesForGet($core_meta, $data_types); here
        $setting = $fresh ? $this->core_meta()->where('key', $key)->get()->keyBy('key')->toArray() : $this->core_meta->where('key', $key)->keyBy('key')->toArray();
        $data_types = [];

        if($this->isProduct()) {
            $data_types = CoreMeta::metaProductDataTypes();
        }

        if($this->isPlan()) {
            $data_types = CoreMeta::metaPlanDataTypes();
        }

        if($this->isUserSubscription()) {
            $data_types = CoreMeta::metaUserSubscriptionDataTypes();
            
        }
        
        if(!empty($data_types)) {
            return castValuesForGet($setting, $data_types)[$key] ?? null;
        } else {
            if($fresh) {
                return $this->core_meta()->where('key', $key)?->first()?->value;
            } else {
                return $this->core_meta->where('key', $key)?->first()?->value ?? null;
            }
        }
    }

    public function saveCoreMeta($key, $value)
    {
        $data_types = [];

        if($this->isProduct()) {
            $data_types = CoreMeta::metaProductDataTypes();
        }

        if($this->isPlan()) {
            $data_types = CoreMeta::metaPlanDataTypes();
        }

        if($this->isUserSubscription()) {
            $data_types = CoreMeta::metaUserSubscriptionDataTypes();    
        }

        try {
            CoreMeta::updateOrCreate(
                [
                    'subject_id' => $this->id,
                    'subject_type' => $this::class,
                    'key' => $key,
                ],
                [
                    'value' => castValueForSave($key, $value, $data_types),
                ]
            );

            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage);
        }
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
