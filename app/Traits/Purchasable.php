<?php

namespace App\Traits;

use App\Models\Plan;
use App\Models\Product;
use App\Support\Eloquent\Collection;

trait Purchasable
{
    public bool $is_purchasable = true;
    public $purchase_quantity = 0;
    public $purchased_addons;

    /**
     * Initialize the trait
     *
     * @return void
     */
    public function initializePurchasable(): void
    {
        $this->appendCoreProperties(['purchase_quantity', 'purchased_addons']);
        $this->append(['purchase_quantity', 'purchased_addons']);
        $this->fillable(array_unique(array_merge($this->fillable, ['purchase_quantity', 'addons'])));
    }

    /**
     * @return void
     */
    public function setPurchaseQuantityAttribute($value)
    {
        $this->purchase_quantity = $value;
    }

    /**
     * @return mixed $purchase_quantity
     */
    public function getPurchaseQuantityAttribute()
    {
        return $this->purchase_quantity;
    }

    protected function purchasedAddons(): Attribute
    {
        return Attribute::make(
            get: function($value) {
                return !empty($value) ? new Collection($value) : new Collection();
            },
            set: function($value) {
                return !empty($value) ? new Collection($value) : new Collection();
            },
        );
    }

    public function isSubscribable() {
        return $this instanceof Plan || ($this instanceof Product && (($this?->isSubscription() ?? false) || ($this->isPhysicalSubscription() ?? false)));
    }

    public function isShippable() {
        return $this instanceof Product && (($this?->isStandard() ?? false) || ($this?->isPhysicalSubscription() ?? false));
    }

    public function getSingleCheckoutPermalink() {
        $data = base64_encode(json_encode([
            'id' => $this->id,
            'class' => $this::class,
            'qty' => 1
        ]));

        return route('checkout').'?data='.$data;
    }

    public function getStripeCheckoutPermalink($qty = 1, $preview = false, $interval = null) {
        $data = base64_encode(json_encode([
            'id' => $this->id,
            'class' => $this::class,
            'qty' => $qty, // TODO: need to fix this
            'preview' => $preview,
            'interval' => $interval
        ]));

        return route('stripe.checkout_redirect').'?data='.$data;
    }
}
