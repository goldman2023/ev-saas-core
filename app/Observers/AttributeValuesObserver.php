<?php

namespace App\Observers;

use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\TenantSetting;
use Cache;

class AttributeValuesObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public bool $afterCommit = false;

    /**
     * Handle the "saved" event.
     *
     * @param AttributeValue $attribute_value
     * @return void
     */
    public function saved(AttributeValue $attribute_value)
    {
        // when saved
    }

    /**
     * Handle the "deleting" event.
     *
     * @param AttributeValue $attribute_value
     * @return void
     */
    public function deleting(AttributeValue $attribute_value)
    {
        // When deleting an AttributeValue, remove it's translations and relationships too!
        // IMPORTANT: This is already done by MySQL constraints!
        // $attribute_value->translations()->delete();
        // $attribute_value->attribute_value_relationship()->delete();

        $attribute_value->core_meta()->delete(); // remove attribute value core metas
    }
}
