<?php

namespace App\Http\Livewire\Tenant\Product;

use App\Models\AttributeValue;
use App\Models\Product;
use Livewire\Component;
use App\Facades\CartService;
use Session;

class ProductVariationsSelector extends Component {

    public Product $product;
    public $attributes_for_variations;
    public $variations;
    public $current;
    public $current_variant;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount(Product $product)
    {
        $this->product = $product;
        $this->variations = $this->product->variations()->with(['flash_deals', 'product'])->get();
        $this->attributes_for_variations = $product->variant_attributes();

        $variant = [];
        foreach($this->attributes_for_variations as $attribute)  {
            // TODO: Think about a better way to store variant combo in DB!
            $variant[$attribute->id] = [
                'attribute_value_id' => $attribute->attribute_values->first()->id,
                'attribute_id' => $attribute->id
            ];
        }

        $this->current_variant = $variant;
        $this->current = $this->variations->where('variant', $this->current_variant)->first();

        $this->emitTo('tenant.product.price', 'changeVariation', $this->current);
        //dd($this->variant_attributes);
    }

    public function hydrateAttributesForVariations($value) {
        // IMPORTANT!!!
        // PROBLEM: On hydration (before action is fired), $this->variant_attributes contains wrong values even though we mounted it correctly and never changed it in the meantime!
        // FIX: On every hydrate, get the proper data from the Cache (check variant_attributes() function in AttributeTrait)
        // TODO: Don't forget to create AttributeValueObserver and AttributeRelationshipObserver classes to remove this cache on any change!
        $this->attributes_for_variations = $this->product->variant_attributes();
    }

    public function updatedCurrentVariant($value = null, $key = null) {
        $this->current = $this->variations->where('variant', $this->current_variant)->first();
        $this->emitTo('tenant.product.price', 'changeVariation', $this->current);
    }

    public function selectVariation(AttributeValue $attribute_value) {
        // TODO: Change $current and emit event to tenant.product.price to change it's $product var
        $this->current_variant[$attribute_value->attribute_id]['attribute_value_id'] = $attribute_value->id;
        $this->updatedCurrentVariant();
    }

    public function render() {
        return view('livewire.tenant.product.product-variations-selector');
    }
}
