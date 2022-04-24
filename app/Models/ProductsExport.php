<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        return Product::all();
    }

    public function headings(): array
    {
        return [
            'name',
            'description',
            'current_stock',
            'condition',
            'price',
            'permalink',
            'image',
            'brand',
        ];
    }

    /**
     * @var Product
     */
    public function map($product): array
    {
        return [
            $product->name,
            Date::dateTimeToExcel($product->created_at),
        ];
    }
}
