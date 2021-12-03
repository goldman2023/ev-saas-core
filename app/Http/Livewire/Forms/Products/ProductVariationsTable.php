<?php

namespace App\Http\Livewire\Forms\Products;

use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\ProductVariation;
use App\Rules\UniqueSKU;
use App\Traits\Livewire\RulesSets;
use Arr;
use DB;
use EVS;
use Illuminate\Support\Collection;
use Str;

class ProductVariationsTable extends \Livewire\Component
{
    use RulesSets;

    public $product;
    public $attributes;
    public $variations;
    public $all_combinations;
    public $class;

    protected $listeners = [
        'refreshDatatable' => '$refresh',
        'saveVariations' => 'setVariationsData',
        'generateAllVariations' => 'Generate all',
        'triggerSetAllPricesModal' => 'Set price for all',
        'setGenericSKUs' => 'Set generic SKUs'
    ];

    public $bulkActionSetPricesID;
    public $bulkActionSetGenericSKUID;

    protected function messages()
    {
        return [
            'variations.*.price.required' => 'Price is required',
            'variations.*.price.numeric' => 'Price must be numeric',
            'variations.*.price.min' => 'Minimum value is :min',

            'variations.*.temp_sku.required' => 'SKU is required',
            'variations.*.temp_sku.unique' => 'SKU taken by another product',

            'variations.*.current_stock.required' => 'Quantity is required',
            'variations.*.current_stock.numeric' => 'Quantity must be numeric',
            'variations.*.current_stock.min' => 'Minimum value is :min',
        ];
    }

    protected function rules() {
        return [
            'all_combinations.*' => [],
            'product.*' => [],
            'attributes.*' => [],
            'variations.*.id' => [],
            'variations.*.thumbnail' => ['numeric'],
            'variations.*.variant' => [],
            'variations.*.product_id' => [],
            'variations.*.price' => 'required|numeric|min:1',
            'variations.*.temp_sku' => ['required', new UniqueSKU($this->variations->mapWithKeys(function($item, $key) { return ['variations.'.$key.'.temp_sku' => $item]; }))],
            'variations.*.current_stock' => 'required|numeric|min:0',
            'variations.*.low_stock_qty' => 'numeric|min:0',
            'variations.*.remove_flag' => 'bool',
            'variations.*.discount' => [],
            'variations.*.discount_type' => [],
            'variations.*.created_at' => [],
            'variations.*.updated_at' => []
        ];
    }

    public function dehydrate()
    {
        $this->all_combinations = $this->all_combinations->setConnection();
        $this->variations = $this->variations->setConnection();
        $this->dispatchBrowserEvent('EVProductVariationsTableFormInit');
    }

    public function hydrate()
    {
        // After models are hydrated and added to variations collection, set their `connection` property!
        $this->all_combinations = $this->all_combinations->setConnection();
        $this->variations = $this->variations->setConnection();
    }

    public function render()
    {
        return view('livewire.forms.products.product-variations-table');
    }


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount(&$product, $class = '')
    {
        parent::mount();

//        $this->bulkActionSetPricesID = 'ev-product-variations__set-prices';
//        $this->bulkActionSetGenericSKUID = 'ev-product-variations__set-generic-sku';

        $this->product = $product;
        $this->attributes = $this->product->variant_attributes(); // these attributes are only attributes used for_variations*/

        $this->variations = $this->product->getMappedVariations();

        $this->class = $class;

        // Create or Fetch all combinations.
        $this->createAllCombinations();


//        $this->buttons = $buttons;
//        $this->wireTarget = $wireTarget;
//        $this->wireLoadingClass = $wireLoadingClass;
    }

    public function createAllCombinations()
    {
        // In order for livewire JS to understand that all_combinations and variations are Model Collections, both of these properties
        // MUST BE of Illuminate\Database\Eloquent\Collection, NOT JUST Illuminate\Support\Collection!
        // If collection is standard (not Eloquent) then Livewire JS will treat collection models as arrays and no Model hydration will happen on next backend calls!
        // Basically, it's same as calling Model->toArray() for each model inside collection.
        $matrix = EVS::generateAttributeValuesMatrix($this->attributes);
        $this->all_combinations = new \Illuminate\Database\Eloquent\Collection();

        // Get all possible combinations
        if($matrix instanceof Collection && $matrix->isNotEmpty()) {
            foreach($matrix as $index => $combo) {
                if(empty($combo)) {
                    continue;
                }


                /*
                 * Matrix can be consisted of array of arrays OR array of AttributeValues.
                 * 1) Array of arrays - when there is more than one attribute used for variations
                 * 2) Array of AttributeValues - when there is one attribute used for variations
                 *
                 * IMPORTANT: DO NOT STORE $variant_data items under $keys which are not default, like: $variant_data[$value->attribute_id]
                 * REASON: When php data is printed in livewire component js, array keys will be reset, which produces different $variant data and throws checksum error
                 * `17 => ['attribute_id' => 17, 'attribute_value_id' => 45]` becomes `0 => ['attribute_id' => 17, 'attribute_value_id' => 45]`
                 * This is clearly different when JS data is sent to PHP and checksum error is thrown!!!
                 * Use classic array keys (0,1,2...) OR string keys instead of integer IDs as keys because JS resets integer keys to go from 0!!!!! VERY IMPORTANT!!!!
                 */
                $variant_data = [];

                if($combo instanceof AttributeValue) {
                    $variant_data[] = [
                        'attribute_value_id' => $combo->id,
                        'attribute_id' => $combo->attribute_id,
                    ];
                } else {
                    foreach($combo as $value) {
                        $variant_data[] = [
                            'attribute_value_id' => $value->id,
                            'attribute_id' => $value->attribute_id,
                        ];
                    }
                }

                $variation = new ProductVariation();
                $variation->id = null;
                $variation->remove_flag = false;
                $variation->product_id = $this->product->id ?? null;
                $variation->variant = $variant_data;
                $variation->price = $this->product->unit_price ?? 0;
                $variation->discount = 0;
                $variation->discount_type = 'percent';
                $variation->thumbnail = null;
                $variation->current_stock = 0;
                $variation->temp_sku = '';

                $this->all_combinations->push($variation);
            }
        }

        // Change variations keys and sort by them (setConnection custom macro is important here because Livewire rises "Queueing collections with multiple model connections is not supported"
        // error if any item in eloquent collection doesn't have the same 'connection' property as other items.
        // When we create new Model manually, connection property is null, which later rises this error when variations and all_combinations collection are being entangled
        $this->all_combinations = $this->all_combinations->setConnection()->keyBy(fn($item) => ProductVariation::composeVariantKey($item['name']))->sortKeys();

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


    // TODO: Don't forget to create a function that will merge $this->variations
    /*
     * Current functionality:
     * For now, the moment anything regarding the attributes used for variations changes (switch att itself or add/remove it's value),
     * event is emitted to ProductVariationsTable to generate new set of all_combinations in the background.
     * Once you go to Variations step, generateAllVariations() is called which intersect previous variations with newly created set of
     * all_combinations and then merges values from previous variations to intersected variations and sorts them by key.

     * This means that even if we change anything regarding the attribute values,
     * variants which were previously defined and are not touched by removing variant att value, stay in the table!
     */
    public function generateAllVariations() {

        $this->variations = $this->variations->intersectByKeys($this->all_combinations->keyBy(fn($item) => ProductVariation::composeVariantKey($item['name'])))
            ->keyBy(fn($item) => ProductVariation::composeVariantKey($item['name']))
            ->union($this->all_combinations)
            ->keyBy(fn($item) => ProductVariation::composeVariantKey($item['name']))->sortKeys();
    }

    public function saveVariation($index) {
        $variation = $this->variations->get($index);

        $this->dispatchBrowserEvent('display-current-variation', ['current' => $index]);

        $this->validate($this->getIndexedRuleSet('variations', $index));

        DB::beginTransaction();

        try {
            // TODO: Check why created_at and updated_at are not filled on ->save()...
            $variation->save();

            // Sync Uploads and update Stock
            $variation->syncUploads(); // insert variation thumbnail
            $this->setProductVariationStock($variation);

            $this->variations->put($index, $variation);

            DB::commit();
        } catch(\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }


    public function removeVariation($variation_id) {
        $variation = $this->variations->firstWhere('id', $variation_id);
        $variation_index = $this->variations->search(function ($item, $key) use($variation_id) {
            return $item->id === (int) $variation_id;
        });
        $variation_in_all_combinations_index = $this->all_combinations->search(function ($item, $key) use($variation) {
            return $item->name === $variation->name;
        });


        if(!empty($variation)) {
            $variation->forceDelete();

            $this->variations->put($variation_index, $this->all_combinations[$variation_in_all_combinations_index]);

            $this->dispatchBrowserEvent('removal-modal-hide');
        }
    }

    protected function setProductVariationStock($variation_model = null) {
        if($variation_model->id ?? null) {
            $product_stock = ProductStock::firstOrNew(['subject_id' => $variation_model->id, 'subject_type' => ProductVariation::class]);
            $product_stock->qty = (float) ($variation_model->current_stock ?? 0);
            $product_stock->sku = $variation_model->temp_sku;
            $product_stock->low_stock_qty = (float) ($variation_model->low_stock_qty ?? 0);
            $product_stock->save();
        }
    }

    public function setRemoveFlag($row_name) {
        if(!empty($this->variations->get($row_name))) {
            $this->variations = $this->variations->map(function($variation) use($row_name) {
                if($row_name === $variation->name) {
                    $variation->remove_flag = true;
                }
                return $variation;
            });
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
            //$this->refreshRows();
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

    }

    public function setGenericSKUs() {
        if($this->variations->isNotEmpty()) {
            $this->variations = $this->variations->map(function($variation) {
                $variation['temp_stock']['sku'] = $this->product->slug.'-'.Str::slug($variation['name']).'-001';
                return $variation;
            })->sortKeys();
        }

    }


}
