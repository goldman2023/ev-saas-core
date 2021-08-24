<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class ProductTable extends LivewireDatatable
{
    public $model = Product::class;

    public function columns()
    {
        return [
            Column::name('thumbnail_img')->view('livewire.tables.image-field'),

            Column::name('name')
                ->filterable(),

            NumberColumn::name('unit_price')
                ->filterable(),

            NumberColumn::name('id')
                ->filterable(),

            Column::name('brand.name')
                ->label('Brand'),

            Column::name('category.name')
                ->label('Category'),

        ];
    }
}
