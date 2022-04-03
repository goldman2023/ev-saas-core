<?php

namespace App\Http\Services;

use App\Models\Shop;
use App\Models\ShopSetting;
use App\Models\TenantSetting;
use App\Models\User;
use Cache;
use Illuminate\Database\Eloquent\Collection;
use Session;
use EVS;
use FX;
use Stripe;
use App\Models\CoreMeta;

class StripeService
{
    public $stripe = null;

    public function __construct($app) {
        $this->stripe = new \Stripe\StripeClient(
            get_setting('stripe_sk_test_key') // TODO: Should use Live key on production!!!!
        );
    }

    public function saveStripeProduct($model) {
        // Find model's stripe ID in CoreMeta and based on it decide wheter to create OR update Stripe Product
        $stripe_id = $model->core_meta->where('key', '=', 'stripe_product_id')->first();

        if(empty($stripe_id)) {
            //Insert Stripe product
            $this->createStripeProduct($model);
        } else {
            // Update Stripe product
            $this->updateStripeProduct($model, $stripe_id);
        }
    }

    protected function createStripeProduct($model) {
        // Reminder: Stripe pricemust be in cents!!!
        // $no_of_decimals = strlen(substr(strrchr((string) $model->getTotalPrice(), "."), 1));

        // Create Stripe Product and Price
        $stripe_product = $this->stripe->products->create([
            'id' => $model->id,
            'name' => $model->name,
            'active' => true,
            // 'livemode' => false, // TODO: Make it true in Production
            'description' => $model->excerpt,
            'images' => [$model->getThumbnail(['w' => 500]), $model->getCover(['w' => 800])],
            'shippable' => $model->is_digital ? false : true,
            // 'tax_code' => '',
            'url' => $model->getPermalink(),
            'unit_label' => $model->unit,
            // 'metadata' => []
        ]);

        $stripe_product_price = $this->stripe->prices->create([
            'unit_amount' => $model->getTotalPrice() * 100, // TODO: Is it Total, Base, or Subtotal, Original etc.???
            'currency' => strtolower($model->base_currency),
            'product' => $stripe_product->id,
        ]);
        
        // Create CoreMeta with stripe Product ID and Price ID
        CoreMeta::updateOrCreate([
            'subject_id' => $model->id,
            'subject_type' => $model::class,
            'key' => 'stripe_product_id',
            'value' => $stripe_product->id
        ]);

        CoreMeta::updateOrCreate([
            'subject_id' => $model->id,
            'subject_type' => $model::class,
            'key' => 'stripe_price_id',
            'value' => $stripe_product_price->id
        ]);

        return true;
    }

    protected function updateStripeProduct($model, $stripe_id) {
        
    }    
}