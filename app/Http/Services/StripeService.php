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
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Plan;
use App\Models\UserSubscription;
use App\Models\UserSubscriptionRelationship;
use App\Models\Ownership;
use App\Models\WeBaseModel;
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
use Mpociot\VatCalculator\Facades\VatCalculator;

class StripeService
{
    public $stripe = null;
    public $mode_prefix = null;
    protected $subscription_billing_reasons = ['subscription_create', 'subscription_update', 'subscription_cycle'];
    protected $unsupported_shipping_countries = ['AS', 'CX', 'CC', 'CU', 'HM', 'IR', 'KP', 'MH', 'FM', 'NF', 'MP', 'PW', 'SD', 'SY', 'UM', 'VI'];
    protected $supported_shipping_countries = []; // TODO: Get Stripe available countries list!!!!

    public function __construct($app)
    {
        \Stripe\Stripe::setMaxNetworkRetries(2);

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

    public function getStripeProduct($model, $model_class = null) {
        if(!($model instanceof WeBaseModel) && !empty($model)) {
            $model = app($model_class)->find($model);
        }

        $stripe_product_id = $model->core_meta()->firstWhere('key', '=', $this->mode_prefix . 'stripe_product_id')?->value ?? null;

        try {
            $stripe_product = $this->stripe->products->retrieve($stripe_product_id, []);
        } catch (\Exception $e) {
            // What if there is no product in stripe under given ID?

            // 1. Create a product and price if product is missing in Stripe
            $stripe_product = $this->createStripeProduct($model);
            // return $this->createCheckoutLink($model, $qty); // try again after product and price are created
        }

        return $stripe_product;
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

    public function getStripePrice($model, $model_class = null, $interval = null) {
        if(!($model instanceof WeBaseModel) && !empty($model)) {
            $model = app($model_class)->find($model);
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
            } else if($interval === 'annual' || $interval === 'year') {
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

        return $stripe_price;
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

            // If $customer is company, add TaxID if applicable
            if($me->entity === 'company') {
                $company_country = $me->getUserMeta('company_country');
                $company_vat = $me->getUserMeta('company_vat');

                if(!empty($company_country) && !empty(\Countries::get(code: $company_country))) {
                    $this->stripe->customers->update(
                        $stripe_customer->id,
                        [
                            'address' => [
                                'country' => $company_country
                            ]
                        ]
                    );

                    if(\Countries::isEU($company_country)) {
                        try {
                            if(str_starts_with($company_vat, $company_country)) {
                                $validVAT = VatCalculator::isValidVATNumber($company_vat);
                                $stripe_vat = $company_vat;
                            } else {
                                $validVAT = VatCalculator::isValidVATNumber($company_country.$company_vat);
                                $stripe_vat = $company_country.$company_vat;
                            }
    
                            if($validVAT) {
                                if($company_country === 'LT') {
                                    $this->stripe->customers->update(
                                        $stripe_customer->id,
                                        [
                                            'tax_exempt' => 'none'
                                        ]
                                    );
                                } else {
                                    // Company which has a valid VAT number
                                    $this->stripe->customers->update(
                                        $stripe_customer->id,
                                        [
                                            'tax_exempt' => 'reverse'
                                        ]
                                    );
                                }

                                $this->stripe->customers->createTaxId(
                                    $stripe_customer->id,
                                    ['type' => 'eu_vat', 'value' => $stripe_vat]
                                );
                            } else {
                                // Company which doesn't have a VAT number
                                $this->stripe->customers->update(
                                    $stripe_customer->id,
                                    [
                                        'tax_exempt' => 'none'
                                    ]
                                );
                            }
                        } catch (VATCheckUnavailableException $e) {
                            // The VAT check API is unavailable...
                        }
                    } else {
                        // Company outside of EU - exempt of tax
                        $this->stripe->customers->update(
                            $stripe_customer->id,
                            [
                                'tax_exempt' => 'exempt'
                            ]
                        );
                    }
                    
                }
            } else {
                // Individuals - Stripe checkout will decide it
            }
        }

        $me->saveCoreMeta($stripe_customer_id_key, $stripe_customer->id);

        return $stripe_customer;
    }

    /**
     * cancelStripeSubscriptions
     *
     * This function cancels the stripe subscription via Stripe SDK.
     * If UserSubscription instance is provided and it's based on Stripe, that one UserSubscription will be cancel on Stripe via `stripe_subscription_id`
     * If User instance is provided, all Stripe based subscriptions from provided User will be cancelled
     *
     * @param  mixed $subscription
     * @param  mixed $user
     * @return void
     */
    public function cancelStripeSubscriptions($subscription = null, $user = null) {
        try {
            if(!($subscription instanceof UserSubscription) && !($user instanceof User)) {
                return null;
            }

            if($subscription instanceof UserSubscription && $subscription->isUsingStripe()) {
                $this->stripe->subscriptions->cancel(
                    $subscription->getStripeSubscriptionID(),
                    []
                );
            } else if($user instanceof User && $user->subscriptions->isNotEmpty()) {
                foreach($user->subscriptions as $subscription) {
                    if($subscription->isUsingStripe()) {
                        $this->stripe->subscriptions->cancel(
                            $subscription->getStripeSubscriptionID(),
                            []
                        );
                    }
                }
            }
        } catch(\Throwable $e) {
            Log::error($e);
        }
    }

    /**
     * getUpcomingInvoice
     *
     * Returns real or projected Upcoming invoice from Stripe based on provided subscription and new plan.
     * If no $new_plan and $interval are provided, real upcoming invoice for provided subscription will be returned.
     * If no $new_plan is provided, but $interval is, projected upcoming invoice for different interval for given subscription will be returned.
     * If both $new_plan and $interval are provided, fully-rojected upcoming invoice will be returned. (this can be used for )
     *
     * TODO: Make this function work for multiple quantity and plans in one subscription!
     *
     * @param  mixed $user_subscription
     * @param  mixed $new_plan
     * @param  mixed $interval
     * @return $invoice
     */
    public function getUpcomingInvoice($user_subscription = null, $new_plan = null, $interval = null, $stripe_customer_id = null, $stripe_subscription_id = null) {
        try {
            if(empty($new_plan) && empty($interval)) {
                // Get upcoming invoice for provided subscription.
                if(!empty($stripe_customer_id) && !empty($stripe_subscription_id)) {
                    $invoice = $this->stripe->invoices->upcoming([
                        'customer' => $stripe_customer_id,
                        'subscription' => $stripe_subscription_id,
                    ]);
                } else {
                    $invoice = $this->stripe->invoices->upcoming([
                        'customer' => $user_subscription->user->getStripeCustomerID(),
                        'subscription' => $user_subscription->getStripeSubscriptionID(),
                    ]);
                }

                return array_merge(['invoice_source' => 'stripe'], $invoice->toArray());
            }

            // Set proration date to this moment:
            $proration_date = time();

            $stripe_subscription = $this->stripe->subscriptions->retrieve($user_subscription->getStripeSubscriptionID());
            $stripe_price_id = null;

            if($interval == 'month') {
                $stripe_price_id = $new_plan->getStripeMonthlyPriceID();
            } else if($interval == 'year' || $interval == 'annual') {
                $stripe_price_id = $new_plan->getStripeAnnualPriceID();
            }

            if($stripe_subscription->status === 'trialing') {
                $cycle_anchor = 'now';
            } else {
                if($user_subscription->order->invoicing_period === $interval) {
                    $cycle_anchor = 'now'; // was: 'unchanged'...wtf?
                } else {
                    // TODO: This may not be correct...check other options just in case
                    $cycle_anchor = 'now';
                }
            }

            $params = [
                'customer' => $user_subscription->user->getStripeCustomerID(),
                // 'subscription' => $user_subscription->getStripeSubscriptionID(),
                // 'subscription_proration_date' => $proration_date,
                'subscription_billing_cycle_anchor' => $cycle_anchor,
                // 'subscription_trial_end' => $cycle_anchor,
                'automatic_tax' => ['enabled' => true],
            ];

            if(!empty($new_plan) && !empty($interval)) {
                // See what the next invoice would look like with a price switch and proration set:
                $items = [
                    [
                        // 'id' => $stripe_subscription->items->data[0]->id,
                        'price' => $stripe_price_id, # Switch to new price
                        'quantity' => 1
                    ],
                ];

                $params['subscription_items'] = $items;
            }

            $invoice = $this->stripe->invoices->upcoming($params);
            return array_merge(['invoice_source' => 'stripe'], $invoice->toArray());
        } catch(\Throwable $e) {
            Log::error(array_merge(['error' => $e]));
            return array_merge(['invoice_source' => 'we'], $user_subscription->order->toArray()); // return our Order just in case...
        }
    }

    public function projectSubscriptionInvoice($cart, $interval) {
        $cart_items = [];

        if(!empty($cart)) {

            $params = [
                'customer' => auth()->user()->getStripeCustomerID(), // TODO: Think about changing this to include other users if admin is doing projection for somebody else
                'subscription_billing_cycle_anchor' => 'now',
                'automatic_tax' => ['enabled' => true],
            ];

            foreach($cart as $cart_item) {
                if(!empty($cart_item['plan_id'])) {
                    $plan = Plan::find($cart_item['plan_id']);

                    if(empty($plan)) continue;

                    if($interval == 'month') {
                        $stripe_price_id = $plan->getStripeMonthlyPriceID();
                    } else if($interval == 'year' || $interval == 'annual') {
                        $stripe_price_id = $plan->getStripeAnnualPriceID();
                    }

                    $cart_items[] = [
                        'price' => $stripe_price_id,
                        'quantity' => $cart_item['qty'],
                    ];
                }
            }

            $params['subscription_items'] = $cart_items;

            $invoice = $this->stripe->invoices->upcoming($params);

            return $invoice;
        }
    }

    public function createSubscriptionCheckoutLink($items, $interval = null, $previous_subscription_id = null) {
        $order = null;

        $stripe_line_items = [];
        $order_line_items = [];

        $previous_subscription = !empty($previous_subscription_id) ? UserSubscription::find($previous_subscription_id) : null;
        /**
         * Multi-items subscription logic:
         * 1. In subscription created/updated webhook, compare each previous subscription item quantity with corresponding qty of same item in
         * new subscription and 1) if qty is bigger, create DIFF amount of licenses, 2) if qty is smaller, use previously selected license serial_numbers (actually IDs) from new subscription metadata and revoke/delete these Licenses.
         * ---DONE---*IMPORTANT: Don't forget to create LicenseObserver to remove sub <-> license relation from `user_subscription_relationships` table on license delete.
         * *IMPORTANT: for other licenses which where not removed nor newly created, update the `user_subscription_id` to hold ID of new subscription!!!
         * 2. Remove old subscription from our end (it's important to remove old subscription only after new one is created and old sub. <-> license relations are remapped)
         * - Removing of old-subscription will remove all old-subscription relations with plans, BUT NOT with old licenses, cuz old licenses are remapped to relate to new subscription in previous step
         * 3. Immediately terminate old-subscription on stripe end
         */

        // Loop through desired $items and construct stripe line_items
        if(!empty($items)) {
            foreach($items as $index => $line_item) {
                if(!get_tenant_setting('multi_item_subscription_enabled') && $index > 0)
                    break;

                try {
                    $qty = get_tenant_setting('multi_item_subscription_enabled') ? $line_item['qty'] : 1;
                    $line_item = app($line_item['class'])->find($line_item['id']);
                } catch(\Throwable $e) {
                    continue;
                }

                $stripe_product = $this->getStripeProduct(model: $line_item);
                $stripe_price = $this->getStripePrice(model: $line_item, interval: $interval);

                $stripe_line_items[] = [
                    'price' => $stripe_price->id,
                    'quantity' => !empty($qty) ? $qty : 1,
                    'adjustable_quantity' => [
                        'enabled' => get_tenant_setting('multi_item_subscription_enabled') === true ? true : false,
                        // 'minimum' => 0,
                        // 'maximum' => 99
                    ]
                ];

                $order_line_items[] = [
                    'model' => $line_item,
                    'qty' => $qty,
                ];
            }

            // Create a Temp Order and Invoice
            $orderAndInvoice = $this->createTempOrderAndInvoice(line_items: $order_line_items, interval: $interval);
            $order = $orderAndInvoice['order'];
            $invoice = $orderAndInvoice['invoice'];

            // Start defining Stripe Checkout Session params
            $stripe_args = [
                'line_items' => $stripe_line_items,
                'mode' => 'subscription',
                'allow_promotion_codes' => true,
                'tax_id_collection' => [
                    'enabled' => true,
                ],
                'billing_address_collection' => 'required',
                'client_reference_id' => $order->id,
                'metadata' => [
                    'order_id' => $order->id,
                    'invoice_id' => $invoice->id,
                    'user_id' => $order->user_id,
                    'shop_id' => $order->shop_id,
                    'session_id' => Session::getId(),
                    'previous_subscription_id' => $previous_subscription?->id ?? '',
                    'previous_stripe_subscription_id' => $previous_subscription?->getData(stripe_prefix('stripe_subscription_id')) ?? '',
                    'items_to_remove' => [],
                ],
                'success_url' => route('checkout.order.received', ['id' => $order->id]),
                'cancel_url' => route('checkout.order.received', ['id' => $order->id]),
                'automatic_tax' => [
                    'enabled' => Payments::stripe()->stripe_automatic_tax_enabled === true ? true : false,
                ],
                'tax_id_collection' => [
                    'enabled' => true,
                ],
                'subscription_data' => [
                    'metadata' => [
                        'order_id' => $order->id,
                        'invoice_id' => $invoice->id,
                        'user_id' => $order->user_id,
                        'shop_id' => $order->shop_id,
                        'previous_subscription_id' => $previous_subscription?->id ?? '',
                        'previous_stripe_subscription_id' => $previous_subscription?->getData(stripe_prefix('stripe_subscription_id')) ?? '',
                        'items_to_remove' => [], // TODO: This should be consisted of array of ["subject_id" => xx, "subject_type" => "App\Models\XXX"]
                    ],
                ],
            ];

            // If plans trial mode is enabled
            if(get_tenant_setting('plans_trial_mode') && !empty(get_tenant_setting('plans_trial_duration'))) {
                // TODO: THIS IS WRONG! Track trial usage per user!!!!
                if(!empty($previous_subscription)) {
                    $stripe_args['subscription_data']['trial_period_days'] = get_tenant_setting('plans_trial_duration') - ($previous_subscription->created_at->diff(\Carbon::now())->days);
                } else {
                    $stripe_args['subscription_data']['trial_period_days'] = get_tenant_setting('plans_trial_duration');
                }
            }


            if (!empty(auth()->user())) {
                // Create Stripe customer if it doesn't exist
                $stripe_customer = $this->createStripeCustomer();
                $stripe_args['customer'] = $stripe_customer->id;

                $stripe_args['customer_update'] = [
                    'name' => 'auto',
                    'address' => 'auto',
                    'shipping' => 'auto',
                ];
            }


            $checkout_link = $this->stripe->checkout->sessions->create($stripe_args);

            $order->mergeData([
                stripe_prefix('stripe_payment_intent_id') => $checkout_link['payment_intent'] ?? null, // store payment intent id
                stripe_prefix('stripe_checkout_session_id') => $checkout_link['id'] ?? null, // store chekout session id
            ]);

            $order->save();

            return $checkout_link['url'] ?? null;
        }
    }

    public function createCheckoutLink($model, $qty = 1, $interval = null, $preview = false, $abandoned_order_id = null)
    {
        // Check if Stripe Product actually exists
        $order = null;

        // TODO: Replace with: $this->getStripeProduct()
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
        // TODO: Replace with: getStripePrice()
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
            } else if($interval === 'annual' || $interval === 'year') {
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
            $orderAndInvoice = $this->createTempOrderAndInvoice(line_items: $model, qty: $qty, interval: $interval);
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
                    'quantity' => get_tenant_setting('multi_item_subscription_enabled') === true ? $qty : 1,
                    'adjustable_quantity' => [
                        'enabled' => get_tenant_setting('multi_item_subscription_enabled') === true ? true : false,
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
            'cancel_url' => route('my.plans.management'),
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
            $features = [];
            if(auth()->user()?->subscriptions?->first()?->isTrial()) {
               $features[] = ['subscription_update' => ['enabled' => false]];
            }
            // Create Stripe customer if it doesn't exist
            $stripe_customer = $this->createStripeCustomer();
            $stripe_args['customer'] = $stripe_customer->id;
            $billing_session = $this->stripe->billingPortal->sessions->create([
                'customer' => $stripe_customer->id,
                // 'features' => $features,
                'return_url' => url()->previous(),
            ]);

            return $billing_session['url'] ?? null;
        }

        return false;
    }

    protected function createTempOrderAndInvoice($line_items, $qty = null, $interval = 'month')
    {
        DB::beginTransaction();

        $model = null;

        if($line_items instanceof WeBaseModel) {
            // Only one $model is provided as $line_items
            $model = $line_items;
            $shop_id = $model->shop_id;
            $is_subscribable = $model->isSubscribable();
        } else if(is_array($line_items) && !empty($line_items)) {
            // Array of line items is provided
            $is_subscribable = $line_items[0]['model']?->isSubscribable();
            $shop_id = $line_items[0]['model']?->shop_id;
        }

        // TODO: Remove Order on Stripe Checkout Session cancelation IF user_id is not defined (we don't want to collect guest abandoned carts for now)

        $default_grace_period = 5;

        try {
            $order = new Order();
            $order->shop_id = $shop_id;
            $order->payment_status = PaymentStatusEnum::pending()->value;
            $order->same_billing_shipping = false;
            $order->buyers_consent = true;
            $order->is_temp = true;
            $order->email = '';

            // TODO: Should be handled differently
            if ($is_subscribable) {
                /*
                * Invoicing data for SUBSCRIPTIONS/PLANS or INCREMENTAL orders
                */
                $order->type = OrderTypeEnum::subscription()->value;
                $order->number_of_invoices = -1; // 'unlimited' for subscriptions
                $order->invoicing_period = ($interval === 'year' || $interval === 'annual') ? 'year' : 'month';
                $order->invoice_grace_period = 0;
                $order->invoicing_start_date = Carbon::now()->timestamp; // when invoicing starts - ***For trial invoicing starts X days from this moment
            } else {
                $order->type = OrderTypeEnum::standard()->value;
                $order->number_of_invoices = 1;
                $order->invoicing_period = null;
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

            $order_line_items = empty($model) ? $line_items : [
                [
                    'model' => $model,
                    'qty' => 1
                ]
            ];
            foreach($order_line_items as $line_item) {
                $model = $line_item['model'];
                $qty = $line_item['qty'];

                $order_item = new OrderItem();
                $order_item->order_id = $order->id;
                $order_item->subject_type = $model::class;
                $order_item->subject_id = $model->id;
                $order_item->name = ($model?->is_variation ?? false)  ? $model->main->name : $model->name; // TODO: Think about changing Product `name` col to `title`, it's more universal!
                $order_item->excerpt = ($model?->is_variation ?? false) ? $model->main->excerpt : $model->excerpt;
                $order_item->variant = ($model?->is_variation ?? false) ? $model->getVariantName(key_by: 'name') : null;
                $order_item->quantity = !empty($qty) ? $qty : 1;
                $order_item->tax = 0; // TODO: Think about what to do with this one (But first create Tax BE Logic)!!!

                if ($model->isSubscribable()) {
                    $order_item->base_price = ($interval === 'year' || $interval === 'annual') ? ($model->getOriginalPrice() * 12) : $model->getOriginalPrice();;
                    $order_item->discount_amount = ($interval === 'year' || $interval === 'annual') ? (($model->getOriginalPrice() * 12) - $model->getTotalAnnualPrice()) : ($model->getOriginalPrice()  - $model->getTotalPrice());
                    $order_item->subtotal_price = ($interval === 'year' || $interval === 'annual') ? $model->getTotalAnnualPrice() : $model->getTotalPrice(); // TODO: This should use subtotal_price instead of total_price
                    $order_item->total_price = ($interval === 'year' || $interval === 'annual') ? $model->getTotalAnnualPrice() : $model->getTotalPrice();
                } else {
                    $order_item->base_price = $model->getOriginalPrice();
                    $order_item->discount_amount = $model->getOriginalPrice()  - $model->getTotalPrice();
                    $order_item->subtotal_price = $model->getTotalPrice(); // TODO: This should use subtotal_price instead of total_price
                    $order_item->total_price = $model->getTotalPrice();
                }

                $order_item->saveQuietly(); // there could be memory leaks if we use just save()
            }

            /*
            * Create Invoice
            */
            $invoice = new Invoice();
            $invoice->mode = Payments::isStripeLiveMode() ? 'live' : 'test';
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
            'order' => $order->load('order_items'),
            'invoice' => $invoice
        ];
    }

    /**
     * createOrder
     *
     * Creates new Order based on provided parameters from stripe!
     *
     * TODO: Improve this function to include Order creation for both STANDARD and SUBSCRIPTION based Orders! (for now it's only for SUBSCRIPTION)
     *
     * @param  mixed $stripe_invoice
     * @param  mixed $stripe_subscription
     * @return $order
     */
    public function createOrder($stripe_invoice, $stripe_subscription) {
        if(empty($stripe_subscription?->metadata?->order_id ?? null)) {
            // This means that webhook which uses this action originates from Stripe directly and not from our system!
            // (We always supply metadata if checkout process goes through WeSaaS)
            $user = get_user_by_stripe_customer_id($stripe_subscription->customer);

            // *IMPORTANT: We don't support one Order with mixed products from different vendors! If cart contains products from different vendors, it must be separated as 1 order per 1 vendor!!!
            $model = get_model_by_stripe_product_id($stripe_subscription->items->data[0]->price->product);
            $shop = $model->shop;

            $first_name = !empty(explode(' ', $stripe_invoice->customer_name)[0] ?? null) ? explode(' ', $stripe_invoice->customer_name)[0] : $user->name;
            $last_name = !empty(explode(' ', $stripe_invoice->customer_name)[1] ?? null) ? explode(' ', $stripe_invoice->customer_name)[1] : $user->surname;
            $user_id = $user->id;
            $shop_id = $shop->id;

            $shipping_first_name = !empty(explode(' ', $stripe_invoice->customer_shipping->name)[0] ?? null) ? explode(' ', $stripe_invoice->customer_shipping->name)[0] : $first_name;
            $shipping_last_name = !empty(explode(' ', $stripe_invoice->customer_shipping->name)[1] ?? null) ? explode(' ', $stripe_invoice->customer_shipping->name)[1] : $last_name;
            $shipping_address = $stripe_invoice->customer_shipping->address?->line1 ?? null;
            $shipping_country = $stripe_invoice->customer_shipping->address?->country ?? null;
            $shipping_state = $stripe_invoice->customer_shipping->address?->state ?? null;
            $shipping_city = $stripe_invoice->customer_shipping->address?->city ?? null;
            $shipping_zip = $stripe_invoice->customer_shipping->address?->postal_code ?? null;
        } else {
            $previous_order = Order::find($stripe_subscription->metadata?->order_id ?? null);

            $first_name = !empty(explode(' ', $stripe_invoice->customer_name)[0] ?? null) ? explode(' ', $stripe_invoice->customer_name)[0] : $previous_order->billing_first_name;
            $last_name = !empty(explode(' ', $stripe_invoice->customer_name)[1] ?? null) ? explode(' ', $stripe_invoice->customer_name)[1] : $previous_order->billing_last_name;
            $user_id = !empty($stripe_subscription->metadata?->user_id ?? null) ? $stripe_subscription->metadata?->user_id : $previous_order->user_id;
            $shop_id = !empty($stripe_subscription->metadata?->shop_id ?? null) ? $stripe_subscription->metadata?->shop_id : $previous_order->shop_id;

            $shipping_first_name = !empty(explode(' ', ($stripe_invoice->customer_shipping?->name ?? ''))[0] ?? null) ? explode(' ', ($stripe_invoice->customer_shipping?->name ?? ''))[0] : $previous_order->shipping_first_name;
            $shipping_last_name = !empty(explode(' ', ($stripe_invoice->customer_shipping?->name ?? ''))[1] ?? null) ? explode(' ', ($stripe_invoice->customer_shipping?->name ?? ''))[1] : $previous_order->shipping_last_name;
            $shipping_address = !empty($stripe_invoice->customer_shipping->address->line1 ?? null) ? $stripe_invoice->customer_shipping->address->line1 : $previous_order?->shipping_address;
            $shipping_country = !empty($stripe_invoice->customer_shipping->address->country ?? null) ? $stripe_invoice->customer_shipping->address->country : $previous_order?->shipping_country;
            $shipping_state = !empty($stripe_invoice->customer_shipping->address->state ?? null) ? $stripe_invoice->customer_shipping->address->state : $previous_order?->shipping_state;
            $shipping_city = !empty($stripe_invoice->customer_shipping->address->city ?? null) ? $stripe_invoice->customer_shipping->address->city : $previous_order?->shipping_city;
            $shipping_zip = !empty($stripe_invoice->customer_shipping->address->postal_code ?? null) ? $stripe_invoice->customer_shipping->address->postal_code : $previous_order?->shipping_zip;
        }

        if(in_array($stripe_invoice->billing_reason, $this->subscription_billing_reasons)) {
            // Get Upcoming invoice from stripe if Order is for SUBSCRIPTION and save it to Order meta field under `{prefix}stripe_upcoming_invoice` property
            $upcoming_invoice = \StripeService::getUpcomingInvoice(stripe_customer_id: $stripe_subscription->customer, stripe_subscription_id: $stripe_subscription->id);
        }

        $number_of_invoices = in_array($stripe_invoice->billing_reason, $this->subscription_billing_reasons) ? '-1' : '1';

        $order = new Order();
        $order->is_temp = false;
        $order->type = in_array($stripe_invoice->billing_reason, $this->subscription_billing_reasons) ? 'subscription' : 'standard';
        $order->user_id = $user_id;
        $order->shop_id = $shop_id;
        $order->email = $stripe_invoice->customer_email;
        $order->billing_first_name = $first_name;
        $order->billing_last_name = $last_name;
        $order->billing_address = $stripe_invoice->customer_address->line1;
        $order->billing_country = $stripe_invoice->customer_address->country;
        $order->billing_state = $stripe_invoice->customer_address->state;
        $order->billing_city = $stripe_invoice->customer_address->city;
        $order->billing_zip = $stripe_invoice->customer_address->postal_code;
        $order->phone_numbers = array_filter([$stripe_invoice->customer_shipping?->phone ?? null, $stripe_invoice->customer_phone]);
        $order->same_billing_shipping = false;
        $order->shipping_first_name = $shipping_first_name;
        $order->shipping_last_name = $shipping_last_name;
        $order->shipping_address = $shipping_address;
        $order->shipping_country = $shipping_country;
        $order->shipping_state = $shipping_state;
        $order->shipping_city = $shipping_city;
        $order->shipping_zip = $shipping_zip;
        $order->number_of_invoices = $number_of_invoices;
        $order->invoicing_period = $stripe_subscription?->items?->data[0]?->plan?->interval ?? null;
        $order->invoice_grace_period = 0;
        $order->shipping_method = '';
        $order->shipping_cost = 0;
        $order->tax = isset($upcoming_invoice) && !empty($upcoming_invoice) ? ($upcoming_invoice['tax'] / 100) : ($stripe_invoice->tax / 100);
        // Reason for getting tax amount from upcoming_invoice for subscriptions is TRIAL. If subscription is still in trial mode, it means that current $stripe_invoice has a tax of 0!

        $order->mergeData([
            stripe_prefix('stripe_payment_mode') => in_array($stripe_invoice->billing_reason, $this->subscription_billing_reasons) ? 'subscription' : 'payment', // IMPORTANT: when mode is `subscription`, stripe_payment_intent_id is NOT SENT, because payment intent is related to future INVOICE not one time session checkout!
            stripe_prefix('stripe_subscription_id') => $stripe_subscription->id,
            stripe_prefix('stripe_latest_invoice_id') => $stripe_subscription->latest_invoice,
            stripe_prefix('stripe_payment_intent_id') => null,
            stripe_prefix('stripe_checkout_session_id') => null,
        ]);

        if(in_array($stripe_invoice->billing_reason, $this->subscription_billing_reasons)) {
            $order->setData(stripe_prefix('stripe_upcoming_invoice'), is_array($upcoming_invoice) ? $upcoming_invoice : $upcoming_invoice->toArray());
        }

        if($stripe_invoice->paid && $stripe_subscription->status === 'active') {
            $order->payment_status = PaymentStatusEnum::paid()->value;
        } else if(!$stripe_invoice->paid || $stripe_subscription->status === 'trialing') {
            $order->payment_status = PaymentStatusEnum::unpaid()->value;
        } else {
            $order->payment_status = PaymentStatusEnum::pending()->value;
        }

        $order->save();


        // Create order items
        foreach ($stripe_subscription->items->data as $subscription_item) {
            $model = get_model_by_stripe_product_id($subscription_item->price->product);

            if(empty($model)) {
                // Get product data from Stripe if product cannot be found in our system...
                $model = $this->stripe->products->retrieve($subscription_item->price->product, []);
            }

            if($stripe_subscription->status === 'trialing') {
                $subscription_item = collect($upcoming_invoice['lines']['data'])->firstWhere('price.product', $subscription_item->price->product);
                $tax = collect($subscription_item['tax_amounts'])->reduce(function ($carry, $value, $key) {
                    return $carry + $value['amount'];
                }) / 100;
            } else {
                $tax = collect($subscription_item?->tax_amounts ?? [])->reduce(function ($carry, $value, $key) {
                    return $carry + $value->amount;
                }) / 100;
            }

            $subscription_item = !is_array($subscription_item) ? $subscription_item->toArray() : $subscription_item;

            $order_item = new OrderItem();
            $order_item->order_id = $order->id;
            $order_item->subject_id = !empty($model->id ?? null) ? $model->id : null;
            $order_item->subject_type = !empty($model ?? null) ? $model::class : null;
            $order_item->name = $model?->name ?? '';
            $order_item->excerpt = $model?->excerpt ?? ($model?->description ?? null);
            $order_item->quantity = $subscription_item['quantity'];
            // $order_item->serial_numbers = $model::class; // TODO: Add serial numbers here!!! Serial numbers must be provided in metadata through checkout link!
            $order_item->base_price = $subscription_item['price']['unit_amount'] / 100;
            $order_item->discount_amount = 0; // TODO: How to add discount if there's any??
            $order_item->subtotal_price = $subscription_item['price']['unit_amount'] / 100;
            $order_item->total_price = $subscription_item['price']['unit_amount'] / 100;
            $order_item->tax = $tax;

            // If $model is variation, add `variant` json column
            if($model?->is_variation ?? false) {
                $order_item->variant = $model->variant;
            }

            $order_item->save();
        }

        return $order->load(['order_items', 'order_items.subject', 'user']);
    }

    /**
     * createInvoice
     *
     * Creates new Invoice based on provided parameters from stripe and our order!
     *
     * TODO: Improve this function to include Order creation for both STANDARD and SUBSCRIPTION based Orders! (for now it's only for SUBSCRIPTION)
     *
     * @param  mixed $stripe_invoice
     * @param  mixed $stripe_subscription
     * @return $invoice
     */
    public function createInvoice($order, $stripe_invoice, $stripe_subscription) {
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
        } else if($stripe_invoice->billing_reason === 'subscription_create') {
            $invoice = null;
        } else {
            die();
        }

        if(in_array($stripe_invoice->billing_reason, $this->subscription_billing_reasons)) {
            // Get Upcoming invoice from stripe if Order is for SUBSCRIPTION and save it to Order meta field under `{prefix}stripe_upcoming_invoice` property
            $upcoming_invoice = \StripeService::getUpcomingInvoice(stripe_customer_id: $stripe_subscription->customer, stripe_subscription_id: $stripe_subscription->id);
        }

        // If new invoice is already created at this moment, it means that invoice.paid already happened, so skip creation cuz invoice already exists and is paid
        if(empty($invoice)) {
            /*
            * Create or Update Invoice (with same number)
            */
            $invoice = Invoice::withoutGlobalScopes()->where('invoice_number', $stripe_invoice->number)->first(); // get invoice by number if it exists

            $invoice = empty($invoice) ? new Invoice() : $invoice;
            $invoice->mode = Payments::isStripeLiveMode() ? 'live' : 'test';
            $invoice->is_temp = false;
            $invoice->payment_method_type = (Payments::stripe())::class;
            $invoice->payment_method_id = Payments::stripe()->id;

            $invoice->order_id = $order->id;
            $invoice->shop_id = $order->shop_id;
            $invoice->user_id = $order->user_id;
            $invoice->invoice_number = !empty($stripe_invoice->number ?? null) ? $stripe_invoice->number : 'invoice-draft-'.Uuid::generate(4)->string;

            // TODO: Change invoice status to paid if mode is 'payment', but if it's a subscription, change status to 'pending' because status will truly change on 'invoice.paid' webhook
            if($stripe_invoice->paid && $stripe_subscription->status === 'active') {
                $invoice->payment_status = PaymentStatusEnum::paid()->value;
            } else if(!$stripe_invoice->paid || $stripe_subscription->status === 'trialing') {
                $invoice->payment_status = PaymentStatusEnum::unpaid()->value;
            } else {
                $invoice->payment_status = PaymentStatusEnum::pending()->value;
            }

            // Take period start and end from subscription!
            $invoice->start_date = $stripe_subscription->current_period_start;
            $invoice->end_date = $stripe_subscription->current_period_end;

            $invoice->due_date = $stripe_invoice->due_date ?? null;

            if($stripe_invoice->amount_due > 0) {
                $invoice->base_price = $stripe_invoice->subtotal_excluding_tax / 100;

                if($stripe_invoice->starting_balance < 0) {
                    $invoice->discount_amount = abs($stripe_invoice->starting_balance) / 100; // incudes proration as discount
                } else {
                    $invoice->discount_amount = $order->discount_amount;
                }

                $invoice->subtotal_price = $stripe_invoice->subtotal_excluding_tax / 100;
                $invoice->total_price = $stripe_invoice->amount_due / 100; // This is basically most important...it's the end price user must pay
            } else {
                // If amount due is 0, make invoice totals 0!!!!
                $invoice->base_price = 0;
                $invoice->discount_amount = 0;
                $invoice->subtotal_price = 0;
                $invoice->total_price = 0;
            }
            
            // TODO: What happens when you downgrade???? Total/Subtotal are prorated BUT the proration is in user favor!
            // NOTE: When user downgrade, stripe invoice creates proration in user's favor, and the amount in invoice is the difference between two plans.
            // TODO: How to display this?
            // Answer: For now it's minus :D and we hide such invoices on our end, but still log them!

            $invoice->tax = $stripe_invoice->tax / 100;

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
            // If invoice with same number already exists on our end, just update it's status based on stripe params!
            if($stripe_invoice->paid && $stripe_subscription->status === 'active') {
                $invoice->payment_status = PaymentStatusEnum::paid()->value;
            } else if(!$stripe_invoice->paid || $stripe_subscription->status === 'trialing') {
                $invoice->payment_status = PaymentStatusEnum::unpaid()->value;
            } else {
                $invoice->payment_status = PaymentStatusEnum::pending()->value;
            }

            if(!empty($stripe_invoice->number ?? null)) {
                $stripe_invoice_number = $stripe_invoice->number;
            }
        }

        $invoice->setRealInvoiceNumber();

        $meta = $invoice->meta;
        $meta[$this->mode_prefix .'stripe_invoice_id'] = $stripe_invoice->id ?? '';
        $meta[$this->mode_prefix .'stripe_hosted_invoice_url'] = $stripe_invoice->hosted_invoice_url ?? '';
        $meta[$this->mode_prefix .'stripe_invoice_pdf_url'] = $stripe_invoice->invoice_pdf ?? '';
        $meta[$this->mode_prefix .'stripe_invoice_number'] = $stripe_invoice->number ?? '';
        $meta[$this->mode_prefix .'stripe_customer_id'] = $stripe_invoice->customer ?? '';
        $meta[$this->mode_prefix .'stripe_payment_intent_id'] = $stripe_invoice->payment_intent ?? ''; // this will be null on all future automatic reccuring payments
        $meta[$this->mode_prefix .'stripe_subscription_id'] = $stripe_subscription->id; // store subscription ID in invoice meta
        $meta[$this->mode_prefix .'stripe_currency'] = $stripe_invoice->currency ?? null;
        $meta[$this->mode_prefix .'stripe_currency'] = $stripe_invoice->currency ?? null;
        $meta[$this->mode_prefix .'stripe_billing_reason'] = $stripe_invoice->billing_reason ?? '';
        $meta[$this->mode_prefix .'stripe_invoice_data'] = $stripe_invoice->toArray();


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
            case 'customer.created':
                $this->whCustomerCreated($event);
                break;
            case 'customer.updated':
                $this->whCustomerUpdated($event);
                break;
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
            case 'invoice.upcoming':
                // TODO: Check when this one fires and store upcoming invoice data somewhere!!!!
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

    // customer.created
    public function whCustomerCreated($event) {
        $customer = $event->data->object;

        $stripe_customer_id = $customer->id;

        $user = get_user_by_stripe_customer_id($stripe_customer_id);

        if(empty($user)) {
            DB::beginTransaction();

            try {
                // Create ghost user User on our end (don't yet fire created user event, hence why we use withoutEvents())
                $user = User::create([
                    'is_temp' => true,
                    'user_type' => UserTypeEnum::customer()->value,
                    'entity' => UserEntityEnum::individual()->value, // TODO: How determine if user is individual or company?
                    'name' => explode(' ', $customer->name)[0] ?? $customer->name,
                    'surname' => explode(' ', $customer->name)[1] ?? $customer->name,
                    'email' => $customer->email,
                    'phone' => $customer->phone,
                    'password' => null,
                ]);

                // Add Stripe Customer ID core_meta to $user
                $user->saveCoreMeta($this->mode_prefix.'stripe_customer_id', $stripe_customer_id);

                // Create primary billing address, only if customer in stripe has it defined (must have country, city and address 1)
                if(!empty($customer->address->country) && !empty($customer->address->city) && !empty($customer->address->line1)) {
                    $primary_address = $user->addresses()->create([
                        'address' => $customer->address->line1,
                        'address_2' => $customer->address->line2,
                        'country' => $customer->address->country,
                        'city' => $customer->address->city,
                        'zip_code' => $customer->address->postal_code,
                        'state' => $customer->address->state,
                        'phones' => [$customer->phone],
                        'is_primary' => true,
                        'is_billing' => true,
                    ]);
                }

                // Create shipping address, only if customer in stripe has it defined (must have country, city and address 1)
                if(!empty($customer->shipping->address->country) && !empty($customer->shipping->address->city) && !empty($customer->shipping->address->line1)) {
                    $shipping_address = $user->addresses()->create([
                        'address' => $customer->shipping->address->line1,
                        'address_2' => $customer->shipping->address->line2,
                        'country' => $customer->shipping->address->country,
                        'city' => $customer->shipping->address->city,
                        'zip_code' => $customer->shipping->address->postal_code,
                        'state' => $customer->shipping->address->state,
                        'phones' => [$customer->shipping->phone],
                        'is_primary' => false,
                        'is_billing' => false,
                    ]);
                }

                DB::commit();

                // Remember: created() event from UserObserver will be fired after transaction is comitted because of $afterCommit = true;
            } catch (\Exception $e) {
                DB::rollBack();
                http_response_code(400);
                die($e->getMessage());
            }


        }
    }

    // customer.updated
    public function whCustomerUpdated($event) {
        $customer = $event->data->object;

        $stripe_customer_id = $customer->id;

        $user = get_user_by_stripe_customer_id($stripe_customer_id);

        if(!empty($user)) {
            $user_subscriptions = $user->subscriptions()->active()->get();

            if($user_subscriptions->isNotEmpty()) {
                foreach($user_subscriptions as $subscription) {
                    if($subscription->isUsingStripe()) {
                        dispatch(function () use ($user, $subscription, $stripe_customer_id) {
                            $order = $subscription->order;
                            $order->setData(stripe_prefix('stripe_upcoming_invoice'), $this->getUpcomingInvoice($subscription));
                            $order->save();
                        });
                    }
                }
            }
        }
    }

    // checkout.session.completed
    public function whCheckoutSessionCompleted($event)
    {
        $session = $event->data->object;

        DB::beginTransaction();

        try {
            // Populate Order with data from stripe
            $order = Order::withoutGlobalScopes()->findOrFail($session->client_reference_id);
            $order->payment_status = $session->mode === 'payment' ? PaymentStatusEnum::paid()->value : PaymentStatusEnum::pending()->value;
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

            $order->mergeData([
                stripe_prefix('stripe_payment_mode') => $session->mode ?? null, // IMPORTANT: when mode is `subscription`, stripe_payment_intent_id is NOT SENT, because payment intent is related to future INVOICE not one time session checkout!
                stripe_prefix('stripe_subscription_id') => $session->subscription ?? null, // store subscription_id if any
            ]);

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


            // Loop through OrderItems and:
            // 1. For subscriptions: create subscription and relate model from order_item to it along with quantity and other models if multi-item subs are enabled
            // 2. Reduce stock of models related to order_items by desired quantity
            $subscription = null; // will be used only for `subscription` payment type

            if($session->mode === 'subscription') {
                // SUBSCRIPTION logic

                // If multiple subscriptions per user are not allowed, remove previous subscriptions and cancel them immediately on Stripe!
                if(!get_tenant_setting('multiple_subscriptions_enabled')) {
                    // $this->cancelStripeSubscriptions(user: $initiator); // Cancel all stripe-based subscriptions of $initiator
                    // $initiator->subscriptions()->forceDelete(); // delete all previous subscriptions
                }

                // Create Subscription
                $subscription = new UserSubscription();
                $subscription->user_id = $initiator->id;
                $subscription->order_id = $order->id;
                $subscription->payment_status = PaymentStatusEnum::pending()->value;
                $subscription->status = UserSubscriptionStatusEnum::inactive()->value;
                $subscription->data = [
                    $this->mode_prefix.'stripe_subscription_id' => $session->subscription ?? null, // store stripe_subscription_id
                ];
                $subscription->save();

            } else {
                // ONE-TIME PAYMENT logic
            }


            foreach($order->order_items as $index => $order_item) {
                // Break the loop after first order_item IF multi_item_subscription is not enabled!
                if(!get_tenant_setting('multi_item_subscription_enabled') && $index > 0) {
                    break;
                }

                $model = $order_item->subject; // get the Model from the order_item
                $qty = $order_item->quantity; // get the quantity of the order_item

                if($session->mode === 'subscription') {
                    // SUBSCRIPTION logic

                    if (!get_tenant_setting('multi_item_subscription_enabled')) {
                        // Associate $model from order_item and subscription and set quantity to 1
                        $subscription->items()->attach($model, [
                            'qty' => 1, // since multi-item subscription is disabled here, qty can only be 1!
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
                    } else {
                        // Associate $model from order_item and subscription and set quantity to $qty
                        $subscription->items()->attach($model, [
                            'qty' => $qty,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
                    }
                } else {
                    // ONE-TIME PAYMENT logic

                    // Reduce the stock quantity of an $model if the inventory is tracked and model has stocks trait
                    if (method_exists($model, 'stock') && $model->track_inventory) {
                        $serial_numbers = $model->reduceStock($qty);

                        // Serial Numbers only work for Simple Products.
                        // TODO: Make Product Variations support serial numbers!
                        if ($model->use_serial) {
                            $order_item->serial_numbers = $serial_numbers; // reduceStockBy returns serial numbers in array if $model uses serials
                        } else {
                            $order_item->serial_numbers = null;
                        }
                    }
                }
            }


            /*
            * Populate previously made ghost Invoice here because 'invoice.paid'  hook won't be sent for one-time payments!!!
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
                $invoice->payment_status = PaymentStatusEnum::paid()->value; // Change invoice status to paid when mode is 'payment'

                // TODO: How to align one-time payments invoice numbers with stripe if stripe doesn't create an invoice for one-time payment???
                $invoice->invoice_number = Invoice::generateInvoiceNumber($order->billing_first_name, $order->billing_last_name, $order->billing_company);
            } else if($session->mode === 'subscription') {
                if($invoice->payment_status !== PaymentStatusEnum::paid()->value) {
                    $invoice->payment_status = PaymentStatusEnum::pending()->value; // Change status to 'pending' because status will truly change on 'invoice.paid' webhook
                    $invoice->invoice_number = $invoice->invoice_number;
                }
            }

            $invoice->tax = $session->total_details->amount_tax / 100;

            $invoice->billing_first_name = $order->billing_first_name;
            $invoice->billing_last_name = $order->billing_last_name;
            $invoice->billing_company = $order->billing_company; // TODO: Get company name from invoice somehow...
            $invoice->billing_address = $order->billing_address;
            $invoice->billing_country = $order->billing_country;
            $invoice->billing_state = $order->billing_state;
            $invoice->billing_city = $order->billing_city;
            $invoice->billing_zip = $order->billing_zip;

            $invoice->setRealInvoiceNumber();

            // Take the info from stripe...
            $invoice->mergeData([
                stripe_prefix('stripe_payment_mode') => $session->mode ?? null,
                stripe_prefix('stripe_invoice_id') => null,
                stripe_prefix('stripe_hosted_invoice_url') =>null,
                stripe_prefix('stripe_invoice_pdf_url') => null,
                stripe_prefix('stripe_invoice_number') => null,
                stripe_prefix('stripe_customer_id') => $session->customer ?? '',
                stripe_prefix('stripe_payment_intent_id') => $session->payment_intent ?? '', // this will be null on all future automatic reccuring payments
                stripe_prefix('stripe_subscription_id') =>  $session->subscription ?? null,
                stripe_prefix('stripe_currency') => $session->currency ?? null,
            ]);

            if ($session->mode === 'payment') {
                // Append receipt_url to order and invoice (and get it through payment_intent)
                $pi = $this->stripe->paymentIntents->retrieve(
                    $session->payment_intent,
                    []
                );

                // Since it's a one-time payment, save receipt url to both Order and Invoice
                $invoice->setData(stripe_prefix('stripe_receipt_url'), $pi->charges->data[0]?->receipt_url ?? '');

                $order->setData(stripe_prefix('stripe_receipt_url'), $pi->charges->data[0]?->receipt_url ?? '');
                $order->saveQuietly();
            }

            $invoice->saveQuietly(); // there could be memory leaks if we use just save (no need for events right now)


            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            http_response_code(400);
            die(print_r($e));
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

    // invoice.created
    public function whInvoiceCreated($event)
    {
        $stripe_invoice = $event->data->object;
        $stripe_subscription_id = !empty($stripe_invoice->subscription ?? null) ? $stripe_invoice->subscription : -1;

        // Subscription billing reasons: 'subscription_create', 'subscription_cycle', 'subscription_update'
        // One-time payment billing reason: ''
        $stripe_billing_reason = $stripe_invoice->billing_reason;

        $stripe_subscription = $this->stripe->subscriptions->retrieve(
            $stripe_subscription_id,
            []
          );

        DB::beginTransaction();

        try {
            // IMPORTANT: Invoice `payment_status` MUST DEPEND ONLY ON Stripe invoice->paid or not paid
            $order = Order::withoutGlobalScopes()->findOrFail($stripe_subscription->metadata->order_id);

            // Add latest stripe invoice id to the Order meta (only if billing reasons are subscription create/cycle - because new order is not being created)
            if($stripe_billing_reason === 'subscription_create' || $stripe_billing_reason === 'subscription_cycle') {
                $order->setData(stripe_prefix('stripe_latest_invoice_id'), $stripe_invoice->id);
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

                    $invoice->setRealInvoiceNumber();

                    $invoice->mergeData([
                        stripe_prefix('stripe_invoice_id') => $stripe_invoice->id ?? '',
                        stripe_prefix('stripe_hosted_invoice_url') => $stripe_invoice->hosted_invoice_url ?? '',
                        stripe_prefix('stripe_invoice_pdf_url') => $stripe_invoice->invoice_pdf ?? '',
                        stripe_prefix('stripe_invoice_number') => $stripe_invoice->number ?? '',
                        stripe_prefix('stripe_customer_id') => $stripe_invoice->customer ?? '',
                        stripe_prefix('stripe_payment_intent_id') => $stripe_invoice->payment_intent ?? '',
                        stripe_prefix('stripe_subscription_id') => $stripe_subscription_id ?? '',
                        stripe_prefix('stripe_currency') => $stripe_invoice->currency ?? null,
                    ]);

                    if(!empty($stripe_invoice->payment_intent)) {
                        $pi = $this->stripe->paymentIntents->retrieve(
                            $stripe_invoice->payment_intent,
                            []
                        );

                        if(!empty($pi?->charges?->data[0]?->receipt_url ?? null)) {
                            $invoice->setData(stripe_prefix('stripe_receipt_url'), $pi->charges->data[0]?->receipt_url);
                        }
                    }

                    $invoice->save();

                    DB::commit();
                }

            } else if($stripe_billing_reason === 'subscription_cycle') {
                // Subscription is cycled
                // New order and invoice will be created in subscription.updated webhook
                //$this->createInvoice(order: $order, stripe_invoice: $stripe_invoice, stripe_subscription: $stripe_subscription);

                //DB::commit();
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
        set_time_limit(1000);

        $stripe_invoice = $event->data->object;
        $stripe_subscription_id = !empty($stripe_invoice->subscription ?? null) ? $stripe_invoice->subscription : -1;

        // Subscription billing reasons: 'subscription_create', 'subscription_cycle', 'subscription_update'
        // One-time payment billing reason: ''
        $stripe_billing_reason = $stripe_invoice->billing_reason;

        $stripe_subscription = $this->stripe->subscriptions->retrieve(
            $stripe_subscription_id,
            []
        );

        // Get previous subscription ids (our and stripe's) from stripe_subscription metadata, if any
        $previous_subscription_id = $stripe_subscription->metadata->previous_subscription_id ?? null;
        $previous_stripe_subscription_id = $stripe_subscription->metadata->previous_stripe_subscription_id ?? null;
        $previous_subscription = UserSubscription::find($previous_subscription_id);

        DB::beginTransaction();

        try {
            $order = Order::withoutGlobalScopes()->findOrFail($stripe_subscription->metadata->order_id);
            $subscription = $order->user_subscription()->withoutGlobalScopes()->first();

            if($stripe_billing_reason === 'subscription_create' || $stripe_billing_reason === 'subscription_cycle') {
                // Add latest stripe invoice id to the Order meta (only if billing reasons are subscription create/cycle - because new order is not being created)
                $order->setData(stripe_prefix('stripe_latest_invoice_id'), $stripe_invoice->id);
                $order->save();

                if($stripe_billing_reason === 'subscription_create') {
                    // This means that subscription is created for the first time
                    $invoice = $order->invoices()->withoutGlobalScopes()->firstOrFail();
                } else if($stripe_billing_reason === 'subscription_cycle') {
                    $invoice = $order->invoices()->withoutGlobalScopes()->get()->firstWhere('meta.'.$this->mode_prefix.'stripe_invoice_id', $stripe_invoice->id);
                }

                if (!empty($invoice)) {
                    $invoice->is_temp = false; // Make this Invoice real!!!
                    $invoice->payment_status = PaymentStatusEnum::paid()->value;

                    if(!empty($stripe_invoice->number ?? null)) {
                        $invoice->invoice_number = $stripe_invoice->number;
                    }

                    $invoice->mergeData([
                        stripe_prefix('stripe_invoice_paid') => $stripe_invoice->paid ?? true,
                        stripe_prefix('stripe_invoice_id') => $stripe_invoice->id ?? '',
                        stripe_prefix('stripe_hosted_invoice_url') => $stripe_invoice->hosted_invoice_url ?? '',
                        stripe_prefix('stripe_invoice_pdf_url') => $stripe_invoice->invoice_pdf ?? '',
                        stripe_prefix('stripe_invoice_number') => $stripe_invoice->number ?? '',
                        stripe_prefix('stripe_customer_id') => $stripe_invoice->customer ?? '',
                        stripe_prefix('stripe_payment_intent_id') => $stripe_invoice->payment_intent ?? '', // this will be null on all future automatic reccuring payments
                        stripe_prefix('stripe_subscription_id') => $stripe_subscription_id, // store subscription ID in invoice meta
                        stripe_prefix('stripe_currency') => $stripe_invoice->currency ?? null,
                    ]);

                    if(!empty($stripe_invoice->payment_intent)) {
                        $pi = $this->stripe->paymentIntents->retrieve(
                            $stripe_invoice->payment_intent,
                            []
                        );

                        if(!empty($pi?->charges?->data[0]?->receipt_url ?? null)) {
                            $invoice->setData(stripe_prefix('stripe_receipt_url'), $pi->charges->data[0]?->receipt_url ?? '');
                        }
                    }

                    $invoice->save();
                }

                // ***IMPORTANT: subscription `cycle` and `update` are moved to subscription.updated webhook
                // Keep in mind that some data is not accessible inside subsription.update (like invoice->number, sine subs_update happens beforeinvoice.paid on stripe for some reason...or at least that's a webhook order)
            }


            // We are sure that invoice is paid so we make user_subscription(s) active and paid too (even though they may already be active and paid as a result of subscription.updated webhook)!
            if (!empty($subscription)) {
                // If subscription has trial start/end (provided from checkout.session)
                if($stripe_subscription->status === 'trialing') {
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

                $subscription->saveQuietly();
            }

            DB::commit();
        } catch (\Throwable $e) {
            Log::error($e);
            DB::rollBack();
            http_response_code(400);
            die(print_r($e));
        }

        try {
            // Fire Subscription(s) "is created and paid" Event
            if($stripe_billing_reason === 'subscription_create') {
                do_action('invoice.paid.subscription_create', $subscription, $previous_subscription, $stripe_invoice);
            }
            // Fire Subscription(s) "is updated and paid" Event
            else if($stripe_billing_reason === 'subscription_update') {
                do_action('invoice.paid.subscription_update', $subscription, $previous_subscription, $stripe_invoice);
            }
            // Fire Subscription "is cycled and paid" Event
            else if($stripe_billing_reason === 'subscription_cycle') {
                do_action('invoice.paid.subscription_cycle', $subscription, $stripe_invoice);
            }
        } catch(\Throwable $e) {
            Log::error($e);
            die(print_r($e));
        }


        http_response_code(200);
        die();
    }

    // invoice.payment_failed
    public function whInvoicePaymentFailed($event)
    {
        $stripe_invoice = $event->data->object;
        $stripe_subscription_id = !empty($stripe_invoice->subscription ?? null) ? $stripe_invoice->subscription : -1;

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
            $subscription = $order->user_subscription()->withoutGlobalScopes()->get();

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
                $this->createInvoice(order: $order, stripe_invoice: $stripe_invoice, stripe_subscription: $stripe_subscription);

            } else if($stripe_billing_reason === 'subscription_update') {
                // Subscription is updated (downgraded, upgraded etc.)
                $this->createInvoice(order: $order, stripe_invoice: $stripe_invoice, stripe_subscription: $stripe_subscription);
            } else {
                // No idea...
            }

            // We are sure that invoice is NOT paid so we make user_subscription(s) inactive and unpaid too!
            if (!empty($subscription)) {
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
        $order_id = $stripe_subscription->metadata?->order_id ?? null;
        $invoice_id = $stripe_subscription->metadata?->invoice_id ?? null;
        $previous_subscription_id = $stripe_subscription->metadata?->previous_subscription_id ?? null;
        $previous_stripe_subscription_id = $stripe_subscription->metadata?->previous_stripe_subscription_id ?? null;
        $latest_stripe_invoice_id = $stripe_subscription->latest_invoice ?? null;

        try {
            if(empty($order_id) && empty($invoice_id)) {

                // This means that subscription is NOT created through checkout link from our app -> It's most probably created through Stripe directly!
                $latest_stripe_invoice = $this->stripe->invoices->retrieve(
                    $latest_stripe_invoice_id,
                    []
                );

                DB::beginTransaction();

                try {
                    // 1. Create Order and OrderItem(s)
                    $order = $this->createOrder(stripe_invoice: $latest_stripe_invoice, stripe_subscription: $stripe_subscription);

                    // 2. Create Invoice
                    $invoice = $this->createInvoice(order: $order, stripe_invoice: $latest_stripe_invoice, stripe_subscription: $stripe_subscription);

                    // 3. Create UserSubscription
                    if(!get_tenant_setting('multiple_subscriptions_enabled')) {
                        //$order->user->subscriptions()->forceDelete(); // Delete all subscriptions
                        // TODO: Cancel other subscriptions on Stripe here immediately!!!
                    }

                    if($stripe_subscription->status === 'trialing') {
                        $subscription_status = UserSubscriptionStatusEnum::trial()->value;
                        $subscription_payment_status = PaymentStatusEnum::unpaid()->value;
                    } else {
                        $subscription_status = $stripe_subscription->status === 'active' ? UserSubscriptionStatusEnum::active()->value : UserSubscriptionStatusEnum::inactive()->value;
                        $subscription_payment_status = ($latest_stripe_invoice->paid && $stripe_subscription->status === 'active') ? PaymentStatusEnum::paid()->value : PaymentStatusEnum::unpaid()->value;
                    }

                    $subscription = UserSubscription::create([
                        'user_id' => $order->user->id,
                        'order_id' => $order->id,
                        'payment_status' => $subscription_payment_status,
                        'status' => $subscription_status,
                        'start_date' => $stripe_subscription->current_period_start,
                        'end_date' => $stripe_subscription->current_period_end,
                        'data' => [
                            $this->mode_prefix.'stripe_subscription_id' => $stripe_subscription->id,
                            $this->mode_prefix .'stripe_latest_invoice_id' => $latest_stripe_invoice->id,
                        ],
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' =>  date('Y-m-d H:i:s')
                    ]);

                    if (!get_tenant_setting('multi_item_subscription_enabled')) {
                        // Associate $model from subscription set quantity to 1
                        $model = get_model_by_stripe_product_id($stripe_subscription->plan->product);

                        $subscription->items()->attach($model, ['qty' => 1]); // since multi-item subscription is disabled here, qty can only be 1!
                    } else {
                        foreach($order->order_items as $order_item) {
                            // Associate subject from order_item to subscription and set quantity to $order_item->quantity
                            $subscription->items()->attach($order_item->subject, ['qty' => $order_item->quantity]);
                        }
                    }

                    // 4. Hook to direct subscription creation
                    $order->load('user_subscription');
                    $user_subscription = $order->user_subscription;


                    DB::commit();
                } catch(\Throwable $e) {
                    DB::rollback();
                    http_response_code(400);
                    die(print_r($e));
                }

                // 5. Update stripe subscription with metadata needed for further actions (cycle/updat etc.)
                // IMPORTANT - This fires subscription.update, but it'll have only metadata in previous_attributes property!!! We should do basically...nothing on this webhook...
                $this->stripe->subscriptions->update(
                    $stripe_subscription->id,
                    [
                        'metadata' => [
                            'user_subscription_id' => $user_subscription->id,
                            'order_id' => $order->id,
                            'invoice_id' => $invoice->id,
                            'latest_invoice_id' => $invoice->id,
                            'user_id' => $order->user->id,
                            'shop_id' => $order->shop->id,
                        ]
                    ]
                );

                do_action('stripe.webhook.subscriptions.created_from_stripe', $user_subscription, $latest_stripe_invoice);

                die();
            }

            $order = Order::withoutGlobalScopes()->findOrFail($order_id);
            $subscription = $order->user_subscription;

            if (!empty($subscription)) {
                $subscription->start_date = $stripe_subscription->current_period_start;
                $subscription->end_date = $stripe_subscription->current_period_end;

                $subscription->setData(stripe_prefix('stripe_latest_invoice_id'), $stripe_subscription->latest_invoice ?? null);

                // Only change status and payment_status of subscription and order if stripe subscription is in Trial mode
                if($stripe_subscription->status === 'trialing') {
                    $subscription->status = UserSubscriptionStatusEnum::trial()->value;
                    $subscription->payment_status = PaymentStatusEnum::unpaid()->value;

                    $order->payment_status = PaymentStatusEnum::unpaid()->value;
                    $order->save();
                }

                $subscription->save();


                // Deal with previous subscription if there's any
                $previous_subscription = UserSubscription::find($previous_subscription_id);

                // Status of subscription in this webhook is always: "status": "incomplete" or "trialing"
                // So we should just update start and end date and not change status and payment_status IF subscription is not 'trialing'!
                // These will be changed in subscription.updated if it's fired from Stripe

                do_action('stripe.webhook.subscriptions.created', $subscription, $previous_subscription);
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
        \Stripe\Stripe::setMaxNetworkRetries(2);

        $previous_attributes = $event->data->previous_attributes ?? (object) [];
        $stripe_subscription = $event->data->object;
        $stripe_subscription_id = $stripe_subscription->id;
        $order_id = $stripe_subscription->metadata->order_id ?? -1;
        $new_metadata = null;

        $latest_invoice_id = $stripe_subscription->latest_invoice ?? null;
        $stripe_invoice = $this->stripe->invoices->retrieve(
            $latest_invoice_id,
            []
        );
        $stripe_billing_reason = $stripe_invoice->billing_reason;

        try {
            $order = Order::withoutGlobalScopes()->findOrFail($order_id);
            $subscription = $order->user_subscription;

            if (!empty($subscription)) {
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

                    $subscription->setData(stripe_prefix('stripe_latest_invoice_id'), $latest_invoice_id);

                    // Determine if subscription is cycled or upgraded/downgraded
                    if($stripe_billing_reason === 'subscription_cycle') {
                        // This means that subscription is cycled - just create a new invoice
                        $new_invoice = $this->createInvoice(order: $order, stripe_invoice: $stripe_invoice, stripe_subscription: $stripe_subscription);

                        // Update latest_invoice_id in stripe subscription metadata
                        $new_metadata = $stripe_subscription->metadata;
                        $new_metadata->latest_invoice_id = $new_invoice->id;
                    } else if(($stripe_billing_reason === 'subscription_update' || $stripe_billing_reason === 'subscription_create') && !empty($previous_attributes?->plan?->id ?? null)) {
                        // MAY HAPPEN THAT billing_reason is subscription_create!!!

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

                        if(get_tenant_setting('multi_item_subscription_enabled')) {
                            $should_proceed = false; // TODO: This must work according to multi-plan purchase
                        } else {
                            $should_proceed = (empty($existing_order) && empty($existing_invoice)) || (($stripe_subscription?->plan?->id ?? 1) !== ($previous_attributes->plan->id ?? 1));
                        }

                        if($should_proceed) {
                            // Subscription is updated (downgraded, upgraded, interval changed etc.):
                            // 1. Create a new Order
                            // 2. Create a new Invoice
                            // 3. Change order_id of subscriptions on our end
                            // 4. Change order_id and latest_invoice_id in metadata of subscription on Stripe end

                            DB::beginTransaction();

                            try {
                                $new_order = $this->createOrder(stripe_invoice: $stripe_invoice, stripe_subscription: $stripe_subscription);

                                // Update the Order ID of the subscription with $new_order
                                $subscription->order_id = $new_order->id;

                                // Add Last Order ID to Stripe subscription metadata
                                $new_metadata = $stripe_subscription->metadata;
                                $new_metadata->order_id = $new_order->id;

                                // if($stripe_subscription->status != 'trialing') {
                                $new_invoice = $this->createInvoice(order: $new_order, stripe_invoice: $stripe_invoice, stripe_subscription: $stripe_subscription);

                                // Add latest Invoice ID on our end to Stripe subscription metadata
                                $new_metadata->latest_invoice_id = $new_invoice->id;

                                // Check if subscription was upgraded/downgraded
                                if(count($previous_attributes?->items?->data ?? []) > 0) {
                                    $subscription->items()->detach(); // remove all relations between previous plans/models and user_subscription

                                    if(get_tenant_setting('multi_item_subscription_enabled')) {
                                        // Upgrade/Downgrade when multiple subsriptions feature is enabled

                                        // Loop through stripe subscription line items and make relations between subscription and plans
                                        foreach($stripe_subscription->items->data as $stripe_line_item) {
                                            $model = get_model_by_stripe_product_id($stripe_line_item->price->product);

                                            if(!empty($model)) {
                                                $subscription->items()->attach($model, ['qty' => $stripe_line_item->quantity]);
                                            } else {
                                                Log::error('Could not update subscription relation because one of the the new Plans was not found through `stripe_product_id` CoreMeta');
                                            }
                                        }
                                    } else {
                                        // Upgrade/Downgrade when multi-plan is NOT enabled

                                        $stripe_new_plan = $stripe_subscription?->items?->data[0]; // take only the first product
                                        $new_plan = get_model_by_stripe_product_id($stripe_new_plan->plan->product);

                                        if(!empty($new_plan)) {
                                            $subscription->items()->attach($new_plan, ['qty' => 1]); // quantity is always 1 when multi-items subscriptions are dsabled
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

            do_action('stripe.webhook.subscriptions.updated', $subscription, null, $stripe_invoice, $previous_attributes);
        } catch (\Exception $e) {
            http_response_code(400);
            die(print_r($e));
        }

        if(!empty($new_metadata)) {
            // Update Stripe subscription metadata
            // IMPORTANT - This fires another subscripion.update!!! Prevent any change like this in IF above
            $this->stripe->subscriptions->update(
                $stripe_subscription->id,
                ['metadata' => $new_metadata->toArray()]
            );
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
