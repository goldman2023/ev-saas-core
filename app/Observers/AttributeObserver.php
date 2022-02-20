<?php

namespace App\Observers;

use App\Models\Attribute;

class AttributeObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public bool $afterCommit = false;

    /**
     * Handle the Attribute "created" event.
     *
     * @param  \App\Models\Attribute  $attribute
     * @return void
     */
    public function created(Attribute $attribute)
    {
        //
    }

    /**
     * Handle the Attribute "updated" event.
     *
     * @param  \App\Models\Attribute  $attribute
     * @return void
     */
    public function updated(Attribute $attribute)
    {
        //
    }

    /**
     * Handle the Attribute "deleted" event.
     *
     * @param  \App\Models\Attribute  $attribute
     * @return void
     */
    public function deleted(Attribute $attribute)
    {
        //
    }

    /**
     * Handle the Attribute "deleting" event.
     *
     * @param  \App\Models\Attribute  $attribute
     * @return void
     */
    public function deleting(Attribute $attribute)
    {
        // IMPORTANT: This is already done by MySQL constraints!
        // $attribute->translations()->delete();
        // $attribute->attribute_relationships()->delete();
        // $attribute->attribute_values()->delete();
    }

    /**
     * Handle the Attribute "restored" event.
     *
     * @param  \App\Models\Attribute  $attribute
     * @return void
     */
    public function restored(Attribute $attribute)
    {
        //
    }

    /**
     * Handle the Attribute "force deleted" event.
     *
     * @param  \App\Models\Attribute  $attribute
     * @return void
     */
    public function forceDeleted(Attribute $attribute)
    {
        //
    }
}
