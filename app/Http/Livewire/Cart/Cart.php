<?php

namespace App\Http\Livewire\Cart;

use Session;
use CartService;
use Livewire\Component;
use App\Models\ProductAddon;

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

    protected $listeners = [
        'refreshCart' => 'refreshCart', 
        'addToCart' => 'addToCart', 
        'refreshCartComponent' => '$refresh'
    ];

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

    public function rules() {
        return [
            'items.*.purchase_quantity' => ''
        ];
    }

    public function startCartProcessing()
    {
        $this->processing = true;
    }

    public function updatedItems($values) {

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

    public function addToCart($model, $model_type, $qty, $append_qty = true, $addons = [], $append_addons_qty = true)
    {
        $qty = (float) $qty;

        if ($append_qty && $qty <= 0) {
            // Reset qty data of the btn

            // If QTY is 0, remove item from the Cart!
            $this->processing = false;

            return;
        }

        $this->processing = true;

        // activity('ecommerce_log')
        //     ->performedOn($model)
        //     ->causedBy(auth()->user())
        //     ->withProperties(['action' => 'add_to_cart'])
        //     ->log('add_to_cart');

        // Add $model and $qty to cart (do not append qty if $model is already in cart) because:
        // addToCart function in Cart.php is called on quantity change event inside cart, which means that given $qty is always the desired qty!
        // This is not the case for Add to cart button because qty counter is reset once addToButton is clicked!
        // IMPORTANT: $qty is sent by reference!!!
        
        // Remove item from cart if qty is 0 and $append_qty is not set
        if($qty <= 0 && !$append_qty) {
            return $this->removeFromCart($model, $model_type);
        }

        $new_data = $this->baseEncodeContentTypes(CartService::addToCart($model, $model_type, $qty, $append_qty, $addons, $append_addons_qty));


        // Refresh Cart Livewire components
        $this->refreshCart();

        $this->processing = false;

        // // Init cart item warnings
        $this->dispatchBrowserEvent('cart-item-warnings', ['id' => $new_data['id'], 'model_type' => $new_data['model_type'], 'warnings' => $new_data['warnings']]);      

        // // Dispatch cart_processing_ending Event
        $this->dispatchBrowserEvent('cart-processing-end', ['id' => $new_data['id'], 'model_type' => $new_data['model_type'], 'qty' => $new_data['qty'], 'addons' => $new_data['addons']]);

        // // Dispatch total cart items count update
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
        return view('livewire.tailwind.cart.'.$this->template);

    }

    protected function baseEncodeContentTypes($data) {
        $data['model_type'] = base64_encode($data['model_type']);

        if(!empty($data['addons'])) {
            foreach($data['addons'] as $index => $addon_data) {
                $data['addons'][$index]['model_type'] = base64_encode($addon_data['model_type']);
            }
        }
        
        return $data;
    }
}
