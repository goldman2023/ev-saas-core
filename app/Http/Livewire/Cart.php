<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use App\Facades\CartService;
use Session;

class Cart extends Component
{
    public string $class;
    public $items;
    public $subtotal;
    public string $template;
    protected $listeners = ['refreshCarts'];

    public function mount($template = '', $class = ''): void
    {
        if(!Session::has('cart') || count(Session::get('cart')) <= 0) {
            Session::put('cart', collect([]));
        }

        $this->template = $template;
        $this->class = $class;
        $this->items = collect(Session::get('cart'));

        $this->subtotal = [
            'raw' => 0,
            'display' => format_price(convert_price(0)),
        ];
    }

    /*public function initCart($ids = []) {
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
                $this->items = collect(Product::findMany(array_values($ids))->toArray());

                // Emit to all other carts
                $this->emitTo('cart', 'refreshCarts', $this->items);
            }
        }
    }*/

    public function refreshCarts()
    {
            $this->items = collect(Session::get('cart'));

            //$this->items = collect($items);
            /*$this->subtotal['raw'] = 0;

            $this->items->each(function($item, $key) {
                $this->subtotal['raw'] += home_discounted_base_price($item['id'], false);
            });
            $this->subtotal['display'] = format_price(convert_price($this->subtotal['raw']));*/

    }

    public function addToCart($params) {
        if($this->template === 'main') {
            // id, quantity, has(color)
            request()->request->add([
                'id' => (int) $params['id'],
                'quantity' => (int) $params['quantity'],
            ]);

            if(isset($params['color']) && !empty($params['color'])) {
                request()->request->add([
                    'color' => $params['color']
                ]);
            }

            $result = null; //CartService::addToCart(request());

            if($result['status'] === 0) {
                $this->dispatchBrowserEvent('add-to-cart-errors', $result['view']);
            } else if($result['status'] === 1) {
                //$this->items = collect(Session::get('cart'));

                // Refresh other livewire carts
                // TODO: There is an issue with flyoutcart fingerprint, check the console and following git issue:
                // https://github.com/livewire/livewire/issues/1726
                // https://github.com/livewire/livewire/issues/1686
                // Problem: After adding/removing the items, refreshCarts event is not sent to Flyout cart
                $this->emitTo('cart', 'refreshCarts');

                // Notify alpine components
                $this->dispatchBrowserEvent('added-to-cart');
                $this->dispatchBrowserEvent('update-cart-items-count', count(Session::get('cart')));
            }

            // Emit to all other carts
            //$this->emitTo('cart', 'refreshCarts', $this->items);
        }


        // TODO: Create Facade for ProductController and use already existing classes for Cart manipulation here!
        /*if(is_int($id) || ctype_digit($id)) {
            // Check if item is already in cart
            // TODO: Fix this depending on Quantity logic!
            $in_cart = $this->items->filter(function ($value, $key) use ($id) {
                return $value['id'] == (int) $id;
            });

            $this->items->push(Product::find($id)->first()->toArray());

            // Emit to all other carts
            $this->emitTo('cart', 'refreshCarts', $this->items);

            // Send event to main to update the localStorage
            $this->dispatchBrowserEvent('refresh-local-cart', $this->items->pluck('id')->toJson());
        }*/

    }

    public function removeFromCart($id) {
        // TODO: Create Facade for ProductController and use already existing classes for Cart manipulation here!
        if($this->template == 'main') {
            if (is_int($id) || ctype_digit($id)) {

                foreach($this->items as $key => $item) {
                    if($item['id'] == $id) {
                        $this->items->forget($key);
                        break;
                    }
                }

                // Emit to all other carts
                $this->emitTo('cart', 'refreshCarts', $this->items);

                // Send event to main to update the localStorage
                $this->dispatchBrowserEvent('refresh-local-cart', $this->items->pluck('id')->toJson());
            }
        }
    }

    public function calculateSubtotal() {

    }

    public function render()
    {
        return view('components.tenant.cart.'.$this->template);
    }
}
