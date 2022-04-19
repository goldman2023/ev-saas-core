<?php

namespace App\Traits;

use Route;
use App\Models\CoreMeta;

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

    public function getCoreMeta($key) {
        // TODO: Implement castValuesForGet($core_meta, $data_types); here
        return $this->core_meta->where('key', $key)?->first()?->value ?? null;
    }

    public function saveCoreMeta($key, $value) {
        try {
            CoreMeta::updateOrCreate(
                [
                    'subject_id' => $this->id,
                    'subject_type' => $this::class,
                    'key' => $key,
                ],
                [
                    'value' => $value
                ]
            );

            return true;
        } catch(\Exception $e) {
            return false;
        }
    }
}
