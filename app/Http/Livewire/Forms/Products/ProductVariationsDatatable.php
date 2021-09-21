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

    public $dataType = 'product_variations';
    public string $primaryKey = 'name';
    public $product;
    public $attributes;
    public $variations;
    public $all_combinations;
    public $rows;
    public $buttons;
    public $wireTarget;
    public $wireLoadingClass;
    protected $listeners = [
        'refreshDatatable' => '$refresh',
        'saveVariations' => 'setVariationsData'
    ];

    public $bulkActionSetPricesID = 'ev-product-variations__set-prices';


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($product = null, $variationAttributes = [], $buttons = [], $wireTarget = null, $wireLoadingClass = 'opacity-3')
    {
        parent::mount();

        $this->product = $product;
        $this->attributes = collect($variationAttributes);
        $this->variations = collect($this->product->variations()->get()->keyBy('name')->toArray());


        $this->all_combinations = collect([]);
        $this->rows = collect([]);
        $this->buttons = $buttons;
        $this->wireTarget = $wireTarget;
        $this->wireLoadingClass = $wireLoadingClass;

        // Create or Fetch all combinations.
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
        'triggerSetAllPricesModal' => 'Set All Prices'
    ];

    public function dehydrate()
    {
        parent::dehydrate();
        $this->dispatchBrowserEvent('initProductForm');
    }

    public function dehydrateRows()
    {
        $this->rows = $this->rows->map(function($item) {
            $item = (object) $item;
            $item->temp_stock = (object) $item->temp_stock;
            return $item;
        });
    }
    public function hydrateRows() {
        $this->rows = $this->rows->map(function($item) {
            $item = (object) $item;
            $item->temp_stock = (object) $item->temp_stock;
            return $item;
        });
    }

    public function useAllVariations() {
        // Merge all combinations with currently added variations.
        $this->rows = $this->all_combinations->merge($this->variations)->map(function($item) {
            $item = (object) $item;
            $item->temp_stock = (object) $item->temp_stock;
            return $item;
        });
    }

    public function triggerSetAllPricesModal() {
        $this->dispatchBrowserEvent('triggerModal', ['id' => '#'.$this->bulkActionSetPricesID]);
    }

    public function createAllCombinations()
    {
        $variations = collect([]);
        $matrix = EV::generateAllVariations($this->attributes);

        // Get all possible combinations
        if(!empty($matrix)) {
            foreach($matrix as $index => $combo) {
                if(empty($combo)) {
                    continue;
                }

                $variation = new ProductVariation();
                $variation->id = null; // THIS IS JUST TEMPORARY! Remember to set ID to null before saving variations! Some ID is necessary for wire:key
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
                $this->all_combinations->push($variation->toArray()); // Turn the Model to Array!
            }
        }

        $this->all_combinations = $this->all_combinations->keyBy('name');

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
            Column::make('Image', 'image'),
            Column::make('Name', 'name')
                ->sortable(function(Builder $query, $direction) {
                    $this->rows = ($direction === 'desc') ? $this->rows->sortKeysDesc() : $this->rows->sortKeys();
                }),
        ];

        if($this->attributes->isNotEmpty()) {
            foreach($this->attributes as $att) {
                $att = (object) $att;
                $columns[] = Column::make($att->name, \Str::slug($att->name))
                    ->addClass('hidden md:table-cell');
            }
        }

        $columns = array_merge($columns, [
            Column::make('Price', 'price')
                ->sortable(),
            Column::make('QTY', 'qty')
                ->sortable(),
            Column::make('SKU', 'sku'),
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
        return 'livewire.forms.products.product-variations-datatable-row';
    }

    public function setVariationsData() {

        if($this->rows->isNotEmpty()) {
            $this->variations = collect([]);

            foreach ($this->rows as $index => $variation) {
                if(empty($variation->id)) {
                    // New variation - Insert
                    $temp_stock = $variation->temp_stock;
                    unset($variation->temp_stock);

                    $variation_model = new ProductVariation();
                    $variation_model->fill((array) $variation);
                    $variation_model->save();

                    // Save Product Variation Stock
                    $this->setProductVariationStocks(false, $variation_model, $temp_stock);
                    $this->variations->push($variation_model->toArray());
                } else {
                    // Old variation - Update
                    $variation_model = ProductVariation::find($variation->id);
                    $variation_model->image = $variation->image;
                    $variation_model->price = $variation->price;
                    $variation_model->save();

                    $this->setProductVariationStocks(false, $variation_model, $variation->temp_stock);
                    $this->variations->push($variation_model->toArray());
                }

                $this->variations = $this->variations->keyBy('name');
                $this->useAllVariations();

                $this->dispatchBrowserEvent('toastIt', ['id' => '#product-variations-toast', 'content' => translate('Variations successfully updated!')]);
            }
        }
    }

    protected function setProductVariationStocks($iterate = false, $variation_model = [], $stock = []) {
        if(!$iterate && !empty($variation_model) && !empty($stock)) {
            $product_stock = ProductStock::firstOrNew(['subject_id' => $variation_model->id, 'subject_type' => 'App\Models\ProductVariation']);
            $product_stock->qty = (float) ($stock->qty ?? 0);
            $product_stock->sku = $stock->sku;
            $product_stock->save();
        } else if($iterate) {
            if($this->rows->isNotEmpty()) {
                foreach($this->rows as $index => $var) {
                    $product_stock = ProductStock::firstOrNew(['subject_id' => $var->id, 'subject_type' => 'App\Models\ProductVariation']);
                    $product_stock->price = $var->price;
                    $product_stock->qty = (float) $var->temp_stock->qty;
                    $product_stock->sku = $var->temp_stock->sku;
                    $product_stock->save();
                }
            }
        }
    }

    public function modalsView(): string
    {
        return 'livewire.forms.products.product-variations-datatable-footer';
    }
}
