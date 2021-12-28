<?php

namespace App\Http\Livewire\Cart;

use App\Models\Product;
use App\Models\ProductVariation;
use Livewire\Component;
use App\Facades\CartService;
use Session;

class AddToCartButton extends Component {

    public $model;
    public $class;
    public $btnType;
    public $icon;
    public $label;
    public $qty;
    public $processing;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($model = null, $btnType = 'primary', $class = '', $icon = '', $label = 'Add to cart')
    {
        $this->model = $model;
        $this->label = $label;
        $this->class = $class;
        $this->btnType = $btnType;
        $this->icon = $icon;
        $this->qty = 0;
        $this->processing = false;
    }

//    public function addToCart() {
//        $this->qty = (float) $this->qty;
//
//        if($this->qty <= 0) {
//            // Reset qty data of the btn
//            $this->qty = 0;
//            $this->processing = false;
//            return;
//        }
//
//        // Add $model and $qty to cart
//        CartService::addToCart($this->model, $this->qty);
//
//        // Refresh Cart Livewire components
//        $this->emit('refreshCart');
//
//        // Open Cart with new data
//        $this->dispatchBrowserEvent('display-cart');
//
//        // Reset qty data of the quantity input (for the model)
//        $this->dispatchBrowserEvent('reset-qty', ['id' => $this->model->id]);
//
//        // Reset qty data of the btn
//        $this->qty = 0;
//        $this->processing = false;
//    }

    public function render() {
        return view('livewire.cart.add-to-cart-button');
    }
}
