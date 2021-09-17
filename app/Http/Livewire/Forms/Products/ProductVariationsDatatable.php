<?php

namespace App\Http\Livewire\Forms\Products;

use App\Models\ProductStock;
use App\Models\ProductVariation;
use Ev;
use Illuminate\View\Component;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;

class ProductVariationsDatatable extends DataTableComponent
{
    protected string $pageName = 'product_variations';
    protected string $tableName = 'product_variations';

    public $product;
    public $attributes;
    public $variations;
    public $all_combinations;
    public $rows;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($product = null, $variationAttributes = [], $variations = [])
    {
        parent::mount();

        $this->product = $product;
        $this->attributes = collect($variationAttributes);
        $this->variations = collect($variations);
        $this->all_combinations = collect([]);
        $this->rows = collect([]);

        /*if($this->attributes->isNotEmpty()) {
            foreach($this->attributes as $key => $att) {
                $this->attributes[$key]->attribute_values = collect($this->attributes[$key]->attribute_values)->keyBy('id')->map(function($item) {
                    return (object) $item;
                });
            }
        }*/

        // Creates all combinations.
        $this->createAllCombinations();

        // TODO: Fix the logic to use all only on bulk action and ADD single variation addition
        $this->useAllVariations();
    }

    public array $sortNames = [
        /*'email_verified_at' => 'Verified',
        'two_factor_secret' => '2FA',*/
    ];

    public array $filterNames = [
        /*'type' => 'User Type',
        'verified' => 'E-mail Verified',
        '2fa' => 'Two Factor Authentication',*/
    ];

    public array $bulkActions = [
        'useAllVariations' => 'Generate all',
    ];

    public function dehydrate()
    {
        parent::dehydrate();
        $this->dispatchBrowserEvent('initProductForm');
    }

    public function useAllVariations() {
        // Merge all combinations with currently added variations.
        $this->rows = $this->all_combinations->keyBy('name')->merge($this->variations->keyBy('name'))->map(function($item) {
            $item = (object) $item;
            $item->temp_stock = (object) $item->temp_stock;
            return $item;
        });
    }

    public function createAllCombinations()
    {
        $variations = collect([]);
        $matrix = EV::generateAllVariations($this->attributes);

        if(!empty($matrix)) {
            foreach($matrix as $index => $combo) {
                if(empty($combo)) {
                    continue;
                }

                $variation = new ProductVariation();
                $variation->id = $index; // THIS IS JUST TEMPORARY! Remember to set ID to null before saving variations! Some ID is necessary for wire:key
                $variation->product_id = $this->product->id;

                $variant_data = [];

                foreach($combo as $value) {
                    $variant_data[$value['attribute_id']] = [
                        'attribute_value_id' => $value['id'],
                        'attribute_id' => $value['attribute_id'],
                    ];
                }
                $variation->variant = $variant_data;
                $variation->price = $this->product->unit_price ?? 0;
                $variation->image = null;
                $variation->temp_stock = new ProductStock();
                $variation->temp_stock->qty = 0;
                $variation->temp_stock->sku = '';
                $this->all_combinations->push($variation);
            }
        }

        //$this->rows = collect($this->variations);

        // Not included in package, just an example.
        //$this->notify(translate('You successfully created all variations based on selected attributes.'), 'success');
    }

    public function filters(): array
    {
        return [

        ];
    }

    public function columns(): array
    {

        $columns = [
            Column::make('Image', 'image')
                ->sortable(),
            Column::make('Name', 'name')
                ->sortable(),
        ];

        if($this->attributes->isNotEmpty()) {
            foreach($this->attributes as $att) {
                $att = (object) $att;
                $columns[] = Column::make($att->name, \Str::slug($att->name))
                    ->sortable()
                    ->addClass('hidden md:table-cell');
            }
        }

        $columns = array_merge($columns, [
            Column::make('Price', 'price')
                ->sortable(),
            Column::make('QTY', 'qty')
                ->sortable(),
            Column::make('SKU', 'sku')
                ->sortable(),
        ]);

        $columns[] = Column::blank();

        return $columns;
    }

    public function query()
    {
        return ProductVariation::query()->where('product_id', $this->product->id);
    }

    public function rowView(): string
    {
        return 'livewire.forms.products.product-variations-datatable';
    }
}
