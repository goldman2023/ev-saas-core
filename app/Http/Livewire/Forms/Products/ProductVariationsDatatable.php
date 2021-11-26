<?php

namespace App\Http\Livewire\Forms\Products;

use App\Models\Product;
use App\Models\ProductStock;
use App\Models\ProductVariation;
use Arr;
use DB;
use EVS;
use Illuminate\Validation\Rule;
use Illuminate\View\Component;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;
use Str;

class ProductVariationsDatatable extends DataTableComponent
{
    protected string $pageName = 'product_variations';
    protected string $tableName = 'product_variations';

    public $dataType;
    public string $primaryKey;
    public $product;
    public $attributes;
    public $variations;
    public $all_combinations;
    public $rows;
    public $buttons;
    public $wireTarget;
    public $wireLoadingClass;
    public $class;
    protected $listeners = [
        'refreshDatatable' => '$refresh',
        'saveVariations' => 'setVariationsData',
    ];

    public $bulkActionSetPricesID;
    public $bulkActionSetGenericSKUID;

    protected $messages = [
        'rows.*.price.required' => 'Price is required',
        'rows.*.price.numeric' => 'Price must be numeric',
        'rows.*.price.min' => 'Minimum value is :min',

        'rows.*.temp_stock.sku.required' => 'SKU is required',
        'rows.*.temp_stock.sku.unique' => 'SKU taken by another product',

        'rows.*.temp_stock.qty.required' => 'Quantity is required',
        'rows.*.temp_stock.qty.numeric' => 'Quantity must be numeric',
        'rows.*.temp_stock.qty.min' => 'Minimum value is :min',
    ];

    protected function rules() {
        $rules = [];

        foreach($this->rows as $key => $row) {
            $data = (array) $row;
            $data['temp_stock'] = (array) $data['temp_stock'];

            if(isset($data['name']) && !empty($data['variant'] ?? null)) {
                $stock_id = $data['temp_stock']['id'] ?? null;

                $rules['rows.'.$key.'.price'] = 'required|numeric|min:1';
                $rules['rows.'.$key.'.temp_stock.sku'] = ['required', Rule::unique('product_stocks', 'sku')->ignore($stock_id)];
                $rules['rows.'.$key.'.temp_stock.qty'] = 'required|numeric|min:1';
            }
        }

        return $rules;
    }


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount(&$product, $buttons = [], $wireTarget = null, $wireLoadingClass = 'opacity-3', $class = '')
    {
        parent::mount();

        $this->dataType = 'product_variations';
        $this->primaryKey = 'name';
        $this->bulkActionSetPricesID = 'ev-product-variations__set-prices';
        $this->bulkActionSetGenericSKUID = 'ev-product-variations__set-generic-sku';

        $this->product = $product;
        $this->attributes = collect($this->product->getMappedAttributes())->filter(fn($att, $key) => ((object) $att)->for_variations === true); // these attributes are only attributes used for_variations*/
        $this->variations = collect($this->product->variations()->get()->map(fn($item) => $item->convertUploadModelsToIDs())->keyBy(fn($item) => ProductVariation::composeVariantKey($item['name']))->toArray());

        $this->all_combinations = collect([]);
        $this->rows = collect([]);
        $this->buttons = $buttons;
        $this->wireTarget = $wireTarget;
        $this->wireLoadingClass = $wireLoadingClass;
        $this->class = $class;

        // Create or Fetch all combinations.
        $this->createAllCombinations();

        // TODO: Fix the logic to use all only on bulk action and ADD single variation addition
        //$this->refreshRows();
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
        'generateAllVariations' => 'Generate all',
        'triggerSetAllPricesModal' => 'Set price for all',
        'setGenericSKUs' => 'Set generic SKUs'
    ];

    public function dehydrate()
    {
        parent::dehydrate();
        $this->dispatchBrowserEvent('initProductForm');
    }

    public function dehydrateRows()
    {
        $this->rows = castCollectionItemsTo($this->rows, 'object', ['temp_stock' => 'object']);
    }
    public function hydrateRows() {
        $this->rows = castCollectionItemsTo($this->rows, 'object', ['temp_stock' => 'object']);
    }

    // TODO: Don't forget to create a function that will merge $this->variations
    /*
     * Current functionality:
     * For now, the moment anything regarding the attributes used for variations changes (switch att itself or add/remove it's value),
     * event is emitted to ProductVariationsDatatable to generate new set of all_combinations in the background.
     * Once you go to Variations step, generateAllVariations() is called which intersect previous variations with newly created set of
     * all_combinations and and then merges values from previous variations to intersected variations and sorts them by key.

     * This means that even if we change anything regarding the attribute values,
     * variants which were previously defined and are not touched by removing variant att value, stay in the table!
     */
    public function generateAllVariations() {
        $this->variations = $this->variations->intersectByKeys($this->all_combinations);
        $this->variations = $this->all_combinations->merge($this->variations)->map(function($item) {
            $item['remove_flag'] = false;
            return $item;
        })->sortKeys();

        // TODO: Because of $this->>rows structure we are getting the checksum error...Possible solutions:
        // TODO: Try to convert rows to arrays always and use array notation in FE blade templates
        $this->rows = castCollectionItemsTo($this->variations, 'object', ['temp_stock' => 'object']);
    }

    public function refreshRows($generate_all = true) {
        $this->rows = castCollectionItemsTo($this->variations, 'object', ['temp_stock' => 'object'])->filter(function ($row, $key) {
            return $row->remove_flag === false;
        })->sortKeys();
    }

    public function createAllCombinations()
    {
        $matrix = EVS::generateAllVariations($this->attributes);
        $this->all_combinations = collect([]);

        // Get all possible combinations
        if(!empty($matrix)) {
            foreach($matrix as $index => $combo) {
                if(empty($combo)) {
                    continue;
                }

                $variation = new ProductVariation();
                $variation->id = null;
                $variation->product_id = $this->product->id ?? null;

                $variant_data = [];

                foreach($combo as $value) {
                    $variant_data[$value['attribute_id']] = [
                        'attribute_value_id' => $value['id'],
                        'attribute_id' => $value['attribute_id'],
                    ];
                }
                $variation->variant = $variant_data;
                $variation->price = $this->product->unit_price ?? 0;
                $variation->discount = 0;
                $variation->discount_type = 'percent';
                $variation->thumbnail = null;
                $variation->temp_stock = new ProductStock();
                $variation->temp_stock->qty = 0;
                $variation->temp_stock->sku = '';
                $this->all_combinations->push($variation->toArray()); // Turn the Model to Array!
            }
        }

        $this->all_combinations = $this->all_combinations->keyBy(function($item) {
            return ProductVariation::composeVariantKey($item['name']);
        })->sortKeys();

        // If $this->variations are empty (product doesn't have variations for now), make $this->variations to have $this->all_combinations
        if($this->variations->isEmpty()) {
            $this->variations = $this->all_combinations;
        } else {
            $this->generateAllVariations();
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
            // Remove flagged Variations
            foreach($this->variations as $key => $variation) {
                if($variation['remove_flag']) {
                    $variation_model = ProductVariation::find($variation['id']);
                    if(!empty($variation_model)) {
                        try {
                            $variation_model->forceDelete();
                            unset($this->variations[$key]);
                        } catch(\Exception $e) { }
                    }
                }
            }

            // Validate rows
            // Make each row an array instead of object, because validate method cannot use dot notation on array with objects!
            $this->rows = castCollectionItemsTo($this->rows/*->filter(function($value, $key) {
                $value = (array) $value; return (isset($value['name']) && !empty($value['variant'] ?? null));
            })*/, 'array', ['temp_stock' => 'array']);

            try {
                $this->validate();
                $this->rows = castCollectionItemsTo($this->rows, 'object', ['temp_stock' => 'object']);

                // Set Variations
                $this->variations = collect([]);

                DB::beginTransaction();

                try {
                    foreach ($this->rows as $index => $variation) {
                        if(empty($variation->id)) {
                            // New variation - Insert
                            $temp_stock = $variation->temp_stock;
                            unset($variation->temp_stock);

                            $variation_model = new ProductVariation();
                            $variation_model->fill((array) $variation);
                            $variation_model->save();

                            // Sync Uploads and update Stock
                            $variation_model->syncUploads(); // insert variation thumbnail
                            $this->setProductVariationStocks(false, $variation_model, $temp_stock);
                            $this->variations->push($variation_model->toArray());
                        } else {
                            // Old variation - Update or Delete
                            $variation_model = ProductVariation::find($variation->id);
                            $variation_model->price = !empty($variation->price) ? $variation->price : $variation_model->price;
                            $variation_model->save();

                            // Sync Uploads and update Stock
                            $variation_model->syncUploads(); // insert variation thumbnail
                            $this->setProductVariationStocks(false, $variation_model, $variation->temp_stock);
                            $this->variations->push($variation_model->toArray());
                        }
                    }

                    DB::commit();
                } catch(\Exception $e) {
                    DB::rollBack();
                    dd($e);
                }


                $this->variations = $this->variations->keyBy(function($item) {
                    return ProductVariation::composeVariantKey($item['name']);
                });
                $this->refreshRows();

                // Update Attributes (used for variations) selected values in DB, by emitting
                //$this->emitUp('variationsUpdated');

                $this->dispatchBrowserEvent('toastIt', ['id' => '#product-variations-toast', 'content' => translate('Variations successfully updated!')]);
            } catch(\Illuminate\Validation\ValidationException $e) {
                // Once the validation exception is caught,
                // 1) set current error bag to retrieved validator message bag
                $this->setErrorBag($e->validator->getMessageBag());
            }

            // 2) Revert rows to collection of objects!
            $this->rows = castCollectionItemsTo($this->rows, 'object', ['temp_stock' => 'object']);
        }
    }

    protected function setProductVariationStocks($iterate = false, $variation_model = [], $stock = []) {
        if(!$iterate && !empty($variation_model) && !empty($stock)) {
            $product_stock = ProductStock::firstOrNew(['subject_id' => $variation_model->id, 'subject_type' => ProductVariation::class]);
            $product_stock->qty = (float) ($stock->qty ?? 0);
            $product_stock->sku = $stock->sku;
            $product_stock->save();
        } else if($iterate) {
            if($this->rows->isNotEmpty()) {
                foreach($this->rows as $index => $var) {
                    $product_stock = ProductStock::firstOrNew(['subject_id' => $var->id, 'subject_type' => ProductVariation::class]);
                    $product_stock->qty = (float) $var->temp_stock->qty;
                    $product_stock->sku = $var->temp_stock->sku;
                    $product_stock->save();
                }
            }
        }
    }

    public function setRemoveFlag($row_name) {
        if(!empty($this->variations->get($row_name))) {
            $this->variations = $this->variations->map(function($variation) use($row_name) {
                if($row_name === $variation['name']) {
                    $variation['remove_flag'] = true;
                }
                return $variation;
            });
            $this->refreshRows();
        }
    }

    public function setAttributeValueRemoveFlag($matrix = []): void
    {
        // Loop through variations and set remove flag for those which are not in matrix
        if($this->variations->isNotEmpty() && !empty($matrix)) {
            $data = $this->variations->toArray();

            foreach($data as $key => $variation) {
                $passed = [];

                // If number of attributes that define current variations are lesser than in provided $matrix,
                // it means that new attribute is added/removed from defining variations and we should break this function without changing anything!
                // Remove flags will be sorted out correctly once the $this->variations/rows are refreshed in the next action!
                if(count($variation['variant']) !== count($matrix)) {
                    return;
                }

                foreach($matrix as $id => $val) {
                    $passed[$id] = false;
                }

                foreach($matrix as $other_att_id => $other_att_vals) {
                    // Check if other attributes values of the current variation are actually selected!
                    // This is very important because we MUST mark variations, whose attribute values are not selected, as removeFlag = true!
                    $other_att_vals = array_map(fn($val) => (int) $val, $other_att_vals); // "other attributes values" must be array of ints

                    if(in_array((int) $variation['variant'][$other_att_id]['attribute_value_id'], $other_att_vals)) {
                        $passed[$other_att_id] = true;
                    }
                }

                if(array_sum(array_values($passed)) !== count($matrix)) {
                    $data[$key]['remove_flag'] = true;
                } else {
                    $data[$key]['remove_flag'] = false;
                }
            }

            $this->variations = collect($data)->sortKeys();
            $this->refreshRows();
        }
    }

    public function triggerSetAllPricesModal() {
        $this->dispatchBrowserEvent('triggerModal', ['id' => '#'.$this->bulkActionSetPricesID]);
    }

    public function setAllVariationsPrice($price) {
        if($this->variations->isNotEmpty()) {
            $this->variations = $this->variations->map(function($variation) use ($price) {
                $variation['price'] = $price;
                return $variation;
            });
        }

        $this->refreshRows();
    }

    public function setGenericSKUs() {
        if($this->variations->isNotEmpty()) {
            $this->variations = $this->variations->map(function($variation) {
                $variation['temp_stock']['sku'] = $this->product->slug.'-'.Str::slug($variation['name']).'-001';
                return $variation;
            })->sortKeys();
        }

        $this->refreshRows();
    }

    public function modalsView(): string
    {
        return 'livewire.forms.products.product-variations-datatable-footer';
    }
}
