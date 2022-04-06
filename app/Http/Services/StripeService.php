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
use Payments;
use App\Models\CoreMeta;
use Stancl\Tenancy\Resolvers\DomainTenantResolver;

class StripeService
{
    public $stripe = null;
    public $mode_prefix = null;

    public function __construct($app)
    {
        if(empty( Payments::stripe()->stripe_sk )) {
            return redirect()->route('settings.payment_methods');
        }
        // Depending on Stripe Mode for current tenant, use live or test key!
        // Stripe mode can be changed in App Settings!
        if(Payments::isStripeLiveMode()) {
            $this->stripe = new \Stripe\StripeClient(
                Payments::stripe()->stripe_sk_live_key
            );
            $this->mode_prefix = 'live_';
        } else {
            $this->stripe = new \Stripe\StripeClient(
                Payments::stripe()->stripe_sk_test_key
            );
            $this->mode_prefix = 'test_';
        }
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

    protected function createStripeProduct($model)
    {
        // Reminder: Stripe pricemust be in cents!!!
        $description = $model->excerpt;
        if (empty($description)) {
            $description = $model->description;
            if (empty($description)) {
                $description = $model->name;
            }
        }

        try {
            // Create Stripe Product
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
        } catch (\Exception $e) {
            // This means that Product under $model->id already exists, BUT FOR SOME REASON tenant doesn't have the proper CoreMeta key.

            // 1. Get Stripe Product
            if(empty($this->stripe->products)) {
                return false;
            }
            $stripe_product = $this->stripe->products->retrieve($model->id, []);
        }

        // Create CoreMeta with stripe Product ID
        CoreMeta::updateOrCreate(
            [
                'subject_id' => $model->id,
                'subject_type' => $model::class,
                'key' => $this->mode_prefix . 'stripe_product_id',
            ],
            [
                'value' => $stripe_product->id
            ]
        );

        // Create Stripe Price
        $stripe_product_price = $this->stripe->prices->create([
            'unit_amount' => $model->getTotalPrice() * 100, // TODO: Is it Total, Base, or Subtotal, Original etc.???
            'currency' => strtolower($model->base_currency),
            'product' => $stripe_product->id,
        ]);

        // Create CoreMeta with stripe Price ID
        CoreMeta::updateOrCreate(
            [
                'subject_id' => $model->id,
                'subject_type' => $model::class,
                'key' => $this->mode_prefix .'stripe_price_id',
            ],
            [
                'value' => $stripe_product_price->id
            ]
        );

        return $stripe_product;
    }

    protected function updateStripeProduct($model, $stripe_id) {
        return null;
    }

    protected function createStripePrice($model, $stripe_product_id = null) {
        // Get stripe product iD
        if(empty($stripe_product_id))
            $stripe_product_id = $model->core_meta()->where('key', '=', $this->mode_prefix . 'stripe_product_id')->first()?->value ?? null;


        // Create a new price and attach it to stripe product ID
        $stripe_product_price = $this->stripe->prices->create([
            'unit_amount' => $model->getTotalPrice() * 100, // TODO: Is it Total, Base, or Subtotal, Original etc.???
            'currency' => strtolower($model->base_currency),
            'product' => $stripe_product_id,
        ]);

        CoreMeta::updateOrCreate(
            [
                'subject_id' => $model->id,
                'subject_type' => $model::class,
                'key' => $this->mode_prefix .'stripe_price_id',
            ],
            [
                'value' => $stripe_product_price->id
            ]
        );

        return $stripe_product_price;
    }


    public function createCheckoutLink($model, $qty = 1)
    {
        // Check if Stripe Product actually exists
        $stripe_product_id = $model->core_meta()->where('key', '=', $this->mode_prefix . 'stripe_product_id')->first()?->value ?? null;
        if(!empty( $stripe_product_id)) {
            try {

                $stripe_product = $this->stripe->products->retrieve($stripe_product_id, []);
            } catch(\Exception $e) {
                // What if there is no product in stripe under given ID?

                // 1. Create a product and price if product is missing in Stripe
                $stripe_product = $this->createStripeProduct($model);
                // return $this->createCheckoutLink($model, $qty); // try again after product and price are created
            }
        } else {
            return "#";
        }

        return "#";



        // Check latest price existance
        $stripe_price_id = $model->core_meta()->where('key', '=', $this->mode_prefix . 'stripe_price_id')->first()?->value ?? null;

        try {
            $stripe_price = $this->stripe->prices->retrieve($stripe_price_id, []);
        } catch(\Exception $e) {
            // What if there is no price in stripe under given ID OR if old Stripe price doesn't equal to curret product price?
            // 1. Create a new stripe price if price is missing in Stripe
            $stripe_price = $this->createStripePrice($model, $stripe_product_id);
        }


        // Compare current model price and Last Stripe Price and if it does not match, create a new price
        if((float) $stripe_price->unit_amount !== (float) $model->getTotalPrice() * 100) {
            // There is a difference between stripe price and our local price of the product

            // Create new Stripe Price
            $stripe_price = $this->createStripePrice($model, $stripe_product_id);
        }

        $checkout_link['url'] = "#";

        $stripe_args = [
            'line_items' => [
                [
                    # Provide the exact Price ID (e.g. pr_1234) of the model you want to sell
                    'price' => $stripe_price->id,
                    'quantity' => $qty,
                ]
            ],
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

        // Create a Stripe Checkout Link
        $checkout_link = $this->stripe->checkout->sessions->create($stripe_args);

        return $checkout_link['url'] ?? null;
    }

    public function stripeWebhooks() {

    }
}
