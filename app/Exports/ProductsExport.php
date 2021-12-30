<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromCollection, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::all();
    }

    public function map($product): array
    {
        $brand = "inhouse";
        if(isset($product->brand)) {
            $brand = $product->brand->name;
        }
        return [
            $product->name,
            $product->description,
            $product->current_stock,
            $product->condition,
            $product->price,
            $product->permalink,
            $product->getThumbnail(),
            $brand
        ];
    }
}
