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

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount(Product $product)
    {
        $this->product = $product;
        $this->variations = $this->product->variations()->get();
        $this->attributes_for_variations = $product->product_attributes_for_variations();
        //dd($this->attributes_for_variations);
    }

    public function render() {
        return view('livewire.tenant.product.product-variations-selector');
    }
}
