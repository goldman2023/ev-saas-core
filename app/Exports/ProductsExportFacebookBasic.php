<?php

namespace App\Exports;

use App\Facades\MyShop;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExportFacebookBasic implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        /* TODO: Add a complete products export for admin only  */

        /* IMPORTANT: Do not query products directly, only via shop service, so people don't
        export products from other shops */
        return MyShop::getShop()->products()->get();
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
        if (isset($product->brand)) {
            $brand = $product->brand->name;
        }

        $first_variation = $product->variations->first();

        $price = 0;
        $price = ($product->hasVariations()) ? $first_variation->total_price : $product->total_price;

        return [
            $product->id,
            substr($product->name, 0, 149),
            strip_tags($product->description),
            /* TODO: Make stock dynamic, how to do in_stock/out_of_stock?  */
            'in stock',
            'new',
            /*  TODO: Make currency dynamic */
            $price,
            $product->getPermalink(),
            $product->getThumbnail(),
            $brand
        ];
    }
}
