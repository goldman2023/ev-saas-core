<?php

namespace App\Http\Livewire\Cart;

use CartService;
use Livewire\Component;
use Session;

class Cart extends Component
{
    public string $class;

    public string $template; // flyout-cart

    public $items;

    public $totalItemsCount;

    public $originalPrice;

    public $discountAmount;

    public $subtotalPrice;

    public $processing;

    protected $listeners = ['refreshCart', 'addToCart'];

    /*
     * Cart Livewire components depend fully on CartService singleton.
     * All Cart manipulation functions are stored in CartService
     * This class is mostly used for data display on FE
     */
    public function mount($template = '', $class = ''): void
    {
        $this->template = $template;
        $this->class = $class;
        $this->processing = false;
        $this->totalItemsCount = 0;

        $this->refreshCart();
    }

    public function startCartProcessing()
    {
        $this->processing = true;
    }

    public function refreshCart()
    {
        $this->items = CartService::getItems();
        $this->totalItemsCount = CartService::getTotalItemsCount();

        $this->originalPrice = CartService::getOriginalPrice();
        $this->discountAmount = CartService::getDiscountAmount();
        $this->subtotalPrice = CartService::getSubtotalPrice();

        // Event to refresh cart items count (all over the page, where needed)
        $this->dispatchBrowserEvent('refresh-cart-items-count', ['count' => $this->totalItemsCount]);
    }

    public function addToCart($model, $model_type, $qty, $append_qty = true)
    {
        $qty = (float) $qty;

        if ($append_qty && $qty <= 0) {
            // Reset qty data of the btn

            // If QTY is 0, remove item from the Cart!
            $this->processing = false;

            return;
        }

        $this->processing = true;

        // If passed $model is actually $model_id => Find the desired model
        if (is_numeric($model)) {
            $model_type = base64_decode($model_type);
            $model = app($model_type)::find($model);
        }

        // activity('ecommerce_log')
        //     ->performedOn($model)
        //     ->causedBy(auth()->user())
        //     ->withProperties(['action' => 'add_to_cart'])
        //     ->log('add_to_cart');

        // Add $model and $qty to cart (do not append qty if $model is already in cart) because:
        // addToCart function in Cart.php is called on quantity change event inside cart, which means that given $qty is always the desired qty!
        // This is not the case for Add to cart button because qty counter is reset once addToButton is clicked!
        // IMPORTANT: $qty is sent by reference!!!
        
        $new_data = CartService::addToCart($model, $model_type, $qty, $append_qty);
        
        // Refresh Cart Livewire components
        $this->refreshCart();

        $this->processing = false;

        // Init cart item warnings
        $this->dispatchBrowserEvent('cart-item-warnings', ['id' => $model->id, 'model_type' => base64_encode($model_type), 'warnings' => $new_data['warnings']]);      

        // Dispatch cart_processing_ending Event
        $this->dispatchBrowserEvent('cart-processing-end', ['id' => $model->id, 'model_type' => base64_encode($model_type), 'qty' => $new_data['qty']]);

        // Dispatch total cart items count update
        $this->dispatchBrowserEvent('cart-total-items-count-update', ['count' => \CartService::getTotalItemsCount()]);
    }

    public function removeFromCart($model, $model_type)
    {
        $this->processing = true;

        $data = CartService::removeFromCart($model, base64_decode($model_type));

        // Refresh Cart Livewire components
        $this->refreshCart();

        $this->processing = false;

        // Dispatch total cart items count update
        $this->dispatchBrowserEvent('cart-total-items-count-update', ['count' => \CartService::getTotalItemsCount()]);
    }

    public function render()
    {
        if (session('style_framework') === 'tailwind') {
            return view('livewire.tailwind.cart.'.$this->template);
        }

        return view('livewire.bootstrap.cart.'.$this->template);
    }
}
