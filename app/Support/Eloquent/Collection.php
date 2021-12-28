<?php

namespace App\Support\Eloquent;

class Collection extends \Illuminate\Database\Eloquent\Collection
{
    /**
     * Get the type of the entities being queued.
     *
     * NOTE: Difference is that this Eloquent Collection can have different model types in it!
     * This is needed for Livewire!
     * For example:
     * - Cart component in which we want to store multiple different models in one collection and properly hydrate them without any error!
     *
     * Problem: \Illuminate\Database\Eloquent\Collection checks if classes of all elements are equal to the class of the first element. If not, throws an exception.
     * Possible workaround: Override getQueueableClass() to prevent this check and overcome unnecessary Exception.
     * Use this Collection in Livewire components for properties that need to:
     * - Store multiple model types in one collection (like products, product-variations, courses, properties etc.)
     * - Hydrated/Dehydrated by Livewire
     *
     * @return string|null
     *
     */
    public function getQueueableClass()
    {
        return null;
    }
}
