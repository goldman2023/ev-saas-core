<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::all();
    }


    public function headings(): array
    {
        return [
            'id',
            'title',
            'description',
            'availability',
            'condition',
            'price',
            'link',
            'image_link',
            'brand',
        ];
    }

    public function map($product): array
    {
        $brand = "inhouse";
        if(isset($product->brand)) {
            $brand = $product->brand->name;
        }
        return [
            $product->id,
            substr($product->name, 0, 149),
            strip_tags($product->description),
            /* TODO: Make stock dynamic, how to do in_stock/out_of_stock?  */
            'in stock',
            'new',
            /*  TODO: Make currency dynamic */
            $product->total_price,
            $product->permalink,
            $product->getThumbnail(),
            $brand
        ];
    }
}
