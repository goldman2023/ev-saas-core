<?php

namespace App\Http\Livewire\Dashboard\Forms\Products;

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

            'variations.*.sku.required' => 'SKU is required',
            'variations.*.sku.unique' => 'SKU taken by another product',

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
            'variations.*.sku' => ['required', new UniqueSKU($this->variations->mapWithKeys(function($item, $key) { return ['variations.'.$key.'.sku' => $item]; }))],
            'variations.*.current_stock' => 'required|numeric|min:0',
            'variations.*.low_stock_qty' => 'numeric|min:0',
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
        return view('livewire.dashboard.forms.products.product-variations-table');
    }


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount(&$product, $class = '')
    {
        parent::mount();

        $this->product = $product;
        $this->attributes = $this->product->variant_attributes(); // these attributes are only attributes used for_variations*/

        $this->variations = $this->product->getMappedVariations();
        
        $this->class = $class;

        // Create or Fetch all combinations.
        $this->createAllCombinations();

    }

    public function createAllCombinations()
    {
        // In order for livewire JS to understand that all_combinations and variations are Model Collections, both of these properties
        // MUST BE of Illuminate\Database\Eloquent\Collection, NOT JUST Illuminate\Support\Collection!
        // If collection is standard (not Eloquent) then Livewire JS will treat collection models as arrays and no Model hydration will happen on next backend call!
        // Basically, it's same as calling Model->toArray() for each model inside collection. So, for Models use Eloquent/Collection!

        $this->all_combinations = $this->product->createAllVariationsCombinations();

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
    }


    /*
     * Generates all possible variations combinations
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
            $product_stock->sku = $variation_model->sku;
            $product_stock->low_stock_qty = (float) ($variation_model->low_stock_qty ?? 0);
            $product_stock->save();
        }
    }

    public function triggerSetAllPricesModal() {
        //$this->dispatchBrowserEvent('triggerModal', ['id' => '#'.$this->bulkActionSetPricesID]);
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
                $variation['stock']['sku'] = $this->product->slug.'-'.Str::slug($variation['name']).'-001';
                return $variation;
            })->sortKeys();
        }

    }
}
