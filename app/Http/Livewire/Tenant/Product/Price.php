<?php

namespace App\Http\Livewire\Tenant\Product;

use App\Models\Product;
use App\Models\ProductVariation;
use Livewire\Component;
use App\Facades\CartService;
use Session;

class Price extends Component {

    public $product;
    public $unit;
    public $last_price_class;
    public $original_price_class;

    protected $listeners = ['changeVariation'];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($product = null, $last_price_class = '', $original_price_class = '')
    {
        $this->product = $product;
        $this->last_price_class = $last_price_class;
        $this->original_price_class = $original_price_class;
        $this->unit = $product->unit;

        //dd($this->attributes_for_variations);
    }

    public function changeVariation(ProductVariation $variation) {
        $this->product = $variation;
    }

    public function render() {
        return view('livewire.tenant.product.price');
    }
}
