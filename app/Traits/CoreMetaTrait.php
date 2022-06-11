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

        if($this->isProduct() && $this->type === ProductTypeEnum::course()->value) {
            return castValuesForGet($setting, CoreMeta::metaProductDataTypes())[$key] ?? null;
        }

        if($this->isPlan()) {die(print_r());
            return castValuesForGet($setting, CoreMeta::metaPlanDataTypes())[$key] ?? null;
        }
        
        if($fresh) {
            return $this->core_meta()->where('key', $key)?->first()?->value;
        } else {
            return $this->core_meta->where('key', $key)?->first()?->value ?? null;
        }
    }

    public function saveCoreMeta($key, $value)
    {
        try {
            CoreMeta::updateOrCreate(
                [
                    'subject_id' => $this->id,
                    'subject_type' => $this::class,
                    'key' => $key,
                ],
                [
                    'value' => $value,
                ]
            );

            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage);
        }
    }

    // Specific CoreMeta
    public function getStripeProductID() {
        return $this->getCoreMeta(StripeService::getStripeMode().'stripe_product_id');
    }

    public function getStripePriceID() {
        return $this->getCoreMeta(StripeService::getStripeMode().'stripe_price_id');
    }
}
