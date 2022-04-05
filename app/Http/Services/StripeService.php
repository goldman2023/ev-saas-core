<?php

namespace App\Http\Services;

use App\Facades\CartService;
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
use Stancl\Tenancy\Resolvers\DomainTenantResolver;

class StripeService
{
    public $stripe = null;

    public function __construct($app)
    {
        $this->stripe = new \Stripe\StripeClient(
            get_setting('stripe_sk_test_key') // TODO: Should use Live key on production!!!!
        );
    }

    public function saveStripeProduct($model)
    {
        // Find model's stripe ID in CoreMeta and based on it decide wheter to create OR update Stripe Product
        $stripe_id = $model->core_meta->where('key', '=', 'stripe_product_id')->first();

        if (empty($stripe_id)) {
            //Insert Stripe product
            $this->createStripeProduct($model);
        } else {
            // Update Stripe product
            $this->updateStripeProduct($model, $stripe_id);
        }
    }

    protected function getStripeModePrefix()
    {
        $stripe_key_prefix = 'test_';
        if (get_setting('stripe_mode') == 'live') {
            $stripe_key_prefix = 'live_';
        }


        return $stripe_key_prefix;
    }



    protected function createStripeProduct($model)
    {
        // Reminder: Stripe pricemust be in cents!!!
        $no_of_decimals = strlen(substr(strrchr((string) $model->getTotalPrice(), "."), 1));
        $description = $model->excerpt;
        if (empty($description)) {
            $description = $model->description;
            if (empty($description)) {
                $description = $model->name;
            }
        }
        // $no_of_decimals = strlen(substr(strrchr((string) $model->getTotalPrice(), "."), 1));

        // Create Stripe Product and Price
        $stripe_product = $this->stripe->products->create([
            'id' => $model->id,
            'name' => $model->name,
            'active' => true,
            // 'livemode' => false, // TODO: Make it true in Production
            'description' => $description,
            'images' => [$model->getThumbnail(['w' => 500]), $model->getCover(['w' => 800])],
            'shippable' => $model->is_digital ? false : true,
            // 'tax_code' => '',
            'url' => $model->getPermalink(),
            'unit_label' => substr($model->unit, 0, 12),
            // 'metadata' => []
        ]);

        $stripe_product_price = $this->stripe->prices->create([
            'unit_amount' => $model->getTotalPrice() * (pow(10, $no_of_decimals)), // TODO: Is it Total, Base, or Subtotal, Original etc.???
            'unit_amount' => $model->getTotalPrice() * 100, // TODO: Is it Total, Base, or Subtotal, Original etc.???
            'currency' => strtolower($model->base_currency),
            'product' => $stripe_product->id,
        ]);




        // Create CoreMeta with stripe Product ID and Price ID
        CoreMeta::updateOrCreate([
            'subject_id' => $model->id,
            'subject_type' => $model::class,
            'key' => $this->getStripeModePrefix() . 'stripe_product_id',
            'value' => $stripe_product->id
        ]);







        CoreMeta::updateOrCreate([
            'subject_id' => $model->id,
            'subject_type' => $model::class,
            'key' => $this->getStripeModePrefix() .'stripe_price_id',
            'value' => $stripe_product_price->id
        ]);

        return true;
    }

    public function createCheckoutLink($product)
    {
        $checkout_link['url'] = "#";

        if ($product->core_meta->where('key', '=', 'stripe_price_id')->first()) {
            try {
                $this->createStripeProduct($product);
            } catch (\Exception $e) {

            }
        }

        if (isset($product->core_meta->where('key', '=', 'stripe_price_id')->first()->value)) {
            $price_id = $product->core_meta->where('key', '=', 'stripe_price_id')->first()->value;
        } else {
            $price_id = $product->core_meta->where('key', '=', 'stripe_price_id')->first()->value;
        }
        $stripe_args = [
            'line_items' => [[
                # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
                'price' => $price_id,
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            /* TODO: Create dynamic order on the fly when generating checkout link  */
            'success_url' => 'https://' . DomainTenantResolver::$currentDomain->domain . '/order/16/received',
            'cancel_url' => 'https://' . DomainTenantResolver::$currentDomain->domain  . '/order/canceled',
            'automatic_tax' => [
                'enabled' => false,
            ],
        ];

        /* Guest Checkout, do not add email for guests */
        if (auth()->user()) {
            $email =  auth()->user()->email;
            $stripe_args['customer_email'] = $email;
        } else {
            $email = '';
        }


        if ($product->core_meta->where('key', '=', 'stripe_price_id')->first()) {
            $checkout_link = $this->stripe->checkout->sessions->create(
                $stripe_args
            );
        } else {
            $this->createStripeProduct($product);
            $checkout_link = $this->createCheckoutLink($product);
        }



        return ($checkout_link['url']);
    }
}
