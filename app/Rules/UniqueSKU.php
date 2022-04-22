<?php

namespace App\Rules;

use App\Models\ProductStock;
use App\Models\ProductVariation;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Model;

class UniqueSKU implements Rule
{
    protected $items;

    public function __construct($items = null)
    {
        $this->items = $items;
    }

    public function passes($attribute, $value): bool
    {
        $exists = false;

        if ($this->items->has($attribute)) {
            $item = $this->items->get($attribute);

            $exists = ProductStock::where([
                ['sku', '=', $value],
                ['subject_id', '!=', $item->id],
                ['subject_type', '!=', $item::class],
            ])->exists();

//            ProductStock::where([
//                ['sku', '=', $value],
//                ['subject_id', '!=', $item->id],
//                ['subject_type', '!=', $item::class]
//            ])->dd();
        }

        return ! $exists;
    }

    public function message()
    {
        return translate('SKU must be unique. Another item is using it already.');
    }
}
