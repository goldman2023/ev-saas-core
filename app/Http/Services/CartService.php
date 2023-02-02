<?php

namespace App\Http\Services;

use App\Models\Shop;
use Cache;
use EVS;
use FX;
use Illuminate\Database\Eloquent\Collection;
use Session;

class CartService
{
    protected $items;

    protected $count;

    protected $originalPrice;

    protected $subtotalPrice;

    protected $discountAmount;

    protected $taxAmount;

    protected $totalPrice;

    protected $globalTaxPercentage; // TODO: Make tax system in taxes table which depend on country! For now we are just adding global tax to everyone...

    public function __construct($app)
    {
        if (! Session::has('cart') || count(Session::get('cart')) <= 0) {
            Session::put('cart', collect());
        }

        // Taxes
        try {
            $this->globalTaxPercentage = (float) get_tenant_setting('company_tax_rate');
            if(empty($this->globalTaxPercentage)) {
                $this->globalTaxPercentage = 0;
            }
        } catch(\Exception $e)  {
            $this->globalTaxPercentage = 0;
        }
        

        // Refresh cart totals
        $this->refresh();
    }

    public function getGlobalTaxPercentage()
    {
        return $this->globalTaxPercentage;
    }

    public function getItems()
    {
        return $this->items->setConnection();
    }

    public function getOriginalPrice()
    {
        return $this->originalPrice;
    }

    public function getDiscountAmount()
    {
        return $this->discountAmount;
    }

    public function getTaxAmount()
    {
        return $this->taxAmount;
    }

    public function getSubtotalPrice()
    {
        return $this->subtotalPrice;
    }

    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    public function getTotalItemsCount()
    {
        return $this->count;
    }

    public function getShop($as_id = false)
    {
        // TODO: This function will have to support purchasing items from different shops in the future
        // TODO: Logic should be to generate multiple orders for each shop containing items bought from that shop (maybe)
        // For now just retrieve the shop (or shop_id) of the first item
        $shop_id = $this->items->pluck('shop_id')->filter(fn ($item) => ! empty($item))->first();

        if (empty($shop_id)) {
            // This most probably means that there are no items in cart OR items in cart do not have shop_id property (like ProductVariations)
            $main = $this->items->first()->main ?? null;

            return $as_id ? $main->shop_id : $main->shop;
        }

        return $as_id ? $shop_id : Shop::find($shop_id);
    }

    public function addToCart($model, $model_type, $qty, $append_qty = true)
    {
        $warnings = [];

        if (is_numeric($model)) {
            $model = app($model_type)::find($model);
        }

        $cart_items = collect(Session::get('cart'));

        // Add to cart only if Model is purchasable
        if (isset($model->is_purchasable) && $model->is_purchasable) {
            $desired_item_in_cart = $cart_items->first(fn ($item, $key) => $item['id'] === $model->id && $item['content_type'] === $model::class);

            if (! empty($desired_item_in_cart) && $append_qty) {
                // Desired item is in cart already, check if there is enough of that item in stock
                $qty += $desired_item_in_cart['qty'];
            }

            // Do only if track_invetory for the product is ENABLED
            if ($model->track_inventory && $model->current_stock < $qty && ! $model->allow_out_of_stock_purchases) {
                // Desired qty is bigger than stock qty, add only available amount to cart

                // Add a warning that there was not enough items in stock to fulfill desired QTY
                $model_name = ($model?->is_variation ?? false) ? $model->main->name.' ('.$model->getVariantName(key_by: 'name')->map(fn ($item, $key) => $key.': '.$item)->join(', ').')' : $model->name;
                $warnings[] = '<strong>'.$model_name.':</strong> '.translate('There are not enough items in stock to fulfill desired quantity. All available items in stock are added to the cart.');

                $qty = $model->current_stock;
            }

            // Construct $model data for cart session storage
            $data = [
                'content_type' => $model::class,
                'id' => $model->id,
                'qty' => (float) $qty,
            ];

            if (! empty($desired_item_in_cart)) {
                // Update $qty of desired $model in cart_items IF ITEM IS IN CART SESSION
                $index = $cart_items->search(fn ($item, $key) => $item['id'] === $model->id && $item['content_type'] === $model::class);
                $cart_items->put($index, $data);
            } else {
                // Push desired $model to cart items IF ITEM IS NOT IN CART SESSION
                $cart_items->push($data);
            }

            // Save cart items in `cart` session
            Session::put('cart', $cart_items->filter(fn ($v, $k) => $v['qty'] > 0)->values());

            // Refresh $items and $subtotal
            $this->refresh();
        }

        // return data
        return [
            'id' => $model->id,
            'model_type' => $model_type,
            'qty' => $qty,
            'append_qty' => $append_qty,
            'warnings' => $warnings,
        ];
    }

    public function removeFromCart($model, $model_type)
    {
        if (is_numeric($model)) {
            $model = app($model_type)::find($model);
        }

        $cart_items = collect(Session::get('cart'));
        $index = $cart_items->search(fn ($item, $key) => $item['id'] === $model->id && $item['content_type'] === $model::class);

        $cart_items->pull($index);

        Session::put('cart', $cart_items->filter(fn ($v, $k) => $v['qty'] > 0)->values());

        // Refresh $items and $subtotal
        $this->refresh();
    }

    protected function refresh()
    {
        $cart_items = collect(Session::get('cart'));
        $count = 0; // start counting from 0!
        $this->resetStats(); // start counting totals from 0!

        if ($cart_items->isNotEmpty()) {
            $mapped = collect();

            foreach ($cart_items as $item) {
                if ($mapped->has($item['content_type'])) {
                    $collection = $mapped->get($item['content_type']);
                    $collection->push($item);
                    $mapped->put($item['content_type'], $collection);
                } else {
                    $mapped->put($item['content_type'], collect([$item]));
                }
            }

            $mapped = $mapped->map(function ($data, $content_type) use (&$count) {
                $ids = $data->pluck('id');

                // TODO: Eager load translations and parent (if these relations are available) - think of a way to do it
                $items = app($content_type)->findMany($ids);

                return $items->map(function ($model, $index) use ($data, &$count) {
                    $qty = $data->firstWhere('id', $model->id)['qty'] ?? 1;
                    $model->purchase_quantity = $qty;
                    $count += $qty; // append to total count of all items added to cart

                    return $model;
                });
            })->flatten();

            // sort by initial order and calculate subtotal and total
            $order_items_idx = $cart_items->pluck('id');
            $this->items = new \App\Support\Eloquent\Collection(); // THIS IS ULTIMATELY IMPORTANT!!! Otherwise, only one model type can be in standard Eloquent/Collection

            foreach ($order_items_idx as $id) {
                $found_item = $mapped->firstWhere('id', $id);

                if(empty($found_item)) 
                    continue;

                $this->items->push($found_item);
                
                $this->originalPrice['raw'] += $found_item->purchase_quantity * $found_item->base_price;
                $this->discountAmount['raw'] += $found_item->purchase_quantity * ($found_item->base_price - $found_item->total_price);

                $this->subtotalPrice['raw'] = $this->originalPrice['raw'] - $this->discountAmount['raw']; // Subtotal: Original - Line discounts
                
                $this->taxAmount['raw'] = $this->subtotalPrice['raw'] * $this->globalTaxPercentage / 100; // Tax: globalTaxPercentage of Subtotal

                $this->totalPrice['raw'] = $this->subtotalPrice['raw'] + $this->taxAmount['raw']; // Total: Subtotal + Tax
            }

            $this->originalPrice['display'] = FX::formatPrice($this->originalPrice['raw']);
            $this->discountAmount['display'] = FX::formatPrice($this->discountAmount['raw']);
            $this->subtotalPrice['display'] = FX::formatPrice($this->subtotalPrice['raw']);
            $this->taxAmount['display'] = FX::formatPrice($this->taxAmount['raw']);
            $this->totalPrice['display'] = FX::formatPrice($this->totalPrice['raw']);

            $this->count = $count;
        } else {
            $this->resetCart();
        }
    }

    public function fullCartReset()
    {
        Session::put('cart', collect());

        $this->resetCart();
    }

    protected function resetCart()
    {
        $this->items = new \App\Support\Eloquent\Collection(); // THIS IS ULTIMATELY IMPORTANT!!! Otherwise, only one model type can be in standard Eloquent/Collection
        $this->count = 0;

        $this->resetStats();
    }

    protected function resetStats()
    {
        $this->originalPrice = $this->discountAmount = $this->taxAmount = $this->subtotalPrice = $this->totalPrice = [
            'raw' => 0,
            'display' => FX::formatPrice(0),
        ];
    }
}
