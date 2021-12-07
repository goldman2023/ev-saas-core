<?php

namespace App\Http\Livewire\Tenant\Product;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Support\Collection;
use Livewire\Component;
use App\Facades\CartService;
use Session;
use EVS;

class ProductVariationsSelector extends Component
{

    public Product $product;
    public $attributes_for_variations;
    public $variations;
    public $all_combinations;
    public $available_variants;
    public $missing_variants;
    public $current;
    public $class;

    protected function rules()
    {
        return [
            'current.*' => [],
            'all_combinations.*' => [],
            'available_variants.*' => [],
            'missing_variants.*' => [],
        ];
    }

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount(Product $product, $class = '')
    {
        $this->product = $product;
        $this->variations = $this->product->variations;
        $this->class = $class;

        $this->all_combinations = $this->product->createAllVariationsCombinations(true);
        $this->available_variants = $this->variations->pluck('variant');
        $this->missing_variants = $this->product->getMissingVariations(true);

        // Get and select first variant
        $this->current = $this->product->getFirstVariation();

        // THIS MUST NOT BE AN ELOQUENT/COLLECTION!!!!
        // Reason: If we leave attributes_for_variations as Eloquent/Collection and not turn it into the array/standard-collection,
        // we'll encounter hydration problems. Mainly, there is memo.dataMeta property in every livewire request which stores the data about
        // eloquent content, lieke types/models/eloquent-collections etc. Problem happens in Livewire\HydrationMiddleware\hydrate() where
        // all Eloquent data (and other data-types) are reconstructed, BUT USING THE memo.dataMeta parameters from request.
        // In this case where we want to hydrate Attributes, their Values and Relationships, such behavior is contra-productive because
        // livewire hydrate will use Models (Attribute, AttributeRelationships, AttributeValues) and query by them, not by Product relations.
        // This means that hydrated Attribute will have literally ALL relationships and values which can fuck up the DB, server and other things
        // TODO: Remove all eager-loadings for Attributes/Values/Relationships because of possible Unlimited queries (like the one that is performed by Livewire on hydration)
        // TODO: Keep in mind to check if removing eager-loadings affects any other part of the BE logic (ProductsBuilder and such)
        $this->attributes_for_variations = $product->variant_attributes()->toArray(); // <--- This must be an Array, NEVER...EVER...Eloquent/Collection!
    }

    public function updatedCurrentVariant($value = null, $key = null)
    {
        $this->current = $this->variations->where('variant', $this->current_variant)->first();
        $this->emitTo('tenant.product.price', 'changeVariation', $this->current);
    }

    // TODO: Disable att_values on FE for which there are no variations!!!
    public function selectVariation($attribute_id, $attribute_value_id)
    {
        // Construct new variant based on current variant and new att and att_value ids
        $current_variant = $this->current->variant;
        $selected_variant = collect($current_variant)->map(function ($item, $key) use ($attribute_id, $attribute_value_id) {
            if ((int) $item['attribute_id'] === (int) $attribute_id) {
                $item['attribute_value_id'] = (int) $attribute_value_id;
            }
            return $item;
        });

        $current_variation = $this->product->getVariationByVariant($current_variant);
        $selected_variation = $this->product->getVariationByVariant($selected_variant);

        if ($current_variation->id === $selected_variation->id) {
            $this->dispatchBrowserEvent('select-variation-end');
            return null;
        } else if ($selected_variation->id) {
            // Select new current
            $this->current = $selected_variation;

            // Emit Variation Changed Event
            $this->emitVariationChangedEvent();
        }
    }

    public function emitVariationChangedEvent()
    {
        $this->dispatchBrowserEvent('variation-changed', [
            'model_id' => $this->current->id,
            'model_type' => $this->current::class,
            'total_price' => $this->current->total_price,
            'total_price_display' => $this->current->getTotalPrice(true),
            'base_price' => $this->current->base_price,
            'base_price_display' => $this->current->getBasePrice(true),
        ]);
    }

    public function render()
    {
        return view('livewire.tenant.product.product-variations-selector');
    }
}
