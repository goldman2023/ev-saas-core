<?php

namespace App\Http\Livewire\Tenant\Product;

use App\Models\Product;
use Livewire\Component;
use App\Facades\CartService;
use Session;

class ProductVariationsSelector extends Component {

    public Product $product;
    public $attributes_for_variations;
    public $variations;
    public $current;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount(Product $product)
    {
        $this->product = $product;
        $this->variations = $this->product->variations()->with('flash_deals')->get();
        $this->attributes_for_variations = $product->product_attributes_for_variations();

        $variant = [];
        foreach($this->attributes_for_variations as $attribute)  {
            // TODO: Think about a better way to store variant combo in DB!
            $variant[$attribute->id] = [
                'attribute_value_id' => $attribute->attribute_values->first()->id,
                'attribute_id' => $attribute->id
            ];
        }

        $this->current = $this->variations->where('variant', $variant)->first();

        $this->emitTo('tenant.product.price', 'changeVariation', $this->current);
        //dd($this->attributes_for_variations);
    }

    public function selectVariation() {
        // TODO: Change $current and emit event to tenant.product.price to change it's $product var
    }

    public function render() {
        return view('livewire.tenant.product.product-variations-selector');
    }
}
