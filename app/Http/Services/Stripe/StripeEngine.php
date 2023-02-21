<?php

namespace App\Http\Services\Stripe;

use DB;
use FX;
use WE;
use Log;
use Uuid;
use Cache;
use Carbon;
use Stripe;
use Session;
use Payments;
use App\Models\Plan;
use App\Models\User;
use App\Models\Order;
use App\Models\Address;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\CoreMeta;
use App\Models\OrderItem;
use App\Models\Ownership;
use App\Enums\UserTypeEnum;
use App\Models\WeBaseModel;
use App\Enums\OrderTypeEnum;
use App\Facades\CartService;
use Illuminate\Http\Request;
use App\Enums\UserEntityEnum;
use App\Enums\PaymentStatusEnum;
use App\Models\UserSubscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Enums\UserSubscriptionStatusEnum;
use App\Models\UserSubscriptionRelationship;
use Illuminate\Database\Eloquent\Collection;
use Mpociot\VatCalculator\Facades\VatCalculator;
use Stancl\Tenancy\Resolvers\DomainTenantResolver;
use App\Notifications\Invoice\InvoicePaymentFailed;
use Illuminate\Support\Traits\ForwardsCalls;

class StripeEngine
{
    use ForwardsCalls;

    public $stripe = null;
    public $mode_prefix = null;
    public $stripe_webhooks = null;

    public $subscription_billing_reasons = ['subscription_create', 'subscription_update', 'subscription_cycle'];
    public $unsupported_shipping_countries = ['AS', 'CX', 'CC', 'CU', 'HM', 'IR', 'KP', 'MH', 'FM', 'NF', 'MP', 'PW', 'SD', 'SY', 'UM', 'VI'];
    public $supported_shipping_countries = []; // TODO: Get Stripe available countries list!!!!


    public function __construct()
    {
        \Stripe\Stripe::setMaxNetworkRetries(2);

        if(Payments::isStripeEnabled()) {
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
        }
        
        // Set supported shipping countries
        $this->supported_shipping_countries = array_values(array_diff(['LT', 'RS', 'DE', 'GB', 'ES', 'FR', 'US'], $this->unsupported_shipping_countries));        

        // Set StripeWebhooks object
        $this->stripe_webhooks = new StripeWebhooks();
    }

    public function __call($method, $arguments)
    {
        // Forward all non-existing functions to StripeWebhooks object
        return $this->forwardCallTo(
            $this->stripe_webhooks, $method, $arguments
        );
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

        $stripe_product_id = $model->getStripeProductID();

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
            } else {
                $params['address'] = [
                    'city' => $me->getUserMeta('address_city'),
                    'country' => $me->getUserMeta('address_country'),
                    'state' => $me->getUserMeta('address_state'),
                    'postal_code' => $me->getUserMeta('address_postal_code'),
                    'line1' => $me->getUserMeta('address_line'),
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
            } else {
                $params['address'] = [
                    'city' => $me->getUserMeta('address_city'),
                    'country' => $me->getUserMeta('address_country'),
                    'state' => $me->getUserMeta('address_state'),
                    'postal_code' => $me->getUserMeta('address_postal_code'),
                    'line1' => $me->getUserMeta('address_line'),
                ];
            }

            $stripe_customer = $this->stripe->customers->create($params);

            $this->updateStripeCustomerTax($me);
        }

        $me->saveCoreMeta($stripe_customer_id_key, $stripe_customer->id);

        return $stripe_customer;
    }

    public function updateStripeCustomerInfo($user = null) {
        $user = !empty($user) && $user instanceof \App\Models\User ? $user : null;

        if(!empty($user)) {
            dispatch(function () use ($user) {
                $stripe_customer_id = $user->getCoreMeta(stripe_prefix('stripe_customer_id'));

                try {
                    $stripe_customer = $this->stripe->customers->retrieve(
                        $stripe_customer_id,
                        []
                    );
                    $stripe_customer_array = $stripe_customer->toArray();
        
                    if ($stripe_customer->deleted ?? null) {
                        throw new \Exception('Customer is deleted in Stripe!');
                    }
    
                    // TODO: Make this also work through Address model, not CoreMeta (if possible)
                    $name = ($user->entity === 'company') ? $user->getUserMeta('company_name') : $user->name.' '.$user->surname;

                    $this->stripe->customers->update(
                        $stripe_customer_id,
                        [
                            'name' => $name,
                            'address' => [
                                'city' => $user->getUserMeta('address_city'),
                                'country' => $user->getUserMeta('address_country'),
                                'line1' => $user->getUserMeta('address_line'),
                                'line2' => $user->getUserMeta('address_line_2'),
                                'postal_code' => $user->getUserMeta('address_postal_code'),
                                'state' => $user->getUserMeta('address_state'),
                            ],
                            'phone' => $user->phone,
                        ]
                    );
                } catch (\Exception $e) {
                    Log::error('Could not update Stripe customer (id: '.$stripe_customer_id.') billing address. Error: '.$e->getMessage());
                } 
            });
        }
    }

    public function updateStripeCustomerTax($user = null, $update_tax_exempt_for_individual = false) {
        // Dispatch a job to update customer Tax data in stripe

        $user = !empty($user) && $user instanceof \App\Models\User ? $user : auth()->user();

        dispatch(function () use ($user, $update_tax_exempt_for_individual) {
            $stripe_customer_id_key = stripe_prefix('stripe_customer_id');
            $stripe_customer_id = $user->getCoreMeta($stripe_customer_id_key);
    
            try {
                $stripe_customer = $this->stripe->customers->retrieve(
                    $stripe_customer_id,
                    []
                );
                $stripe_customer_array = $stripe_customer->toArray();
    
                if ($stripe_customer->deleted ?? null) {
                    throw new \Exception();
                }
                
                // If $customer is company, add TaxID if applicable
                if($user->entity === 'company') {
                    $company_country = $user->getUserMeta('address_country');
                    $company_vat = $user->getUserMeta('company_vat');
                    $stripe_params = [];
                    
                    if(!empty($company_country) && !empty(\Countries::get(code: $company_country))) {
                        $stripe_params['address'] = array_merge($stripe_customer_array['address'], [
                            'country' => $company_country
                        ]);
                        
                        if(\Countries::isEU($company_country)) {
                            try {
                                $validVAT = VatCalculator::isValidVATNumber($company_vat);
                                $stripe_vat = $company_vat;
        
                                if($validVAT) {
                                    if($company_country === 'LT') {
                                        $stripe_params['tax_exempt'] = 'none';
                                    } else {
                                        // Company which has a valid VAT number
                                        $stripe_params['tax_exempt'] = 'reverse';
                                    }
                                    
                                    try {
                                        $this->stripe->customers->createTaxId(
                                            $stripe_customer->id,
                                            ['type' => 'eu_vat', 'value' => $stripe_vat]
                                        );
                                    } catch(\Exception $e) {
                                        Log::info($e);
                                    }
                                } else {
                                    // Company which doesn't have a VAT number
                                    $stripe_params['tax_exempt'] = 'none';
                                }
                            } catch (VATCheckUnavailableException $e) {
                                // The VAT check API is unavailable...
                                Log::warning($e);
                            }
                        } else {
                            // Company outside of EU - exempt of tax
                            $stripe_params['tax_exempt'] = 'exempt';
                        }
                        
                        $this->stripe->customers->update(
                            $stripe_customer->id,
                            $stripe_params
                        );
                    }
                } else {
                    
                    // Individuals - Stripe checkout will decide it
                    $customer_country = $stripe_customer?->address?->country ?? null;

                    if($update_tax_exempt_for_individual && !empty($customer_country) && !empty(\Countries::get(code: $customer_country))) {
                        
                        if(\Countries::isEU($customer_country)) {
                            $stripe_params['tax_exempt'] = 'none';
                        } else {
                            $stripe_params['tax_exempt'] = 'exempt';
                        }
                        
                        // IMPORTANT: In order to take tax_exempt into consideration, we need to remove all previously added stripe TaxIDs for this user (if any)
                        $previous_tax_ids = $this->stripe->customers->allTaxIds(
                            $stripe_customer->id,
                            ['limit' => 100]
                        );
    
                        if(!empty($previous_tax_ids->data)) {
                            foreach($previous_tax_ids->data as $tax_id) {
                                // Remove previous taxIDs
                                $this->stripe->customers->deleteTaxId(
                                    $stripe_customer->id,
                                    $tax_id->id,
                                    []
                                );
                            }
                        }

                        $this->stripe->customers->update(
                            $stripe_customer->id,
                            $stripe_params
                        );
                        
                    }
                }
            } catch (\Exception $e) {
                // Commenting out for fixing - duplicate customer acount in stripe
                // $this->createStripeCustomer($user);
            } 
        });
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
                'subscription_billing_cycle_anchor' => $cycle_anchor,
                'automatic_tax' => ['enabled' => Payments::stripe()->stripe_automatic_tax_enabled === true ? true : false],
            ];

            if(Payments::stripe()->stripe_prorations_enabled) {
                $params = array_merge($params, [
                    'subscription' => $user_subscription->getStripeSubscriptionID(),
                    'subscription_proration_date' => $proration_date,
                    'subscription_trial_end' => $cycle_anchor,
                ]);
            }

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
                'automatic_tax' => ['enabled' => Payments::stripe()->stripe_automatic_tax_enabled === true ? true : false],
            ];

            if(Payments::stripe()->stripe_prorations_enabled) {
                $params = array_merge($params, [
                    'subscription' => auth()->user()->subscriptions->first()->getStripeSubscriptionID(),
                    'subscription_proration_behavior' => 'create_prorations',
                    'subscription_proration_date' => time(),
                    'subscription_trial_end' => 'now',
                ]);

                // Get subscription
                $stripe_subscription = $this->stripe->subscriptions->retrieve(
                    auth()->user()->subscriptions->first()->getStripeSubscriptionID(),
                    []
                );

                // If current subscription is active, take the previous sub. items and push them into cart_items with 'deleted' flag
                if(auth()->user()->subscriptions->first()->isActive()) {
                    $previous_subscription_item_id = $stripe_subscription->items->data[0]->id;

                    if(!empty($stripe_subscription->items->data)) {
                        foreach($stripe_subscription->items->data as $stripe_subscription_item) {
                            if(!empty($stripe_subscription_item->id)) {
                                $cart_items[] = [
                                    'id' => $previous_subscription_item_id,
                                    'deleted' => true
                                ];
                            }
                        }
                    }
                } else {
                    // If current subscription is NOT active, unset the subscription property from params
                    unset($params['subscription']);
                    unset($params['subscription_trial_end']);
                    unset($params['subscription_proration_date']);
                }
            }

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
                        'enabled' => get_tenant_setting('multi_item_subscription_enabled') === true ? false : false, // TODO: Remember to fix this later
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
            $orderAndInvoice = $this->createTempOrderAndInvoice(line_items: $order_line_items, interval: $interval, mode: 'subscription');
            $order = $orderAndInvoice['order'];
            $invoice = $orderAndInvoice['invoice'];
            $subscription = $orderAndInvoice['subscription'];

            // Start defining Stripe Checkout Session params
            $stripe_args = [
                'line_items' => $stripe_line_items,
                'mode' => 'subscription',
                'allow_promotion_codes' => true,
                'billing_address_collection' => 'auto',
                'client_reference_id' => $order->id,
                'metadata' => [
                    'order_id' => $order->id,
                    'invoice_id' => $invoice->id,
                    'subscription_id' => $subscription->id,
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
                    'enabled' => false,
                ],
                'subscription_data' => [
                    'metadata' => [
                        'order_id' => $order->id,
                        'invoice_id' => $invoice->id,
                        'subscription_id' => $subscription->id,
                        'user_id' => $order->user_id,
                        'shop_id' => $order->shop_id,
                        'previous_subscription_id' => $previous_subscription?->id ?? '',
                        'previous_stripe_subscription_id' => $previous_subscription?->getData(stripe_prefix('stripe_subscription_id')) ?? '',
                        'items_to_remove' => [], // TODO: This should be consisted of array of ["subject_id" => xx, "subject_type" => "App\Models\XXX"]
                    ],
                ],
            ];

            // If plans trial mode is enabled
            $trial_days_left = 0;

            if(get_tenant_setting('plans_trial_mode') && !empty(get_tenant_setting('plans_trial_duration'))) {
                $started_trials = collect(auth()->user()->getUserMeta('started_trials_on', []));
                $trial_data = $started_trials->firstWhere('shop_id', $order->shop_id);

                if(!empty($trial_data) && !empty($trial_data['started_on'] ?? null)) {
                    // This user already started trial for the given shop before
                    try {
                        $trial_days_left = get_tenant_setting('plans_trial_duration') - \Carbon::createFromTimestamp($trial_data['started_on'])->diffInDays(\Carbon::now());

                        if($trial_days_left > 0) {
                            // Apply trial if there are any days left...
                            $stripe_args['subscription_data']['trial_period_days'] = (int) $trial_days_left;
                        }
                    } catch(\Throwable $e) {
                        // $stripe_args['subscription_data']['trial_period_days'] = get_tenant_setting('plans_trial_duration');
                        Log::error($e->getMessage());
                    }
                } else {
                    // This user DID NOT start trial for the given shop before - USE FULL trial duration from app settings
                    $stripe_args['subscription_data']['trial_period_days'] = get_tenant_setting('plans_trial_duration');
                }
            }

            // Stripe Prorations or not
            if(Payments::stripe()->stripe_prorations_enabled) {
                
            } else {
                // If there is a previous subscription, check if total price of current temp-subscription has lower or same price as previous subscription
                $one_time_stripe_coupon_code = null;

                if($trial_days_left <= 0 && !empty($previous_subscription) && $subscription->getTotalPrice(format: false) <= $previous_subscription->getTotalPrice(format: false)) {
                    // Create a downgrade with 100% discount for first month (like a partial proration)
                    // IMPORTANT: We can do this only bu applying one-time custom coupon code with duration of `once`
                    $one_time_stripe_coupon_code = $this->stripe->coupons->create([
                        'percent_off' => 100,
                        'duration' => 'once',
                        'max_redemptions' => 1,
                        'name' => 'downgrade-'.substr(str_shuffle('abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789'),0,28),
                        'redeem_by' => \Carbon::now()->addMinutes(10)->timestamp
                    ]);

                    if(!empty($one_time_stripe_coupon_code) && isset($one_time_stripe_coupon_code->id)) {
                        $stripe_args['discounts'] = [
                            [
                                'coupon' => $one_time_stripe_coupon_code->id,
                            ]
                        ];

                        unset($stripe_args['allow_promotion_codes']);
                    }
                    
                }
            }

            if (!empty(auth()->user())) {
                // Create Stripe customer if it doesn't exist
                $stripe_customer = $this->createStripeCustomer();
                $stripe_args['customer'] = $stripe_customer->id;

                $stripe_args['customer_update'] = [
                    'name' => 'never',
                    'address' => 'never',
                    'shipping' => 'never',
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

    // DEPRECATED FUNCTION
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
            $orderAndInvoice = $this->createTempOrderAndInvoice(line_items: $model, qty: $qty, interval: $interval, mode: $model->isSubscribable() ? 'subscription' : 'payment');
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
                        'enabled' => get_tenant_setting('multi_item_subscription_enabled') === true ? false : false,
                        // 'minimum' => 0,
                        // 'maximum' => 99
                    ]
                ]
            ],
            'mode' => $model->isSubscribable() ? 'subscription' : 'payment',
            'allow_promotion_codes' => true,
            'tax_id_collection' => [
                'enabled' => false,
            ],
            'billing_address_collection' => 'auto',
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
                'address' => 'never',
                'shipping' => 'never',
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

    protected function createTempOrderAndInvoice($line_items, $qty = null, $interval = 'month', $mode = 'subscription')
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
                $order->billing_first_name = auth()->user()->name;
                $order->billing_last_name = auth()->user()->surname;
                $order->billing_address = auth()->user()->getUserMeta('address_line');
                $order->billing_country = auth()->user()->getUserMeta('address_country');
                $order->billing_state = auth()->user()->getUserMeta('address_state');
                $order->billing_city = auth()->user()->getUserMeta('address_city');
                $order->billing_zip = auth()->user()->getUserMeta('address_postal_code');
            } else {
                $order->billing_first_name = '';
                $order->billing_last_name = '';
                $order->billing_address = '';
                $order->billing_country = '';
                $order->billing_state = '';
                $order->billing_city = '';
                $order->billing_zip = '';
            }

            
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

            if (Auth::check()) {
                // If User is logged-in, add customer/user data to invoice
                $user = auth()->user();
                
                if($user->entity === 'company') {
                    $invoice->billing_company = $user->getUserMeta('company_name');

                    $invoice->mergeData([
                        'customer' => [
                            'entity' => $user->entity,
                            'billing_country' => $user->getUserMeta('address_country'),
                            'vat' => $user->getUserMeta('company_vat'),
                            'company_registration_number' => $user->getUserMeta('company_registration_number'),
                            'company_name' => $user->getUserMeta('company_name'),
                        ]
                    ]);
                } else {
                    $invoice->mergeData([
                        'customer' => [
                            'entity' => $user->entity,
                            'billing_country' => $user->getUserMeta('address_country'),
                        ]
                    ]);
                }
                
            }
            

            $invoice->saveQuietly(); // there could be memory leaks if we use just save()

            if($mode === 'subscription') {
                // SUBSCRIPTION logic

                // If multiple subscriptions per user are not allowed, remove previous subscriptions and cancel them immediately on Stripe!
                if(!get_tenant_setting('multiple_subscriptions_enabled')) {
                    // $this->cancelStripeSubscriptions(user: $initiator); // Cancel all stripe-based subscriptions of $initiator
                    // $initiator->subscriptions()->forceDelete(); // delete all previous subscriptions
                }

                // Create Subscription
                $subscription = new UserSubscription();
                $subscription->is_temp = true;
                $subscription->user_id = $order->user_id;
                $subscription->order_id = $order->id;
                $subscription->payment_status = PaymentStatusEnum::pending()->value;
                $subscription->status = UserSubscriptionStatusEnum::inactive()->value;
                $subscription->saveQuietly();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            // TODO: Think about fallback or some error page to notify user that there's an error on Order creation just before StripeCheckout redirect.
            dd($e);
        }

        return [
            'order' => $order->load('order_items'),
            'invoice' => $invoice,
            'subscription' => isset($subscription) ? $subscription : null,
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
        $user = get_user_by_stripe_customer_id($stripe_subscription->customer);

        if(empty($stripe_subscription?->metadata?->order_id ?? null)) {
            // This means that webhook which uses this action originates from Stripe directly and not from our system!
            // (We always supply metadata if checkout process goes through WeSaaS)
            // $user = get_user_by_stripe_customer_id($stripe_subscription->customer);

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
        // $order->billing_first_name = $first_name;
        // $order->billing_last_name = $last_name;
        $order->billing_first_name = $user->name;
        $order->billing_last_name = $user->surname;
        $order->billing_address = $user->getUserMeta('address_line');
        $order->billing_country = $user->getUserMeta('address_country');
        $order->billing_state = $user->getUserMeta('address_state');
        $order->billing_city = $user->getUserMeta('address_city');
        $order->billing_zip = $user->getUserMeta('address_postal_code');
        // $order->billing_address = $stripe_invoice->customer_address->line1;
        // $order->billing_country = $stripe_invoice->customer_address->country;
        // $order->billing_state = $stripe_invoice->customer_address->state;
        // $order->billing_city = $stripe_invoice->customer_address->city;
        // $order->billing_zip = $stripe_invoice->customer_address->postal_code;
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

        
        $user = User::findOrFail($order->user_id);

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

            $order->billing_first_name = $user->name;
            $order->billing_last_name = $user->surname;
            $order->billing_address = $user->getUserMeta('address_line');
            $order->billing_country = $user->getUserMeta('address_country');
            $order->billing_state = $user->getUserMeta('address_state');
            $order->billing_city = $user->getUserMeta('address_city');
            $order->billing_zip = $user->getUserMeta('address_postal_code');

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

        $invoice->mergeData([
            stripe_prefix('stripe_invoice_id') => $stripe_invoice->id ?? '',
            stripe_prefix('stripe_hosted_invoice_url') => $stripe_invoice->hosted_invoice_url ?? '',
            stripe_prefix('stripe_invoice_pdf_url') =>  $stripe_invoice->invoice_pdf ?? '',
            stripe_prefix('stripe_invoice_number') => $stripe_invoice->number ?? '',
            stripe_prefix('stripe_customer_id') => $stripe_invoice->customer ?? '',
            stripe_prefix('stripe_payment_intent_id') => $stripe_invoice->payment_intent ?? '', // this will be null on all future automatic reccuring payments
            stripe_prefix('stripe_subscription_id') => $stripe_subscription->id, // store subscription ID in invoice meta
            stripe_prefix('stripe_currency') => $stripe_invoice->currency ?? null,
            stripe_prefix('stripe_billing_reason') => $stripe_invoice->billing_reason ?? '',
            stripe_prefix('stripe_invoice_data') => $stripe_invoice->toArray(),
        ]);


        if($user->entity === 'company') {
            // Update billing_company with current user's company_name meta
            $invoice->billing_company = $user->getUserMeta('company_name');

            $invoice->mergeData([
                'customer' => [
                    'entity' => $user->entity,
                    'billing_country' => $user->getUserMeta('address_country'), //$stripe_invoice->customer_address->country,
                    'vat' => $user->getUserMeta('company_vat'),
                    'company_registration_number' => $user->getUserMeta('company_registration_number'),
                    'company_name' => $user->getUserMeta('company_name'),
                ]
            ]);
        } else {
            $invoice->mergeData([
                'customer' => [
                    'entity' => $user->entity,
                    'billing_country' => $user->getUserMeta('address_country'), //$stripe_invoice->customer_address->country,
                ]
            ]);
        }

        // On subscription_cycle, this is probably empty, but let it be just in case
        if(!empty($stripe_invoice->payment_intent ?? null)) {
            $pi = $this->stripe->paymentIntents->retrieve(
                $stripe_invoice->payment_intent,
                []
            );

            if(!empty($pi?->charges?->data[0]?->receipt_url ?? null)) {
                $invoice->setData(stripe_prefix('stripe_receipt_url'), $pi->charges->data[0]?->receipt_url ?? null, null);
            }
        }
        
        $invoice->save();

        $invoice->setRealInvoiceNumber();

        return $invoice;
    }
}