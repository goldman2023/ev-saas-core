<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Facades\CartService;
use App\Enums\OrderTypeEnum;
use App\Enums\PaymentStatusEnum;
use App\Enums\UserSubscriptionStatusEnum;
use App\Enums\UserTypeEnum;
use App\Enums\UserEntityEnum;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Plan;
use App\Models\UserSubscription;
use App\Models\Ownership;
use Cache;
use Illuminate\Database\Eloquent\Collection;
use Session;
use EVS;
use FX;
use DB;
use Stripe;
use Payments;
use Carbon;
use Log;
use Uuid;
use App\Models\CoreMeta;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Resolvers\DomainTenantResolver;

class StripeService
{
    public $stripe = null;
    public $mode_prefix = null;
    protected $subscription_billing_reasons = ['subscription_create', 'subscription_update', 'subscription_cycle'];
    protected $unsupported_shipping_countries = ['AS', 'CX', 'CC', 'CU', 'HM', 'IR', 'KP', 'MH', 'FM', 'NF', 'MP', 'PW', 'SD', 'SY', 'UM', 'VI'];
    protected $supported_shipping_countries = []; // TODO: Get Stripe available countries list!!!!

    public function __construct($app)
    {
        // Depending on Stripe Mode for current tenant, use live or test key!
        // Stripe mode can be changed in App Settings!
        if (Payments::isStripeLiveMode()) {
            $this->stripe = new \Stripe\StripeClient([
                'api_key' => Payments::stripe()->stripe_sk_live_key,
                "stripe_version" => "2020-08-27"
            ]);
            $this->mode_prefix = 'live_';
        } else {
            $this->stripe = new \Stripe\StripeClient([
                'api_key' => Payments::stripe()->stripe_sk_test_key,
                "stripe_version" => "2020-08-27"
            ]);
            $this->mode_prefix = 'test_';
        }

        // Set supported shipping countries
        $this->supported_shipping_countries = array_values(array_diff(['LT', 'RS', 'DE', 'GB', 'ES', 'FR', 'US'], $this->unsupported_shipping_countries));
    }

    public function stripe()
    {
        return $this->stripe;
    }

    public function getStripeMode()
    {
        return $this->mode_prefix;
    }

    public function saveStripeProduct($model)
    {
        // Find model's stripe ID in CoreMeta and based on it decide wheter to create OR update Stripe Product
        $stripe_product_id = $model->core_meta->where('key', '=', $this->mode_prefix.'stripe_product_id')->first()?->value ?? '';

        if (empty($stripe_product_id)) {
            //Insert Stripe product
            $this->createStripeProduct($model);
        } else {
            // Update Stripe product
            $this->updateStripeProduct($model, $stripe_product_id);
        }
    }

    protected function generateStripeProductID($model)
    {
        return $this->mode_prefix . strtolower((class_basename($model::class))) . '_' . $model->id;
    }

    protected function createStripeProduct($model)
    {
        // Reminder: Stripe price must be in cents!!!
        $description = $model->excerpt;
        if (empty($description)) {
            $description = strip_tags($model->description);
        }

        $images = [];
        $product_args = [
            'id' => $this->generateStripeProductID($model),
            'name' => $model->name,
            'active' => true,
            // 'livemode' => false, // TODO: Make it true in Production
            'description' => $description,
            'shippable' => $model->isShippable(),
            // 'tax_code' => '',
            'url' => $model->getPermalink(),
            'unit_label' => substr($model?->unit ?? 'pc', 0, 12),
            'metadata' => []
        ];

        // Stripe doesn't support svg images -> let's just use `png, jpg, gif`
        if(strpos($model->getThumbnail(['w' => 500], true), ' ') === false && !empty($model->thumbnail) && in_array($model->thumbnail?->extension ?? 'xxx', ['png', 'jpg', 'gif'])) {
            $images[] = $model->getThumbnail(['w' => 500]);
            $product_args['images'] = $images;
        }

        try {
            // Create Stripe Product
            $stripe_product = $this->stripe->products->create($product_args);
        } catch (\Exception $e) {
            // This means that Product under $model->id already exists, BUT FOR SOME REASON tenant doesn't have the proper CoreMeta key.
            // 1. Get Stripe Product
            Log::error($e);
            Log::error($e->getMessage());

            // TODO: Check Stripe exceptio and based on that see if you can retrieve the product or no.
            $stripe_product = $this->stripe->products->retrieve($this->generateStripeProductID($model), []);
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
        $this->createStripePrice($model, $stripe_product->id);

        return $stripe_product;
    }

    protected function updateStripeProduct($model, $stripe_product_id)
    {
        // Reminder: Stripe price must be in cents!!!
        $description = $model->excerpt;
        if (empty($description)) {
            $description = strip_tags($model->description);
        }

        $images = [];

        $product_args = [
            'name' => $model->name,
            'active' => true,
            'description' => $description,
            'shippable' => $model->isShippable(),
            // 'tax_code' => '',
            'url' => $model->getPermalink(),
            'unit_label' => substr($model?->unit ?? 'pc', 0, 12),
            'metadata' => []
        ];

        // Stripe doesn't support svg images -> let's just use `png, jpg, gif`
        if(strpos($model->getThumbnail(['w' => 500], true), ' ') === false && !empty($model->thumbnail) && in_array($model->thumbnail?->extension ?? 'xxx', ['png', 'jpg', 'gif'])) {
            $images[] = $model->getThumbnail(['w' => 500]);
            $product_args['images'] = $images;
        }

        try {
            // Update Stripe Product
            $stripe_product = $this->stripe->products->update(
                $stripe_product_id,
                $product_args
            );
        } catch (\Exception $e) {
            // Cannot update product with ID: $stripe_product_id,
            // TODO: Should we create another product and assign new stripe_product_id to our product in DB?
            Log::error($e);
            Log::error($e->getMessage());
            Log::error('stripe_product_id in our core_meta for product ('.$model->id.') is obsolete, should we create a new stripe product for this product?');

            // TODO: Check Stripe exceptio and based on that see if you can retrieve the product or no.
            return;
        }

        // Create Stripe Price(s)
        if($model instanceof Plan) {
            // We need to check for both monthly and anual price here
            $stripe_monthly_price_id = $model->core_meta()->where('key', '=', $this->mode_prefix . 'stripe_monthly_price_id')->first()?->value ?? null;
            $stripe_annual_price_id = $model->core_meta()->where('key', '=', $this->mode_prefix . 'stripe_annual_price_id')->first()?->value ?? null;

            // Monthly price check BLOCK
            try {
                $stripe_monthly_price = $this->stripe->prices->retrieve($stripe_monthly_price_id, []);
            } catch (\Exception $e) {
                // What if there is no price in stripe under given ID OR if old Stripe price doesn't equal to curret product price?
                // 1. Create a new stripe price if monthly price is missing in Stripe
                $stripe_monthly_price = $this->createStripePrice($model, $stripe_product_id, 'monthly');
            }

            if ((float) $stripe_monthly_price->unit_amount !== (float) $model->getTotalPrice() * 100) {
                // There is a difference between monthly stripe price and our local monthly price of the Plan
                $stripe_monthly_price = $this->createStripePrice($model, $stripe_product_id, 'monthly');
            }

            // Annual price check BLOCK
            try {
                $stripe_annual_price = $this->stripe->prices->retrieve($stripe_annual_price_id, []);
            } catch (\Exception $e) {
                // What if there is no price in stripe under given ID OR if old Stripe price doesn't equal to curret product price?
                // 1. Create a new stripe MONTHLY price if MONTHLY price is missing in Stripe
                $stripe_annual_price = $this->createStripePrice($model, $stripe_product_id, 'annual');
            }

            if ((float) $stripe_annual_price->unit_amount !== (float) $model->getTotalAnnualPrice() * 100) {
                // There is a difference between ANNUAL stripe price and our local ANNUAL price of the Plan
                $stripe_annual_price = $this->createStripePrice($model, $stripe_product_id, 'annual');
            }
        } else {
            $stripe_price_id = $model->core_meta()->where('key', '=', $this->mode_prefix . 'stripe_price_id')->first()?->value ?? null;

            try {
                $stripe_price = $this->stripe->prices->retrieve($stripe_price_id, []);
            } catch (\Exception $e) {
                // What if there is no price in stripe under given ID OR if old Stripe price doesn't equal to curret product price?
                // 1. Create a new stripe price if price is missing in Stripe
                $stripe_price = $this->createStripePrice($model, $stripe_product_id);
            }


            // Compare current model price and Last Stripe Price and if it does not match, create a new price
            if ((float) $stripe_price->unit_amount !== (float) $model->getTotalPrice() * 100) {
                // There is a difference between stripe price and our local price of the product

                // Create new Stripe Price
                $stripe_price = $this->createStripePrice($model, $stripe_product_id);
            }

        }

        return $stripe_product;
    }

    protected function createStripePrice($model, $stripe_product_id = null, $for_interval = null)
    {
        // Get stripe product iD
        if (empty($stripe_product_id)) {
            $stripe_product_id = $model->core_meta()->where('key', '=', $this->mode_prefix . 'stripe_product_id')->first()?->value ?? null;
        }

        // Create reccuring price if $model is Plan or a Subscription Product
        if ($model->isSubscribable()) {
            $args = [
                'unit_amount' => $model->getTotalPrice() * 100, // TODO: Is it Total, Base, or Subtotal, Original etc.???
                'currency' => strtolower($model->base_currency ? $model->base_currency : 'eur'),
                'product' => $stripe_product_id,
                'recurring' => [
                    "interval" => "month",
                    "interval_count" => 1,
                    "usage_type" => "licensed"
                ]
            ];

            if($model instanceof Plan) {
                // Create both monthly and annual price
                $monthly_args = array_merge($args, [
                    'unit_amount' => $model->getTotalPrice() * 100,
                    'recurring' => [
                        "interval" => "month",
                        "interval_count" => 1,
                        "usage_type" => "licensed"
                    ]
                ]);

                $annual_args = array_merge($args, [
                    'unit_amount' => ($model->getTotalAnnualPrice() * 100),
                    'recurring' => [
                        "interval" => "year",
                        "interval_count" => 1,
                        "usage_type" => "licensed"
                    ]
                ]);
            }

        } else {
            // Create a new price and attach it to stripe product ID
            $args = [
                'unit_amount' => $model->getTotalPrice() * 100, // TODO: Is it Total, Base, or Subtotal, Original etc.???
                'currency' => strtolower($model->base_currency ? $model->base_currency : 'eur'),
                'product' => $stripe_product_id,
            ];
        }

        if($model instanceof Plan) {

            if(empty($for_interval) || $for_interval === 'monthly') {
                $stripe_product_monthly_price = $this->stripe->prices->create($monthly_args);
                CoreMeta::updateOrCreate(
                    [
                        'subject_id' => $model->id,
                        'subject_type' => $model::class,
                        'key' => $this->mode_prefix . 'stripe_monthly_price_id',
                    ],
                    [
                        'value' => $stripe_product_monthly_price->id
                    ]
                );
            }

            // Annual price must be changed when monthly price is changed
            if(empty($for_interval) || ($for_interval === 'annual' || $for_interval === 'annual')) {
                $stripe_product_annual_price = $this->stripe->prices->create($annual_args);

                CoreMeta::updateOrCreate(
                    [
                        'subject_id' => $model->id,
                        'subject_type' => $model::class,
                        'key' => $this->mode_prefix . 'stripe_annual_price_id',
                    ],
                    [
                        'value' => $stripe_product_annual_price->id
                    ]
                );
            }

            if($for_interval === 'monthly') {
                return $stripe_product_monthly_price;
            } elseif($for_interval === 'annual') {
                return $stripe_product_annual_price;
            } else {
                return [
                    'monthly' => $stripe_product_monthly_price,
                    'annual' => $stripe_product_annual_price
                ];
            }
        } else {
            $stripe_product_price = $this->stripe->prices->create($args);

            CoreMeta::updateOrCreate(
                [
                    'subject_id' => $model->id,
                    'subject_type' => $model::class,
                    'key' => $this->mode_prefix . 'stripe_price_id',
                ],
                [
                    'value' => $stripe_product_price->id
                ]
            );

            return $stripe_product_price;
        }
    }

    public function createStripeCustomer($user = null)
    {
        $me = !empty($user) && $user instanceof \App\Models\User ? $user : auth()->user();
        $stripe_customer_id_key = $this->mode_prefix . 'stripe_customer_id';
        $stripe_customer_id = $me->getCoreMeta($stripe_customer_id_key);

        try {
            $stripe_customer = $this->stripe->customers->retrieve(
                $stripe_customer_id,
                []
            );

            if ($stripe_customer->deleted ?? null) {
                throw new \Exception();
            }
        } catch (\Exception $e) {
            // If there's no customer under given ID (can be null or empty) then create stripe customer and associate it with our user
            $params = [
                'email' => $me->email,
                'name' => $me->name . ' ' . $me->surname, // TODO: Can be a Cmpany name if $me is a `company user`
                'phone' => $me->phone,
            ];

            // Billing address
            if (!empty($billing_address = $me->addresses->where('is_billing', true)->first())) {
                $params['address'] = [
                    'city' => $billing_address->city,
                    'country' => $billing_address->country,
                    'state' => $billing_address->state,
                    'postal_code' => $billing_address->zip_code,
                    'line1' => $billing_address->address,
                ];
            }

            // Shipping address
            if (!empty($shipping_address = $me->addresses->where('is_primary', true)->first())) {
                $params['shipping'] = [
                    'address' => [
                        'city' => $shipping_address->city,
                        'country' => $shipping_address->country,
                        'state' => $shipping_address->state,
                        'postal_code' => $shipping_address->zip_code,
                        'line1' => $shipping_address->address,
                    ],
                    'name' => $me->name . ' ' . $me->surname,
                    'phone' => $me->phone
                ];
            }

            $stripe_customer = $this->stripe->customers->create($params);
        }

        $me->saveCoreMeta($stripe_customer_id_key, $stripe_customer->id);

        return $stripe_customer;
    }

    public function createCheckoutLink($model, $qty = 1, $interval = null, $preview = false, $abandoned_order_id = null)
    {
        // Check if Stripe Product actually exists
        $order = null;

        $stripe_product_id = $model->core_meta()->where('key', '=', $this->mode_prefix . 'stripe_product_id')->first()?->value ?? null;

        try {
            $stripe_product = $this->stripe->products->retrieve($stripe_product_id, []);
        } catch (\Exception $e) {
            // What if there is no product in stripe under given ID?

            // 1. Create a product and price if product is missing in Stripe
            $stripe_product = $this->createStripeProduct($model);
            // return $this->createCheckoutLink($model, $qty); // try again after product and price are created
        }


        // Check latest price existance
        if($model instanceof Plan) {
            // We need to check for both monthly and anual price here
            $stripe_monthly_price_id = $model->core_meta()->where('key', '=', $this->mode_prefix . 'stripe_monthly_price_id')->first()?->value ?? null;
            $stripe_annual_price_id = $model->core_meta()->where('key', '=', $this->mode_prefix . 'stripe_annual_price_id')->first()?->value ?? null;

            // Monthly price check BLOCK
            try {
                $stripe_monthly_price = $this->stripe->prices->retrieve($stripe_monthly_price_id, []);
            } catch (\Exception $e) {
                // What if there is no price in stripe under given ID OR if old Stripe price doesn't equal to curret product price?
                // 1. Create a new stripe price if monthly price is missing in Stripe
                $stripe_monthly_price = $this->createStripePrice($model, $stripe_product_id, 'monthly');
            }

            if ((float) $stripe_monthly_price->unit_amount !== (float) $model->getTotalPrice() * 100) {
                // There is a difference between monthly stripe price and our local monthly price of the Plan
                $stripe_monthly_price = $this->createStripePrice($model, $stripe_product_id, 'monthly');
            }

            // Annual price check BLOCK
            try {
                $stripe_annual_price = $this->stripe->prices->retrieve($stripe_annual_price_id, []);
            } catch (\Exception $e) {
                // What if there is no price in stripe under given ID OR if old Stripe price doesn't equal to curret product price?
                // 1. Create a new stripe MONTHLY price if MONTHLY price is missing in Stripe
                $stripe_annual_price = $this->createStripePrice($model, $stripe_product_id, 'annual');
            }

            if ((float) $stripe_annual_price->unit_amount !== (float) $model->getTotalAnnualPrice() * 100) {
                // There is a difference between ANNUAL stripe price and our local ANNUAL price of the Plan
                $stripe_annual_price = $this->createStripePrice($model, $stripe_product_id, 'annual');
            }

            // Determine price by given interval
            if(empty($interval) || $interval === 'month') {
                $stripe_price = $stripe_monthly_price;
            } else if($interval === 'annual') {
                $stripe_price = $stripe_annual_price;
            }
        } else {
            $stripe_price_id = $model->core_meta()->where('key', '=', $this->mode_prefix . 'stripe_price_id')->first()?->value ?? null;

            try {
                $stripe_price = $this->stripe->prices->retrieve($stripe_price_id, []);
            } catch (\Exception $e) {
                // What if there is no price in stripe under given ID OR if old Stripe price doesn't equal to curret product price?
                // 1. Create a new stripe price if price is missing in Stripe
                $stripe_price = $this->createStripePrice($model, $stripe_product_id);
            }


            // Compare current model price and Last Stripe Price and if it does not match, create a new price
            if ((float) $stripe_price->unit_amount !== (float) $model->getTotalPrice() * 100) {
                // There is a difference between stripe price and our local price of the product

                // Create new Stripe Price
                $stripe_price = $this->createStripePrice($model, $stripe_product_id);
            }
        }



        $is_preview = false;
        // Create temporary order and invoice if $review is false and $abandoned_order_id is empty
        if (!$preview && empty($abandoned_order_id)) {
            // Create a Temp Order and Invoice
            $orderAndInvoice = $this->createTempOrderAndInvoice($model, $qty);
            $order = $orderAndInvoice['order'];
            $invoice = $orderAndInvoice['invoice'];
        } else if (!$preview && Order::where('id', '=', $abandoned_order_id)->exists()) {
            // Get abandoned order if order with $abandoned_order_id exists
            $order = Order::find($abandoned_order_id);
            $invoice = $order->invoices->first();
        } else {
            // otherwise, it's just a preview
            $is_preview = true;
        }

        $checkout_link['url'] = "#";

        $stripe_args = [
            'line_items' => [
                [
                    # Provide the exact Price ID (e.g. pr_1234) of the model you want to sell
                    'price' => $stripe_price->id,
                    'quantity' => get_tenant_setting('multiplan_purchase') === true ? $qty : 1,
                    'adjustable_quantity' => [
                        'enabled' => get_tenant_setting('multiplan_purchase') === true ? true : false,
                        // 'minimum' => 0,
                        // 'maximum' => 99
                    ]
                ]
            ],
            'mode' => $model->isSubscribable() ? 'subscription' : 'payment',
            'allow_promotion_codes' => true,
            'tax_id_collection' => [
                'enabled' => true,
            ],
            'billing_address_collection' => 'required',
            'client_reference_id' => $is_preview ? 'preview' : $order->id,
            'metadata' => [
                'order_id' => $is_preview ? 'preview' : $order->id,
                'invoice_id' => $is_preview ? 'preview' : $invoice->id,
                'user_id' => $is_preview ? 'preview' : $order->user_id,
                'shop_id' => $is_preview ? 'preview' : $order->shop_id,
                'session_id' => Session::getId(),
            ],
            'success_url' => route('checkout.order.received', ['id' => $is_preview ? 'preview' : $order->id]),
            'cancel_url' => route('checkout.order.received', ['id' => $is_preview ? 'preview' : $order->id]),
            'automatic_tax' => [
                'enabled' => Payments::stripe()->stripe_automatic_tax_enabled === true ? true : false,
            ],
            'tax_id_collection' => [
                'enabled' => true,
            ],

        ];

        // Check whether mode is 'subscription' or 'payment'
        if($model->isSubscribable()) {
            $stripe_args['subscription_data'] = [
                'metadata' => [
                    'order_id' => $is_preview ? 'preview' : $order->id,
                    'invoice_id' => $is_preview ? 'preview' : $invoice->id,
                ],
            ];

            // If plans trial mode is enabled
            if(get_tenant_setting('plans_trial_mode') && !empty(get_tenant_setting('plans_trial_duration'))) {
                $stripe_args['subscription_data']['trial_period_days'] = get_tenant_setting('plans_trial_duration');
            }
        }

        // Check if Modal is digital or not, and based on that display or hide Stripe shipping options
        if ($model->isShippable()) {
            // If $model is not digital (like standard non-digital product)
            $stripe_args['shipping_address_collection'] = [
                // TODO: Put all allowed shipping countries two-letter codes here. Keep in mind there should be two allowed_shipping_countries settings. One in TenantSettings and other in ShopSettings. ShpoSettings one is used when app is a marketplace!
                'allowed_countries' => $this->supported_shipping_countries // this is test for now - get ALL codes
            ];
        }

        if (!empty(auth()->user())) {
            // Create Stripe customer if it doesn't exist
            $stripe_customer = $this->createStripeCustomer();
            $stripe_args['customer'] = $stripe_customer->id;

            if (!$model->isSubscribable()) {
                // Payment intent data is only available to one-time payments
                $stripe_args['payment_intent_data'] = [
                    'receipt_email' => auth()->user()->email,
                ];
            }

            $stripe_args['customer_update'] = [
                'name' => 'auto',
                'address' => 'auto',
                'shipping' => 'auto',
            ];
        }

        // Create a Stripe Checkout Link
        $checkout_link = $this->stripe->checkout->sessions->create($stripe_args);
        try {

        } catch(\Exception $e) {
            // dd($e);
        }

        // Update order if it's not a preview session!!!
        if (!$is_preview) {
            // Save payment intent inside Order meta
            $meta = $order->meta;
            $meta[$this->mode_prefix .'stripe_payment_intent_id'] = $checkout_link['payment_intent'] ?? null; // store payment intent id
            $meta[$this->mode_prefix .'stripe_checkout_session_id'] = $checkout_link['id'] ?? null; // store chekout session id
            $order->meta = $meta;

            $order->save();
        }

        return $checkout_link['url'] ?? null;
    }

    public function createPortalSession()
    {
        if (auth()->user()) {
            // Create Stripe customer if it doesn't exist
            $stripe_customer = $this->createStripeCustomer();
            $stripe_args['customer'] = $stripe_customer->id;
            $billing_session = $this->stripe->billingPortal->sessions->create([
                'customer' => $stripe_customer->id,
                'return_url' => url()->previous(),
            ]);

            return $billing_session['url'] ?? null;
        }

        return false;
    }

    protected function createTempOrderAndInvoice($model, $qty)
    {
        DB::beginTransaction();

        // TODO: Remove Order on Stripe Checkout Session cancelation IF user_id is not defined (we don't want to collect guest abandoned carts for now)

        // Check if temp cart already exists for this user, shop, is_temp and same orders
        // if(Auth::check()) {
        //     //Select all temp order for this user-shop
        //     $temp_orders = Orders::where([
        //         ['user_id', auth()->user()->id],
        //         ['shop_id', $model->shop_id],
        //         ['is_temp', true]
        //     ]);

        //     if($temp_orders->isNotEmpty()) {
        //         foreach($temp_orders as $order) {
        //             $order_items = $order->order_items()->with('subject')->get();

        //             if($order_items->count() === 1) {
        //                 if($order_items->first()->id === $model->id) {

        //                 }
        //             }
        //         }

        //     }
        // }
        $default_grace_period = 5;

        try {
            $order = new Order();
            $order->shop_id = $model->shop_id;
            $order->payment_status = PaymentStatusEnum::pending()->value;
            $order->same_billing_shipping = false;
            $order->buyers_consent = true;
            $order->is_temp = true;
            $order->email = '';

            // TODO: Should be handled differently
            if ($model->isSubscribable()) {
                /*
                * Invoicing data for SUBSCRIPTIONS/PLANS or INCREMENTAL orders
                */
                $order->type = OrderTypeEnum::subscription()->value;
                $order->number_of_invoices = -1; // 'unlimited' for subscriptions
                $order->invoicing_period = 'month'; // TODO: Add monthly/annual switch
                $order->invoice_grace_period = 0;
                $order->invoicing_start_date = Carbon::now()->timestamp; // when invoicing starts - ***For trial invoicing starts X days from this moment
            } else {
                $order->type = OrderTypeEnum::standard()->value;
                $order->number_of_invoices = 1; // 'unlimited' for subscriptions
                $order->invoicing_period = null; // TODO: Add monthly/annual switch
                $order->invoice_grace_period = $default_grace_period;
                $order->invoicing_start_date = Carbon::now()->timestamp; // when invoicing starts
            }

            // If user is logged in
            if (Auth::check()) {
                $order->email = auth()->user()->email ?? null;
                $order->user_id = auth()->user()->id ?? null;
            }

            $order->billing_first_name = '';
            $order->billing_last_name = '';
            $order->billing_address = '';
            $order->billing_country = '';
            $order->billing_state = '';
            $order->billing_city = '';
            $order->billing_zip = '';
            $order->phone_numbers = [];
            $order->shipping_method = '';
            $order->saveQuietly(); // there could be memory leaks if we use just save()

            $order_item = new OrderItem();
            $order_item->order_id = $order->id;
            $order_item->subject_type = $model::class;
            $order_item->subject_id = $model->id;
            $order_item->name = method_exists($model, 'hasMain') && $model->hasMain() ? $model->main->name : $model->name; // TODO: Think about changing Product `name` col to `title`, it's more universal!
            $order_item->excerpt = method_exists($model, 'hasMain') && $model->hasMain() ? $model->main->excerpt : $model->excerpt;
            $order_item->variant = method_exists($model, 'hasMain') && $model->hasMain() ? $model->getVariantName(key_by: 'name') : null;
            $order_item->quantity = !empty($qty) ? $qty : 1;
            $order_item->base_price = $model->base_price;
            $order_item->discount_amount = ($model->base_price - $model->total_price);
            $order_item->subtotal_price = $model->total_price; // TODO: This should use subtotal_price instead of total_price
            $order_item->total_price = $model->total_price;
            $order_item->tax = 0; // TODO: Think about what to do with this one (But first create Tax BE Logic)!!!
            $order_item->saveQuietly(); // there could be memory leaks if we use just save()


            /*
            * Create Invoice
            */
            $invoice = new Invoice();
            $invoice->is_temp = true; // MUST BE TEMP
            $invoice->payment_method_type = (Payments::stripe())::class;
            $invoice->payment_method_id = Payments::stripe()->id;

            // Change invoice status to paid if mode is 'payment', but if it's a subscription, change status to 'pending' because status will truly change on 'invoice.paid' webhook
            $invoice->order_id = $order->id;
            $invoice->shop_id = $order->shop_id;
            $invoice->user_id = $order->user_id;
            $invoice->payment_status = PaymentStatusEnum::pending()->value;
            $invoice->invoice_number = 'invoice-draft-'.Uuid::generate(4)->string; // this is an invoice draft, hence we can write a random Uuid number, it'll be overriten if real stripe invoice is created

            $invoice->email = $order->email;
            $invoice->billing_first_name = $order->billing_first_name;
            $invoice->billing_last_name = $order->billing_last_name;
            $invoice->billing_company = ''; // TODO: Get company name from invoice somehow...
            $invoice->billing_address = $order->billing_address;
            $invoice->billing_country = $order->billing_country;
            $invoice->billing_state = $order->billing_state;
            $invoice->billing_city = $order->billing_city;
            $invoice->billing_zip = $order->billing_zip;

            // TODO: add base_currency for invoice! and take it from stripe!

            $invoice->start_date = 0; // will be updated on stripe webhooks
            $invoice->end_date = 0; // will be updated on stripe webhooks

            $invoice->saveQuietly(); // there could be memory leaks if we use just save()


            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            // TODO: Think about fallback or some error page to notify user that there's an error on Order creation just before StripeCheckout redirect.
            dd($e);
        }

        return [
            'order' => $order,
            'invoice' => $invoice
        ];
    }

    public function createOrder($stripe_invoice, $stripe_subscription, $payment_failed = false) {
        /*
        * Create Order
        */
        $previous_order = Order::find($stripe_subscription->metadata?->order_id ?? null);
        $first_name = !empty(explode(' ', $stripe_invoice->customer_name)[0] ?? null) ? explode(' ', $stripe_invoice->customer_name)[0] : $previous_order->billing_first_name;
        $last_name = !empty(explode(' ', $stripe_invoice->customer_name)[1] ?? null) ? explode(' ', $stripe_invoice->customer_name)[1] : $previous_order->billing_last_name;
        $number_of_invoices = in_array($stripe_invoice->billing_reason, $this->subscription_billing_reasons) ? '-1' : '1';

        $order = new Order();
        $order->is_temp = false;
        $order->type = in_array($stripe_invoice->billing_reason, $this->subscription_billing_reasons) ? 'subscription' : 'standard';
        $order->user_id = !empty($stripe_subscription->metadata?->user_id ?? null) ? $stripe_subscription->metadata?->user_id : $previous_order->user_id;
        $order->shop_id = !empty($stripe_subscription->metadata?->shop_id ?? null) ? $stripe_subscription->metadata?->shop_id : $previous_order->shop_id;
        $order->email = $stripe_invoice->customer_email;
        $order->billing_first_name = $first_name;
        $order->billing_last_name = $last_name;
        $order->billing_address = $stripe_invoice->customer_address->line1;
        $order->billing_country = $stripe_invoice->customer_address->country;
        $order->billing_state = !empty($stripe_invoice->customer_details->state) ? $stripe_invoice->customer_details->state : '';
        $order->billing_city = $stripe_invoice->customer_address->city;
        $order->billing_zip = $stripe_invoice->customer_address->postal_code;
        $order->phone_numbers = !empty($stripe_invoice->customer_details->phone) ? $stripe_invoice->customer_details->phone : [];
        $order->same_billing_shipping = false;
        $order->shipping_first_name = $first_name;
        $order->shipping_last_name = $last_name;
        $order->shipping_address = !empty($previous_order?->shipping_address ?? null) ? $previous_order?->shipping_address : $stripe_invoice->customer_address->line1;
        $order->shipping_country = !empty($previous_order?->shipping_country ?? null) ? $previous_order?->shipping_country : $stripe_invoice->customer_address->country;
        $order->shipping_state = !empty($previous_order?->shipping_state ?? null) ? $previous_order?->shipping_state : $stripe_invoice->customer_address->state;
        $order->shipping_city = !empty($previous_order?->shipping_city ?? null) ? $previous_order?->shipping_city : $stripe_invoice->customer_address->city;
        $order->shipping_zip = !empty($previous_order?->shipping_zip ?? null) ? $previous_order?->shipping_zip : $stripe_invoice->customer_address->postal_code;
        $order->number_of_invoices = $number_of_invoices;
        $order->invoicing_period = $stripe_subscription->plan?->interval ?? '?';
        $order->invoice_grace_period = 0;
        $order->shipping_method = '';
        $order->shipping_cost = 0;
        $order->tax = 0; // TODO: SHould we add tax from stripe? :-?
        // $order->shipping_status =
        $meta = [];
        $meta[$this->mode_prefix .'stripe_payment_mode'] = in_array($stripe_invoice->billing_reason, $this->subscription_billing_reasons) ? 'subscription' : 'payment'; // IMPORTANT: when mode is `subscription`, stripe_payment_intent_id is NOT SENT, because payment intent is related to future INVOICE not one time session checkout!
        $meta[$this->mode_prefix .'stripe_subscription_id'] = $stripe_subscription->id;
        $meta[$this->mode_prefix .'stripe_latest_invoice_id'] = $stripe_subscription->latest_invoice;
        $meta[$this->mode_prefix .'stripe_payment_intent_id'] = null;
        $meta[$this->mode_prefix .'stripe_checkout_session_id'] = null;
        $meta[$this->mode_prefix .'stripe_request_id'] = null;
        $order->meta = $meta;

        if($stripe_invoice->paid) {
            $order->payment_status = PaymentStatusEnum::paid()->value;
        } else if($payment_failed) {
            $order->payment_status = PaymentStatusEnum::unpaid()->value;
        } else {
            $order->payment_status = PaymentStatusEnum::pending()->value;
        }
        // die(var_dump($order));
        $order->save();


        // Create order items
        foreach ($stripe_subscription->items->data as $subscription_item) {
            $model = CoreMeta::where([
                ['key', $this->mode_prefix.'stripe_product_id'],
                ['value', $subscription_item->price->product]
            ])->first();

            if(!empty($model)) {
                $model = $model->subject;

                $order_item = new OrderItem();
                $order_item->order_id = $order->id;
                $order_item->subject_id = $model->id;
                $order_item->subject_type = $model::class;
                $order_item->name = $model->name;
                $order_item->excerpt = $model->excerpt;
                // $order_item->variant = null;
                $order_item->quantity = $subscription_item->quantity;
                // $order_item->serial_numbers = $model::class;
                $order_item->base_price = $subscription_item->price->unit_amount / 100;
                $order_item->discount_amount = 0; // TODO: How to add discount if there's any??
                $order_item->subtotal_price = $subscription_item->price->unit_amount / 100;
                $order_item->total_price = $subscription_item->price->unit_amount / 100;
                $order_item->tax = 0; // TODO: SHould we add Stripe tax rates here?
                $order_item->save();
            }
        }

        return $order->load('order_items');
    }

    public function createInvoice($order, $stripe_invoice, $stripe_subscription, $payment_failed = false) {
        if($stripe_invoice->billing_reason === 'subscription_cycle') {
            $invoice = $order->invoices()->withoutGlobalScopes()->where([
                ['start_date', $stripe_subscription->current_period_start],
                ['end_date', $stripe_subscription->current_period_end],
            ])->first();
        } else if($stripe_invoice->billing_reason === 'subscription_update') {
            $invoice = $order->invoices()->withoutGlobalScopes()->where([
                ['start_date', $stripe_subscription->current_period_start],
                ['end_date', $stripe_subscription->current_period_end],
                ['meta->'.$this->mode_prefix.'stripe_invoice_id', $stripe_invoice->id]
            ])->first();
        } else {
            die();
        }

        // If new invoice is already created at this moment, it means that invoice.paid already happened, so skip creation cuz invoice already exists and is paid
        if(empty($invoice)) {
            /*
            * Create or Update Invoice (with same number)
            */
            $invoice = Invoice::withoutGlobalScopes()->where('invoice_number', $stripe_invoice->number)->first(); // get invoice by number if it exists

            $invoice = empty($invoice) ? new Invoice() : $invoice;
            $invoice->is_temp = false;
            $invoice->payment_method_type = (Payments::stripe())::class;
            $invoice->payment_method_id = Payments::stripe()->id;

            // Change invoice status to paid if mode is 'payment', but if it's a subscription, change status to 'pending' because status will truly change on 'invoice.paid' webhook
            $invoice->order_id = $order->id;
            $invoice->shop_id = $order->shop_id;
            $invoice->user_id = $order->user_id;
            $invoice->invoice_number = !empty($stripe_invoice->number) ? $stripe_invoice->number : 'invoice-draft-'.Uuid::generate(4)->string;

            if($stripe_invoice->paid) {
                $invoice->payment_status = PaymentStatusEnum::paid()->value;
            } else if($payment_failed) {
                $invoice->payment_status = PaymentStatusEnum::unpaid()->value;
            } else {
                $invoice->payment_status = PaymentStatusEnum::pending()->value;
            }

            // Take period start and end from subscription!
            $invoice->start_date = $stripe_subscription->current_period_start;
            $invoice->end_date = $stripe_subscription->current_period_end;

            $invoice->due_date = $stripe_invoice->due_date ?? null;

            $invoice->base_price = $order->base_price;
            $invoice->discount_amount = $order->discount_amount;
            $invoice->subtotal_price = $stripe_invoice->subtotal / 100; // take from stripe and divide by 100
            $invoice->total_price = $stripe_invoice->total / 100; // take from stripe and divide by 100
            // TODO: What happens when you downgrade???? Total/Subtotal are prorated BUT the proration is in user favor!
            // NOTE: When user downgrade, stripe invoice creates proration in user's favor, and the amount in invoice is the difference between two plans.
            // TODO: How to display this?

            $invoice->email = $order->email;
            $invoice->billing_first_name = $order->billing_first_name;
            $invoice->billing_last_name = $order->billing_last_name;
            $invoice->billing_company = ''; // TODO: Get company name from invoice somehow...
            $invoice->billing_address = $order->billing_address;
            $invoice->billing_country = $order->billing_country;
            $invoice->billing_state = $order->billing_state;
            $invoice->billing_city = $order->billing_city;
            $invoice->billing_zip = $order->billing_zip;
        } else {
            if($stripe_invoice->paid) {
                $invoice->payment_status = PaymentStatusEnum::paid()->value;
            } else if($payment_failed) {
                $invoice->payment_status = PaymentStatusEnum::unpaid()->value;
            } else {
                $invoice->payment_status = PaymentStatusEnum::pending()->value;
            }

            $invoice->invoice_number = $stripe_invoice->number ?? '';
        }

        $meta = $invoice->meta;
        $meta[$this->mode_prefix .'stripe_invoice_id'] = $stripe_invoice->id ?? '';
        $meta[$this->mode_prefix .'stripe_hosted_invoice_url'] = $stripe_invoice->hosted_invoice_url ?? '';
        $meta[$this->mode_prefix .'stripe_invoice_pdf_url'] = $stripe_invoice->invoice_pdf ?? '';
        $meta[$this->mode_prefix .'stripe_invoice_number'] = $stripe_invoice->number ?? '';
        $meta[$this->mode_prefix .'stripe_customer_id'] = $stripe_invoice->customer ?? '';
        $meta[$this->mode_prefix .'stripe_payment_intent_id'] = $stripe_invoice->payment_intent ?? ''; // this will be null on all future automatic reccuring payments
        $meta[$this->mode_prefix .'stripe_subscription_id'] = $stripe_subscription->id; // store subscription ID in invoice meta
        $meta[$this->mode_prefix .'stripe_currency'] = $stripe_invoice->currency ?? null;
        $meta[$this->mode_prefix .'stripe_request_id'] = null;
        $meta[$this->mode_prefix .'stripe_currency'] = $stripe_invoice->currency ?? null;
        $meta[$this->mode_prefix .'stripe_billing_reason'] = $stripe_invoice->billing_reason ?? '';

        // On subscription_cycle, this is probably empty, but let it be just in case
        if(!empty($stripe_invoice->payment_intent ?? null)) {
            $pi = $this->stripe->paymentIntents->retrieve(
                $stripe_invoice->payment_intent,
                []
            );

            if(!empty($pi?->charges?->data[0]?->receipt_url ?? null)) {
                $meta[$this->mode_prefix .'stripe_receipt_url'] = $pi->charges->data[0]?->receipt_url;
            }
        }

        $invoice->meta = $meta;

        $invoice->save();

        return $invoice;
    }

    // WEBHOOKS
    public function processWebhooks(Request $request)
    {
        // This is your Stripe CLI webhook secret for testing your endpoint locally.
        $endpoint_secret = Payments::isStripeLiveMode() ? Payments::stripe()->stripe_webhook_live_secret : Payments::stripe()->stripe_webhook_test_secret;

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        //exit();
        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            print_r($e);
            http_response_code(400);
            exit();
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature

            // Todo: It happens that this is invoked without any reason for Pix-Pro, Fix that later on

            print_r($e);
            http_response_code(400);
            exit();
            // $event = json_decode($payload);
        }

        // Handle the event
        switch ($event->type) {
            case 'charge.succeeded':
                // $this->whChargeSucceeded($event);
                break;
            case 'checkout.session.completed':
                $this->whCheckoutSessionCompleted($event);
                break;
            case 'checkout.session.expired':
                $this->whCheckoutSessionExpired($event);
                break;
            case 'invoice.created':
                $this->whInvoiceCreated($event);
                break;
            case 'invoice.paid':
                $this->whInvoicePaid($event);
                break;
            case 'invoice.payment_failed':
                $this->whInvoicePaymentFailed($event);
                break;
            case 'invoice.payment_succeeded':
                // $paymentIntent = $event->data->object;
                break;
            case 'payment_intent.created':
                break;
            case 'payment_intent.canceled':
                break;
            case 'payment_intent.succeeded':
                // $this->whPaymentIntentSucceeded($event);
                break;
            case 'customer.subscription.created':
                $this->whCustomerSubscriptionCreated($event);
                break;
            case 'customer.subscription.updated':
                $this->whCustomerSubscriptionUpdated($event);
                break;
            case 'customer.subscription.deleted':
                $this->whCustomerSubscriptionDeleted($event);
                break;

                // ... handle other event types
            default:
                echo 'Received unknown event type ' . $event->type;
        }

        http_response_code(200);
        die();
    }

    // checkout.session.completed
    public function whCheckoutSessionCompleted($event)
    {
        $session = $event->data->object;
        $stripe_request_id = $event->request->id;

        DB::beginTransaction();

        try {
            // Populate Order with data from stripe
            $order = Order::withoutGlobalScopes()->findOrFail($session->client_reference_id);
            $order->payment_status = PaymentStatusEnum::paid()->value;
            $order->is_temp = false;
            $order->email = empty($order->email) ? $session->customer_details->email : $order->email;
            $order->billing_company = '';
            $order->billing_first_name = explode(' ', $session->customer_details->name)[0] ?? '';
            $order->billing_last_name = explode(' ', $session->customer_details->name)[1] ?? '';
            $order->billing_address = !empty($session->customer_details->address->line1) ? $session->customer_details->address->line1 : '';
            $order->billing_country = !empty($session->customer_details->address->country) ? $session->customer_details->address->country : '';
            $order->billing_state = !empty($session->customer_details->address->state) ? $session->customer_details->address->state : '';
            $order->billing_city = !empty($session->customer_details->address->city) ? $session->customer_details->address->city : '';
            $order->billing_zip = !empty($session->customer_details->address->postal_code) ? $session->customer_details->address->postal_code : '';
            $order->phone_numbers = !empty($session->customer_details->phone) ? $session->customer_details->phone : [];

            $order->shipping_method = ''; // TODO: Should mimic shipping_method from tenant!!!

            $order->shipping_first_name = explode(' ', $session?->shipping?->name ?? '')[0] ?? '';
            $order->shipping_last_name = explode(' ', $session?->shipping?->name ?? '')[1] ?? '';
            $order->shipping_address = !empty($session?->shipping->address?->line1 ?? '') ? $session->shipping->address->line1 : '';
            $order->shipping_country = !empty($session?->shipping->address?->country ?? '') ? $session->shipping->address->country : '';
            $order->shipping_state = !empty($session?->shipping->address?->state ?? '') ? $session->shipping->address->state : '';
            $order->shipping_city = !empty($session?->shipping->address?->city ?? '') ? $session->shipping->address->city : '';
            $order->shipping_zip = !empty($session?->shipping->address?->postal_code ?? '') ? $session->shipping->address->postal_code : '';

            $meta = $order->meta;
            $meta[$this->mode_prefix .'stripe_payment_mode'] = $session->mode ?? null; // IMPORTANT: when mode is `subscription`, stripe_payment_intent_id is NOT SENT, because payment intent is related to future INVOICE not one time session checkout!
            $meta[$this->mode_prefix .'stripe_subscription_id'] = $session->subscription ?? null; // store payment intent id
            $meta[$this->mode_prefix .'stripe_request_id'] = $stripe_request_id; // store webhook request id
            $order->meta = $meta;

            $initiator = User::find($order->user_id);

            // If Initiator is not registered, create a ghost user
            if(empty($initiator) && !User::where('email', $order->email)->exists()) {
                $initiator = User::updateOrCreate(
                    [
                        'email' => $session->customer_details->email,
                    ],
                    [
                        'is_temp' => true,
                        'user_type' => UserTypeEnum::customer()->value,
                        'entity' => UserEntityEnum::individual()->value,
                        'name' => explode(' ', $session->customer_details->name)[0] ?? $session->customer_details->name,
                        'surname' => explode(' ', $session->customer_details->name)[1] ?? ' ',
                        'phone' => $session->customer_details->phone ?? '',
                        'session_id' => $session->metadata->session_id ?? '' // ghost users will be redirected to proper order-received page based on this!
                    ]
                );

                $order->user_id = $initiator->id;
            }

            $order->save();

            // Check if $model has stock and reduce it if it does!!!
            $order_item = $order->order_items->first();
            $model = $order_item->subject;


            if (method_exists($model, 'stock') && $model->track_inventory) {
                // Reduce the stock quantity of an $model
                $serial_numbers = $model->reduceStock();

                // Serial Numbers only work for Simple Products.
                // TODO: Make Product Variations support serial numbers!
                if ($model->use_serial) {
                    $order_item->serial_numbers = $serial_numbers; // reduceStockBy returns serial numbers in array if $model uses serials
                } else {
                    $order_item->serial_numbers = null;
                }
            }

            // Associate User with Plan (if plan is bought)
            if ($model->isSubscribable()) {
                if (!get_tenant_setting('multiplan_purchase')) {
                    // Single Plan Subscription mode: THIS PART CREATES ONE UserSubscription AND delete all other Plan UserSubscriptions
                    // IMPORTANT: Attach stripe_subscription_id to our UserSubscription
                    // If multiplan purchase is not available, 1) synch user subscription and 2) update stripe data
                    $initiator->plan_subscriptions()->forceDelete(); // delete all subscriptions
                    $subscription = UserSubscription::create([
                        'user_id' => $initiator->id,
                        'subject_id' => $model->id,
                        'subject_type' => $model::class,
                        'order_id' => $order->id,
                        'payment_status' => PaymentStatusEnum::pending()->value, // set payment_status to `pending` because only when invoice.paid, we are sure that payment is 100% successful
                        'status' => UserSubscriptionStatusEnum::inactive()->value, // User subscription is still not active because we need to wait for invoice.paid!
                        'data' => [
                            $this->mode_prefix.'stripe_subscription_id' => $session->subscription ?? null, // store stripe_subscription_id
                            $this->mode_prefix.'stripe_request_id' => $stripe_request_id
                        ],
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' =>  date('Y-m-d H:i:s')
                    ]);
                } else {
                    // TODO: If multiplan purchase is available, logic is different!
                }
            }


            /*
            * Create Invoice here because 'invoice.paid'  hook won't be sent for one-time payments!!!
            */
            $invoice = Invoice::withoutGlobalScopes()->findOrFail($session->metadata->invoice_id ?? -1);;
            $invoice->user_id = $initiator->id;

            if($session->mode === 'payment') {
                // One-time payments do not send invoice.created/paid hook, so we must change some invoice properties here!
                $invoice->is_temp = false;
                $invoice->base_price = $order->base_price;
                $invoice->discount_amount = $order->discount_amount;
                $invoice->subtotal_price = $session->amount_subtotal / 100;
                $invoice->total_price = $session->amount_total / 100; // should be TotalPrice in future...
            }

            // Change invoice status to paid if mode is 'payment', but if it's a subscription, change status to 'pending' because status will truly change on 'invoice.paid' webhook
            $invoice->payment_status = $session->mode === 'payment' ? PaymentStatusEnum::paid()->value : PaymentStatusEnum::pending()->value;

            // TODO: How to align one-time payments invoice numbers with stripe if stripe doesn't create an invoice for one-time payment???
            $invoice->invoice_number = $session->mode === 'payment' ?
                    Invoice::generateInvoiceNumber($order->billing_first_name, $order->billing_last_name, $order->billing_company)
                    : $invoice->invoice_number; // Use: generateInvoiceNumber() for one-time payments and leave as draft for subscription

            $invoice->billing_first_name = $order->billing_first_name;
            $invoice->billing_last_name = $order->billing_last_name;
            $invoice->billing_company = $order->billing_company; // TODO: Get company name from invoice somehow...
            $invoice->billing_address = $order->billing_address;
            $invoice->billing_country = $order->billing_country;
            $invoice->billing_state = $order->billing_state;
            $invoice->billing_city = $order->billing_city;
            $invoice->billing_zip = $order->billing_zip;

            // Take the info from stripe...
            $meta = $invoice->meta;
            $meta[$this->mode_prefix .'stripe_payment_mode'] = $session->mode ?? null;
            $meta[$this->mode_prefix .'stripe_invoice_id'] = null;
            $meta[$this->mode_prefix .'stripe_hosted_invoice_url'] = null;
            $meta[$this->mode_prefix .'stripe_invoice_pdf_url'] = null;
            $meta[$this->mode_prefix .'stripe_invoice_number'] = null;
            $meta[$this->mode_prefix .'stripe_customer_id'] = $session->customer ?? '';
            $meta[$this->mode_prefix .'stripe_payment_intent_id'] = $session->payment_intent ?? ''; // this will be null on all future automatic reccuring payments
            $meta[$this->mode_prefix .'stripe_subscription_id'] = $session->subscription ?? null; // store subscription ID in invoice meta
            $meta[$this->mode_prefix .'stripe_currency'] = $session->currency ?? null;
            $meta[$this->mode_prefix .'stripe_request_id'] = $stripe_request_id;

            if ($session->mode === 'payment') {
                // Append receipt_url to order and invoice (and get it through payment_intent)
                $pi = $this->stripe->paymentIntents->retrieve(
                    $session->payment_intent,
                    []
                );

                $meta[$this->mode_prefix .'stripe_receipt_url'] = $pi->charges->data[0]?->receipt_url;
                $invoice->meta = $meta;
                $invoice->saveQuietly(); // there could be memory leaks if we use just save (no need for events right now)

                $meta = $order->meta;
                $meta[$this->mode_prefix .'stripe_receipt_url'] = $pi->charges->data[0]?->receipt_url;
                $order->meta = $meta;
                $order->save();

                /**
                 * Product Ownership logic (status must be complete and payment_status must be paid)
                 * 1. $session->mode === 'payment'
                 * 2. $session->status === 'complete'
                 * 3. $session->payment_status === 'paid'
                 **/
                if($session->status === 'complete' && $session->payment_status === 'paid') {
                    //TODO: Moved ownership creation logic to OrdersObserver create/update
                }
            } else {
                $invoice->meta = $meta;
                $invoice->saveQuietly(); // there could be memory leaks if we use just save (no need for events right now)
            }


            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            http_response_code(400);
            die($e->getMessage());
        }
        die();
    }

    // checkout.session.expired
    public function whCheckoutSessionExpired($event)
    {
        $session = $event->data->object;

        DB::beginTransaction();

        try {
            // Remove Temp order when stripe checkout session expires, BUT only if order is made by guest user (user_id == null)
            $order = Order::withoutGlobalScopes()->findOrFail($session->client_reference_id);

            if (empty($order->user_id)) {
                // Temp order is not linked to a user, so remove it fully!
                $order->forceDelete();
            } else {
                // Abandoned cart is: is_temp = 1 && payment_status = canceled
                $order->payment_status = PaymentStatusEnum::canceled()->value;
                $order->save();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            http_response_code(400);
            die($e->getMessage());
        }
    }

    // charge.succeeded
    /* public function whChargeSucceeded($event) {
        $stripe_charge = $event->data->object;

        // Take receipt_url from Charge object and store it to: 1) for subscriptions - invoice this charge is related to, 2) for one-time payment - both invoice and order meta
        DB::beginTransaction();

        try {
            if(!empty($stripe_charge->invoice)) {
                // If invoice is not null -> it means that we should use logic for subscriptions => Append receipt_url to related invoice!
                $invoice = Invoice::withoutGlobalScopes()->whereJsonContains('meta->stripe_invoice_id', $stripe_charge->invoice)->first();

                $meta = $invoice->meta;
                $meta['stripe_receipt_url'] = $stripe_charge->receipt_url ?? '';
                $invoice->meta = $meta;

                $invoice->save();

                DB::commit();

                die();
            } else if(!empty($stripe_charge->payment_intent)) {
                // If payment_intent is not null -> it means we should use One-Time payment logic => Append receipt_url to both invoice and order!
                $order = Order::withoutGlobalScopes()->whereJsonContains('meta->stripe_payment_intent_id', $stripe_charge->payment_intent)->first();

                $meta = $order->meta;
                $meta['stripe_receipt_url'] = $stripe_charge->receipt_url ?? '';
                $order->meta = $meta;
                $order->save();

                $invoice = $order->invoices()->withoutGlobalScopes()->first();

                $meta = $invoice->meta;
                $meta['stripe_receipt_url'] = $stripe_charge->receipt_url ?? '';
                $invoice->meta = $meta;
                $invoice->save();

                DB::commit();

                die();
            }

            throw new \Exception('Received stripe charge object has both `payment_intent` and `invoice` properties empty (null). How are we supposed to identify order/invoice/subscription in our system???');
        } catch (\Exception $e) {
            DB::rollBack();
            http_response_code(400);
            die($e->getMessage());
        }

    } */

    // invoice.created
    public function whInvoiceCreated($event)
    {
        $stripe_invoice = $event->data->object;
        $stripe_subscription_id = !empty($stripe_invoice->subscription ?? null) ? $stripe_invoice->subscription : -1;
        $stripe_request_id = $event->request->id;

        // Subscription billing reasons: 'subscription_create', 'subscription_cycle', 'subscription_update'
        // One-time payment billing reason: ''
        $stripe_billing_reason = $stripe_invoice->billing_reason;

        $stripe_subscription = $this->stripe->subscriptions->retrieve(
            $stripe_subscription_id,
            []
          );

        DB::beginTransaction();

        try {
            // IMPORTANT: Invoice `payment_status` MUST DEPEND ONLY ON Stripe invoice ->paid or not paid
            $order = Order::withoutGlobalScopes()->findOrFail($stripe_subscription->metadata->order_id);

            // Add latest stripe invoice id to the Order meta (only if billing reasons are subscription create/cycle - because new order is not being created)
            if($stripe_billing_reason === 'subscription_create' || $stripe_billing_reason === 'subscription_cycle') {
                $order_meta = $order->meta;
                $order_meta[$this->mode_prefix .'stripe_latest_invoice_id'] = $stripe_invoice->id;
                $order->meta = $order_meta;
                $order->save();
            }


            if($stripe_billing_reason === 'subscription_create') {
                // This means that subscription is created for the first time

                $invoice = $order->invoices()->withoutGlobalScopes()->first();

                if (!empty($invoice)) {
                    $invoice->is_temp = false; // Make this Invoice real!

                    if($invoice->payment_status !== PaymentStatusEnum::paid()->value) {
                        // IMPORTANT: Reason for this condition is because invoice.paid webhook can be received before invoice.created
                        // So we have to check if invoice `payment_status` is already changed to 'paid', and if it's not, set it to `pending`
                        $invoice->payment_status = PaymentStatusEnum::pending()->value;
                    }

                    $invoice->invoice_number = $stripe_invoice->number ?? '';

                    // Take period start and end from subscription!
                    $invoice->start_date = $stripe_subscription->current_period_start;
                    $invoice->end_date = $stripe_subscription->current_period_end;

                    $invoice->due_date = $stripe_invoice->due_date ?? null;

                    $invoice->base_price = $order->base_price;
                    $invoice->discount_amount = $order->discount_amount;
                    $invoice->subtotal_price = $stripe_invoice->subtotal / 100; // take from stripe and divide by 100
                    $invoice->total_price = $stripe_invoice->total / 100; // take from stripe and divide by 100

                    $meta = $invoice->meta;
                    $meta[$this->mode_prefix .'stripe_invoice_id'] = $stripe_invoice->id ?? '';
                    $meta[$this->mode_prefix .'stripe_hosted_invoice_url'] = $stripe_invoice->hosted_invoice_url ?? '';
                    $meta[$this->mode_prefix .'stripe_invoice_pdf_url'] = $stripe_invoice->invoice_pdf ?? '';
                    $meta[$this->mode_prefix .'stripe_invoice_number'] = $stripe_invoice->number ?? '';
                    $meta[$this->mode_prefix .'stripe_customer_id'] = $stripe_invoice->customer ?? '';
                    $meta[$this->mode_prefix .'stripe_payment_intent_id'] = $stripe_invoice->payment_intent ?? ''; // this will be null on all future automatic reccuring payments
                    $meta[$this->mode_prefix .'stripe_subscription_id'] = $stripe_subscription_id; // store subscription ID in invoice meta
                    $meta[$this->mode_prefix .'stripe_currency'] = $stripe_invoice->currency ?? null;
                    $meta[$this->mode_prefix .'stripe_request_id'] = $stripe_request_id;
                    $meta[$this->mode_prefix .'stripe_currency'] = $stripe_invoice->currency ?? null;

                    if(!empty($stripe_invoice->payment_intent)) {
                        $pi = $this->stripe->paymentIntents->retrieve(
                            $stripe_invoice->payment_intent,
                            []
                        );

                        if(!empty($pi?->charges?->data[0]?->receipt_url ?? null)) {
                            $meta[$this->mode_prefix .'stripe_receipt_url'] = $pi->charges->data[0]?->receipt_url;
                        }
                    }

                    $invoice->meta = $meta;

                    $invoice->save();

                    DB::commit();
                }

            } else if($stripe_billing_reason === 'subscription_cycle') {
                // Subscription is cycled
                $this->createInvoice(order: $order, stripe_invoice: $stripe_invoice, stripe_subscription: $stripe_subscription);

                DB::commit();
            } else if($stripe_billing_reason === 'subscription_update') {
                // Subscription is updated (downgraded, upgraded etc.) - DON'T DO ANYTHING HERE!!!
                // New order and invoice will be created in subscription.updated webhook
                // $this->createInvoice(order: $order, stripe_invoice: $stripe_invoice, stripe_subscription: $stripe_subscription);

                // DB::commit();
            }
        } catch (\Throwable $e) {
            Log::error($e);
            DB::rollBack();
            http_response_code(400);
        }

        http_response_code(200);
        die();
    }



    // invoice.paid
    public function whInvoicePaid($event)
    {
        $stripe_invoice = $event->data->object;
        $stripe_subscription_id = !empty($stripe_invoice->subscription ?? null) ? $stripe_invoice->subscription : -1;
        $stripe_request_id = $event->request->id;

        // Subscription billing reasons: 'subscription_create', 'subscription_cycle', 'subscription_update'
        // One-time payment billing reason: ''
        $stripe_billing_reason = $stripe_invoice->billing_reason;

        $stripe_subscription = $this->stripe->subscriptions->retrieve(
            $stripe_subscription_id,
            []
          );

        DB::beginTransaction();

        try {
            $order = Order::withoutGlobalScopes()->findOrFail($stripe_subscription->metadata->order_id);

            // Add latest stripe invoice id to the Order meta (only if billing reasons are subscription create/cycle - because new order is not being created)
            if($stripe_billing_reason === 'subscription_create' || $stripe_billing_reason === 'subscription_cycle') {
                $order_meta = $order->meta;
                $order_meta[$this->mode_prefix .'stripe_latest_invoice_id'] = $stripe_invoice->id;
                $order->meta = $order_meta;
                $order->save();
            }

            $user_subscriptions = $order->user_subscriptions()->withoutGlobalScopes()->get();

            if($stripe_billing_reason === 'subscription_create') {
                // This means that subscription is created for the first time
                $invoice = $order->invoices()->withoutGlobalScopes()->firstOrFail();

                if (!empty($invoice)) {
                    $invoice->is_temp = false; // Make this Invoice real!!!
                    $invoice->payment_status = PaymentStatusEnum::paid()->value;
                    $meta = $invoice->meta;
                    $meta[$this->mode_prefix .'stripe_invoice_paid'] = $stripe_invoice->paid ?? true;
                    $meta[$this->mode_prefix .'stripe_invoice_id'] = $stripe_invoice->id ?? '';
                    $meta[$this->mode_prefix .'stripe_hosted_invoice_url'] = $stripe_invoice->hosted_invoice_url ?? '';
                    $meta[$this->mode_prefix .'stripe_invoice_pdf_url'] = $stripe_invoice->invoice_pdf ?? '';
                    $meta[$this->mode_prefix .'stripe_invoice_number'] = $stripe_invoice->number ?? '';
                    $meta[$this->mode_prefix .'stripe_customer_id'] = $stripe_invoice->customer ?? '';
                    $meta[$this->mode_prefix .'stripe_payment_intent_id'] = $stripe_invoice->payment_intent ?? ''; // this will be null on all future automatic reccuring payments
                    $meta[$this->mode_prefix .'stripe_subscription_id'] = $stripe_subscription_id; // store subscription ID in invoice meta
                    $meta[$this->mode_prefix .'stripe_currency'] = $stripe_invoice->currency ?? null;
                    $meta[$this->mode_prefix .'stripe_request_id'] = $stripe_request_id;
                    $meta[$this->mode_prefix .'stripe_currency'] = $stripe_invoice->currency ?? null;

                    if(!empty($stripe_invoice->payment_intent)) {
                        $pi = $this->stripe->paymentIntents->retrieve(
                            $stripe_invoice->payment_intent,
                            []
                        );

                        if(!empty($pi?->charges?->data[0]?->receipt_url ?? null)) {
                            $meta[$this->mode_prefix .'stripe_receipt_url'] = $pi->charges->data[0]?->receipt_url;
                        }
                    }

                    $invoice->meta = $meta;

                    $invoice->save();
                }

                // ***IMPORTANT: subscription `cycle` and `update` are moved to subscription.updated webhook

            }

            // We are sure that invoice is paid so we make user_subscription(s) active and paid too (even though they may already be active and paid as a result of subscription.updated webhook)!
            if ($user_subscriptions->isNotEmpty()) {
                foreach($user_subscriptions as $subscription) {

                    // If subscription has trial start/end (provided from checkout.session)
                    if(!empty($stripe_subscription->trial_start ?? null) && !empty($stripe_subscription->trial_end ?? null)) {
                        $subscription->status = UserSubscriptionStatusEnum::trial()->value;
                        $subscription->payment_status = PaymentStatusEnum::unpaid()->value;
                    } else {
                        $subscription->status = UserSubscriptionStatusEnum::active()->value;
                        $subscription->payment_status = PaymentStatusEnum::paid()->value;
                    }

                    if(empty($subscription->getRawOriginal('start_date'))) {
                        $subscription->start_date = $stripe_subscription->current_period_start;
                    }

                    if(empty($subscription->getRawOriginal('end_date'))) {
                        $subscription->end_date = $stripe_subscription->current_period_end;
                    }

                    $subscription->save();
                }
            }

            DB::commit();
        } catch (\Throwable $e) {
            Log::error($e);
            DB::rollBack();
            http_response_code(400);
        }

        try {
            // Fire Subscription(s) is created and paid Event
            if($stripe_billing_reason === 'subscription_create') {
                do_action('invoice.paid.subscription_create', $user_subscriptions, $stripe_invoice);
            }
            // Fire Subscription(s) is updated and paid Event
            else if($stripe_billing_reason === 'subscription_update') {
                do_action('invoice.paid.subscription_update', $user_subscriptions, $stripe_invoice);
            }
            // Fire Subscription(s) is cycled and paid Event
            else if($stripe_billing_reason === 'subscription_cycle') {
                do_action('invoice.paid.subscription_cycle', $user_subscriptions, $stripe_invoice);
            }
        } catch(\Exception $e) {
            Log::error($e);
        }


        http_response_code(200);
        die();
    }

    // invoice.payment_failed
    public function whInvoicePaymentFailed($event)
    {
        $stripe_invoice = $event->data->object;
        $stripe_subscription_id = !empty($stripe_invoice->subscription ?? null) ? $stripe_invoice->subscription : -1;
        $stripe_request_id = $event->request->id;

        // Subscription billing reasons: 'subscription_create', 'subscription_cycle', 'subscription_update'
        // One-time payment billing reason: ''
        $stripe_billing_reason = $stripe_invoice->billing_reason;

        $stripe_subscription = $this->stripe->subscriptions->retrieve(
            $stripe_subscription_id,
            []
          );

        DB::beginTransaction();

        try {
            $order = Order::withoutGlobalScopes()->findOrFail($stripe_subscription->metadata->order_id);
            $user_subscriptions = $order->user_subscriptions()->withoutGlobalScopes()->get();

            if($stripe_billing_reason === 'subscription_create') {
                // This means that subscription is created for the first time
                $invoice = $order->invoices()->withoutGlobalScopes()->firstOrFail();

                if (!empty($invoice)) {
                    $invoice->is_temp = false; // Make this Invoice real!!!
                    $invoice->payment_status = PaymentStatusEnum::unpaid()->value;
                    $invoice->invoice_number = !empty($stripe_invoice->number) ? $stripe_invoice->number : $invoice->invoice_number;

                    $meta = $invoice->meta;
                    $meta[$this->mode_prefix .'stripe_invoice_paid'] = $stripe_invoice->paid ?? true;
                    $meta[$this->mode_prefix .'stripe_invoice_id'] = $stripe_invoice->id ?? '';
                    $meta[$this->mode_prefix .'stripe_hosted_invoice_url'] = $stripe_invoice->hosted_invoice_url ?? '';
                    $meta[$this->mode_prefix .'stripe_invoice_pdf_url'] = $stripe_invoice->invoice_pdf ?? '';
                    $meta[$this->mode_prefix .'stripe_invoice_number'] = $stripe_invoice->number ?? '';
                    $meta[$this->mode_prefix .'stripe_customer_id'] = $stripe_invoice->customer ?? '';
                    $meta[$this->mode_prefix .'stripe_payment_intent_id'] = $stripe_invoice->payment_intent ?? ''; // this will be null on all future automatic reccuring payments
                    $meta[$this->mode_prefix .'stripe_subscription_id'] = $stripe_subscription_id; // store subscription ID in invoice meta
                    $meta[$this->mode_prefix .'stripe_currency'] = $stripe_invoice->currency ?? null;
                    $meta[$this->mode_prefix .'stripe_request_id'] = $stripe_request_id;
                    $meta[$this->mode_prefix .'stripe_currency'] = $stripe_invoice->currency ?? null;

                    if(!empty($stripe_invoice->payment_intent)) {
                        $pi = $this->stripe->paymentIntents->retrieve(
                            $stripe_invoice->payment_intent,
                            []
                        );

                        if(!empty($pi?->charges?->data[0]?->receipt_url ?? null)) {
                            $meta[$this->mode_prefix .'stripe_receipt_url'] = $pi->charges->data[0]?->receipt_url;
                        }
                    }

                    $invoice->meta = $meta;

                    $invoice->save();
                }

            } else if($stripe_billing_reason === 'subscription_cycle') {
                // This means that subscription is cycled
                $this->createInvoice(order: $order, stripe_invoice: $stripe_invoice, stripe_subscription: $stripe_subscription, payment_failed: true);

            } else if($stripe_billing_reason === 'subscription_update') {
                // Subscription is updated (downgraded, upgraded etc.)
                $this->createInvoice(order: $order, stripe_invoice: $stripe_invoice, stripe_subscription: $stripe_subscription, payment_failed: true);
            } else {
                // No idea...
            }

            // We are sure that invoice is NOT paid so we make user_subscription(s) inactive and unpaid too!
            if ($user_subscriptions->isNotEmpty()) {
                foreach($user_subscriptions as $subscription) {
                    $subscription->status = UserSubscriptionStatusEnum::inactive()->value;
                    $subscription->payment_status = PaymentStatusEnum::unpaid()->value;


                    if(empty($subscription->getRawOriginal('start_date'))) {
                        $subscription->start_date = $stripe_subscription->current_period_start;
                    }

                    if(empty($subscription->getRawOriginal('end_date'))) {
                        $subscription->end_date = $stripe_subscription->current_period_end;
                    }

                    $subscription->save();
                }
            }

            DB::commit();
        } catch (\Throwable $e) {
            Log::error($e);
            DB::rollBack();
            http_response_code(400);
        }

        http_response_code(200);
        die();
    }

    // customer.subscription.created
    public function whCustomerSubscriptionCreated($event)
    {
        $stripe_subscription = $event->data->object;
        $stripe_subscription_id = $stripe_subscription->id;
        $order_id = $stripe_subscription->metadata->order_id ?? -1;

        try {
            $order = Order::withoutGlobalScopes()->findOrFail($order_id);
            $user_subscriptions = $order->user_subscriptions;
            // $user_subscriptions = UserSubscription::withoutGlobalScopes()->whereJsonContains('data->'.$this->mode_prefix.'stripe_subscription_id', $stripe_subscription_id)->first();

            if ($user_subscriptions->isNotEmpty()) {
                foreach($user_subscriptions as $subscription) {
                    $subscription->start_date = $stripe_subscription->current_period_start;
                    $subscription->end_date = $stripe_subscription->current_period_end;

                    $data = $subscription->data;
                    $data[$this->mode_prefix .'stripe_latest_invoice_id'] = $stripe_subscription->latest_invoice ?? null;
                    $subscription->data = $data;


                    // Only change status if user_subscription is trial!
                    if($stripe_subscription->status === 'trialing') {
                        $subscription->status = UserSubscriptionStatusEnum::trial()->value;
                        $subscription->payment_status = PaymentStatusEnum::unpaid()->value;
                    }

                    $subscription->save();

                    // Status of subscription in this webhook is always: "status": "incomplete" or "trialing"
                    // So we should just update start and end date and not change status and payment_status! these will be changed in subscription.updated
                }
            }
        } catch (\Exception $e) {
            http_response_code(400);
            die($e->getMessage());
        }

        http_response_code(200);
        die();
    }

    // customer.subscription.updated
    public function whCustomerSubscriptionUpdated($event)
    {
        $previous_attributes = $event->data->previous_attributes ?? (object) [];
        $stripe_subscription = $event->data->object;
        $stripe_subscription_id = $stripe_subscription->id;
        $order_id = $stripe_subscription->metadata->order_id ?? -1;

        try {
            $order = Order::withoutGlobalScopes()->findOrFail($order_id);
            $user_subscriptions = $order->user_subscriptions;

            // $user_subscriptions = UserSubscription::withoutGlobalScopes()->whereJsonContains('data->'.$this->mode_prefix.'stripe_subscription_id', $stripe_subscription_id)->first();
            if ($user_subscriptions->isNotEmpty()) {
                foreach($user_subscriptions as $subscription) {
                    $subscription->start_date = $stripe_subscription->current_period_start;
                    $subscription->end_date = $stripe_subscription->current_period_end;

                    if($stripe_subscription->cancel_at_period_end ?? false) {
                        // Cancel
                        $subscription->status = UserSubscriptionStatusEnum::active_until_end()->value; // Set to active_until_end because only on 'invoice.paid' we are sure that subscription is 100% paid!
                        $subscription->end_date = $stripe_subscription->cancel_at ?? '';

                    } else if($previous_attributes->cancel_at_period_end ?? false && empty($stripe_subscription->cancel_at_period_end)) {
                        // Renew
                        // Check if previous state was canceled subscription and new `cancel_at_period_end` is null - revive if true
                        $subscription->status = UserSubscriptionStatusEnum::active()->value; // Set to active_until_end because only on 'invoice.paid' we are sure that subscription is 100% paid!

                    } else {
                        $subscription->start_date = $stripe_subscription->current_period_start;
                        $subscription->end_date = $stripe_subscription->current_period_end;

                        // Check if invoice is paid or not, and based on that determine what status this one has
                        $latest_invoice_id = $stripe_subscription->latest_invoice ?? null;
                        $stripe_invoice = $this->stripe->invoices->retrieve(
                            $latest_invoice_id,
                            []
                        );
                        $stripe_billing_reason = $stripe_invoice->billing_reason;

                        // In order to change status of subscription here, we need status of stripe subscription to NOT BE trailing and that invoice is paid
                        if($stripe_subscription->status === 'trialing') {
                            // If invoice is `trialing`, set status to trial and unpaid
                            $subscription->status = UserSubscriptionStatusEnum::trial()->value;
                            $subscription->payment_status = PaymentStatusEnum::unpaid()->value;
                        } else if($stripe_subscription->status != 'trialing' && $stripe_invoice->paid) {
                            // invoice is paid at this point in time; DON'T DO ANYTHING IF STRIPE INVOICE IS NOT PAID!
                            $subscription->status = UserSubscriptionStatusEnum::active()->value;
                            $subscription->payment_status = PaymentStatusEnum::paid()->value;
                        }

                        $data = $subscription->data;
                        $data[$this->mode_prefix .'stripe_latest_invoice_id'] = $latest_invoice_id;
                        $subscription->data = $data;

                        // Determine if subscription is cycled or upgraded/downgraded
                        if($stripe_billing_reason === 'subscription_cycle') {
                            // This means that subscription is cycled - just create a new invoice
                            $this->createInvoice(order: $order, stripe_invoice: $stripe_invoice, stripe_subscription: $stripe_subscription);

                        } else if($stripe_billing_reason === 'subscription_update' && !empty($previous_attributes?->plan?->id ?? null)) {
                            // With condition `!empty($previous_attributes?->plan?->id ?? null)` we are preventing processing any subscription change which is NOT related to it's products/items changes, like metadata change and similar!

                            // Check if Order with latest_invoice_id already exists BUT ALSO CHECK IF previous plan price (if exists) is different than current plan price!
                            // Important observation: Stripe sometimes issues the same invoice for certain subscription.changes, example is downgrade. Since there is some proration, invoice MAY stay the same,
                            // but content of subscription is changed (different products included in subscription)
                            // For this reaon, we cannot just depend on identifying Order only based on `latest_invoice_id`. We must include previous and new price(s) too, in order to know if subscription content really changed
                            // *IMPORTANT* - Getting previous and new price MAY BE DIFFERENT based on multi-product subscriptions and single-product ones. Bu we'll see soon :)
                            $existing_order = Order::query()->withoutGlobalScopes()->whereJsonContains('meta->' . $this->mode_prefix .'stripe_latest_invoice_id', $stripe_subscription->latest_invoice)->first();
                            $existing_invoice = Invoice::query()->withoutGlobalScopes()->whereJsonContains('meta->' . $this->mode_prefix .'stripe_invoice_id', $stripe_subscription->latest_invoice)->first();

                            
                            // Code `should-procceed` ONLY if:
                            // 1. Both Order and Invoice with `latest_invoice_id` cannot be found in our DB
                            // OR
                            // 2. Previous attributes plan->id (actually previous subscription price ID) is different than current subscription price ID

                            if(get_tenant_setting('multiplan_purchase')) {
                                $should_proceed = false; // TODO: This must work according to multi-plan purchase
                            } else {
                                $should_proceed = (empty($existing_order) && empty($existing_invoice) || (($stripe_subscription?->plan?->id ?? 1) !== ($previous_attributes->plan->id ?? 1)));
                            }
                            
                            if($should_proceed) {
                                // Subscription is updated (downgraded, upgraded, interval changed etc.):
                                // 1. Create a new Order
                                // 2. Create a new Invoice
                                // 3. Change order_id of subscriptions on our end
                                // 4. Change order_id in metadata of subscription on Stripe end

                                DB::beginTransaction();

                                try {
                                    $new_order = $this->createOrder(stripe_invoice: $stripe_invoice, stripe_subscription: $stripe_subscription, payment_failed: $stripe_invoice->paid);

                                    // Add Last Order ID to Stripe subscription metadata
                                    $new_metadata = $stripe_subscription->metadata;
                                    $new_metadata->order_id = $new_order->id;

                                    // IMPORTANT - This fires another subscripion.update!!! Prevent any change like this
                                    $this->stripe->subscriptions->update(
                                        $stripe_subscription->id,
                                        ['metadata' => $new_metadata->toArray()]
                                    );

                                    if($stripe_subscription->status != 'trialing') {
                                        $new_invoice = $this->createInvoice(order: $new_order, stripe_invoice: $stripe_invoice, stripe_subscription: $stripe_subscription, payment_failed: $stripe_invoice->paid);

                                        // Add latest Invoice ID on our end to Stripe subscription metadata
                                        $new_metadata->latest_invoice_id = $new_invoice->id;

                                        $this->stripe->subscriptions->update(
                                            $stripe_subscription->id,
                                            ['metadata' => $new_metadata->toArray()]
                                        );
                                    }
                                    

                                    // Check if subscription was upgraded/downgraded
                                    if(count($previous_attributes?->items?->data ?? []) > 0) {
                                        if(get_tenant_setting('multiplan_purchase')) {
                                            // Upgrade/Downgrade when multiple subsriptions feature is enabled
                                        } else {
                                            // Get New Plan/Model based on `Stripe Product ID` in CoreMeta
                                            $stripe_new_plan = $stripe_subscription?->items?->data[0];
                                            $new_plan = CoreMeta::where([
                                                ['key', $this->mode_prefix.'stripe_product_id'],
                                                ['value', $stripe_new_plan->plan->product]
                                            ])->first();

                                            if(!empty($new_plan)) {
                                                // If New Plan/Model is found through CoreMeta, get the new Plan/Model and update subscription's subject columns AND order_id
                                                $new_plan = $new_plan->subject;
                                                $subscription->subject_id = $new_plan->id;
                                                $subscription->subject_type = $new_plan::class;

                                                // Check if subscription status is still `trialing` on Stripe
                                                if($stripe_subscription->status == 'trialing') {
                                                    $subscription->status = UserSubscriptionStatusEnum::trial()->value;
                                                    $subscription->payment_status = PaymentStatusEnum::unpaid()->value;
                                                }

                                                if(isset($new_order)) {
                                                    $subscription->order_id = $new_order->id;
                                                }
                                            } else {
                                                Log::error('Could not update subscription relation because the new Plan was not found through `stripe_product_id` CoreMeta');
                                            }
                                        }
                                    }

                                    DB::commit();
                                } catch(\Throwable $e) {
                                    DB::rollback();
                                    http_response_code(400);
                                    die(print_r($e));
                                }
                            }

                        }

                    }

                    $subscription->save();
                }
            }

            do_action('stripe.webhook.subscriptions.updated', $user_subscriptions);

        } catch (\Exception $e) {
            http_response_code(400);
            die(print_r($e));
        }

        http_response_code(200);
        die();
    }

    // customer.subscription.deleted
    public function whCustomerSubscriptionDeleted($event)
    {
        $stripe_subscription = $event->data->object;
        $stripe_subscription_id = $stripe_subscription->id;

        try {
            // This means that subscription is finally canceled (no revive is possible and it's final, so we should disable subscription on our end!)
            $user_subscription = UserSubscription::withoutGlobalScopes()->whereJsonContains('data->'.$this->mode_prefix.'stripe_subscription_id', $stripe_subscription_id)->first();

            if (!empty($user_subscription)) {
                // Delete subscription on our end! User will have to go through standard process again!
                $user_subscription->delete();
            }
        } catch (\Exception $e) {
            http_response_code(400);
            die($e->getMessage());
        }
    }

    protected function shouldProcess($event)
    {
        $object = $event->data->object;

        // IMPORTANT: All metadata is passed as key:value pairs where `value` is string stype regardless of the real data type, so 1 becomes "1", true becomes "true" etc.).
        // For this reason we use loose comparison (==) instead of strict (===)
        if (isset($object->metadata['stop_hook']) && $object->metadata['stop_hook'] == 1) {
            print_r($object->metadata['stop_hook']);
            http_response_code(200);
            die();
        }
    }


}
