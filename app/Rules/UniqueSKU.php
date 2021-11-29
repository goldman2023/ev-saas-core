<?php

namespace App\Rules;

use App\Models\ProductStock;
use Illuminate\Contracts\Validation\Rule;

class UniqueSKU implements Rule
{
    protected $items;

    public function __construct($items = null) {
        $this->items = $items;
    }

    public function passes($attribute, $value): bool
    {
        if($this->items->has($attribute)) {
            $variation = $this->items->get($attribute);

            $exists = ProductStock::where('sku', $value)->where('id', '!=', $variation->stock->id)->exists();
        }

        return !$exists;
    }

    public function message()
    {
        return translate('SKU must be unique. Another item is using it already.');
    }
}
