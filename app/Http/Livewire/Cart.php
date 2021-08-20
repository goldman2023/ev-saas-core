<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class Cart extends Component
{
    public string $class;
    public $items;
    public string $template;
    protected $listeners = ['refreshCarts'];

    public function mount($template = '', $class = ''): void
    {
        $this->template = $template;
        $this->class = $class;
        $this->items = collect([]);
    }

    public function initCart($ids = []) {
        if($this->template == 'main') {
            $ids = is_string($ids) ? json_decode($ids) : $ids;

            if(!empty($ids)) {
                // Only integers can pass!
                foreach($ids as $key => $id) {
                    if(!is_int($id) && !ctype_digit($id)) {
                        unset($ids[$key]);
                    }
                }

                // Fetch the items from the DB
                $this->items = Product::findMany(array_values($ids))->toArray();

                // Emit to all other carts
                $this->emitTo('cart', 'refreshCarts', $this->items);
            }
        }
    }

    public function refreshCarts($items)
    {
        if($this->template !== 'main') {
            $this->items = $items;
        }
    }

    public function addToCart($id) {
        // TODO: Create Facade for ProductController and use already existing classes for Cart manipulation here!
        if($this->template == 'main') {
            if(is_int($id) || ctype_digit($id)) {
                // Check if item is already in cart
                // TODO: Fix this depending on Quantity logic!
                $in_cart = array_filter($this->items, function ($value, $key) use ($id) {
                    return $value['id'] == (int) $id;
                }, ARRAY_FILTER_USE_BOTH);

                $this->items[] = Product::find($id)->first()->toArray();

                // Emit to all other carts
                $this->emitTo('cart', 'refreshCarts', $this->items);

                // Send event to main to update the localStorage
                $this->dispatchBrowserEvent('refresh-local-cart', json_encode(array_column($this->items, 'id')));
            }
        }
    }

    public function removeFromCart($id) {
        // TODO: Create Facade for ProductController and use already existing classes for Cart manipulation here!
        if($this->template == 'main') {
            if (is_int($id) || ctype_digit($id)) {

                foreach($this->items as $key => $item) {
                    if($item['id'] == $id) {
                        unset($this->items[$key]);
                    }
                }

                $this->items = array_values($this->items);

                // Emit to all other carts
                $this->emitTo('cart', 'refreshCarts', $this->items);

                // Send event to main to update the localStorage
                $this->dispatchBrowserEvent('refresh-local-cart', json_encode(array_column($this->items, 'id')));
            }
        }
    }

    public function render()
    {
        return view('components.tenant.cart.'.$this->template);
    }
}
