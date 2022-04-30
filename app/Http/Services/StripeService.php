<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Facades\CartService;
use App\Enums\OrderTypeEnum;
use App\Enums\PaymentStatusEnum;
use App\Enums\UserSubscriptionStatusEnum;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Plan;
use App\Models\UserSubscription;
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
use Stancl\Tenancy\Resolvers\DomainTenantResolver;

class StripeService
{
    public $stripe = null;
    public $mode_prefix = null;
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
        $stripe_id = $model->core_meta->where('key', '=', $this->mode_prefix.'stripe_product_id')->first();

        if (empty($stripe_id)) {
            //Insert Stripe product
            $this->createStripeProduct($model);
        } else {
            // Update Stripe product
            $this->updateStripeProduct($model, $stripe_id);
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
            $description = $model->description;
            if (empty($description)) {
                $description = $model->name;
            }
        }

        try {
            // Create Stripe Product
            $stripe_product = $this->stripe->products->create([
                'id' => $this->generateStripeProductID($model),
                'name' => $model->name,
                'active' => true,
                // 'livemode' => false, // TODO: Make it true in Production
                'description' => $description,
                'images' => [$model->getThumbnail(['w' => 500])],
                'shippable' => $model->isShippable(),
                // 'tax_code' => '',
                'url' => $model->getPermalink(),
                'unit_label' => substr($model?->unit ?? 'pc', 0, 12),
                'metadata' => []
            ]);
        } catch (\Exception $e) {
            // This means that Product under $model->id already exists, BUT FOR SOME REASON tenant doesn't have the proper CoreMeta key.
            // 1. Get Stripe Product
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

    protected function updateStripeProduct($model, $stripe_id)
    {
        return null;
    }

    protected function createStripePrice($model, $stripe_product_id = null)
    {
        // Get stripe product iD
        if (empty($stripe_product_id)) {
            $stripe_product_id = $model->core_meta()->where('key', '=', $this->mode_prefix . 'stripe_product_id')->first()?->value ?? null;
        }

        // Create reccuring price if $model is Plan or a Subscription Product
        if ($model->isSubscribable()) {
            $args = [
                'unit_amount' => $model->getTotalPrice() * 100, // TODO: Is it Total, Base, or Subtotal, Original etc.???
                'currency' => strtolower($model->base_currency),
                'product' => $stripe_product_id,
                'recurring' => [
                    "interval" => "month", // TODO: Can be 'year'
                    "interval_count" => 1,
                    "usage_type" => "licensed"
                ]
            ];
        } else {
            // Create a new price and attach it to stripe product ID
            $args = [
                'unit_amount' => $model->getTotalPrice() * 100, // TODO: Is it Total, Base, or Subtotal, Original etc.???
                'currency' => strtolower($model->base_currency),
                'product' => $stripe_product_id,
            ];
        }

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

    protected function createStripeCustomer()
    {
        $me = auth()->user();
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

    public function createCheckoutLink($model, $qty = 1, $preview = false, $abandoned_order_id = null)
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
                    'quantity' => $qty,
                ]
            ],
            'mode' => $model->isSubscribable() ? 'subscription' : 'payment',
            'billing_address_collection' => 'required',
            'client_reference_id' => $is_preview ? 'preview' : $order->id,
            'metadata' => [
                'order_id' => $is_preview ? 'preview' : $order->id,
                'invoice_id' => $is_preview ? 'preview' : $invoice->id,
            ],
            'subscription_data' => [
                'metadata' => [
                    'order_id' => $is_preview ? 'preview' : $order->id,
                    'invoice_id' => $is_preview ? 'preview' : $invoice->id,
                ],
            ],
            'success_url' => route('checkout.order.received', ['id' => $is_preview ? 'preview' : $order->id]),
            'cancel_url' => route('checkout.order.received', ['id' => $is_preview ? 'preview' : $order->id]),
            'automatic_tax' => [
                'enabled' => false,
            ],
            'tax_id_collection' => [
                'enabled' => true,
            ],
            'customer_update' => [
                'name' => 'auto',
                'address' => 'auto',
                'shipping' => 'auto',
            ],
        ];

        // Check if Modal is digital or not, and based on that display or hide Stripe shipping options
        if ($model->isShippable()) {
            // If $model is not digital (like standard non-digital product)
            $stripe_args['shipping_address_collection'] = [
                // TODO: Put all allowed shipping countries two-letter codes here. Keep in mind there should be two allowed_shipping_countries settings. One in TenantSettings and other in ShopSettings. ShpoSettings one is used when app is a marketplace!
                'allowed_countries' => $this->supported_shipping_countries // this is test for now - get ALL codes
            ];
        }

        if (auth()->user()) {
            // Create Stripe customer if it doesn't exist
            $stripe_customer = $this->createStripeCustomer();
            $stripe_args['customer'] = $stripe_customer->id;
        }

        // Create a Stripe Checkout Link
        $checkout_link = $this->stripe->checkout->sessions->create($stripe_args);

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
                'return_url' => back()->getRequest()->url(),
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

    // WEBHOOKS
    public function processWebhooks(Request $request)
    {
        // This is your Stripe CLI webhook secret for testing your endpoint locally.
        $endpoint_secret = Payments::isStripeLiveMode() ? Payments::stripe()->stripe_webhook_live_secret : Payments::stripe()->stripe_webhook_test_secret;

        // TODO:
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
                    // Single Plan Subscription mode: THIS PART CREATES ONE UserSubscription AND "detaches all other" (hence sync)
                    // IMPORTANT: Attach stripe_subscription_id to our UserSubscription
                    // If multiplan purchase is not available, 1) synch user subscription and 2) update stripe data
                    User::find($order->user_id)->plans()->sync([
                        $model->id => [
                            'order_id' => $order->id,
                            'payment_status' => PaymentStatusEnum::pending()->value, // set payment_status to `pending` because only when invoice.paid, we are sure that payment is 100% successful
                            'status' => UserSubscriptionStatusEnum::inactive()->value, // User subscription is still not active because we need to wait for invoice.paid!
                            'data' => json_encode([
                                $this->mode_prefix.'stripe_subscription_id' => $session->subscription ?? null, // store stripe_subscription_id
                                $this->mode_prefix.'stripe_request_id' => $stripe_request_id
                            ]),
                            'created_at' => time(),
                            'updated_at' => time()
                        ]
                    ]);
                } else {
                    // TODO: If multiplan purchase is available, logic is different!
                }
            }


            /*
            * Create Invoice here because 'invoice.paid'  hook won't be sent for one-time payments!!!
            */
            $invoice = Invoice::withoutGlobalScopes()->findOrFail($session->metadata->invoice_id ?? -1);;

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

            // Take invoice totals from $order itself
            // $invoice->base_price = $order->base_price;
            // $invoice->discount_amount = $order->discount_amount;
            // $invoice->subtotal_price = $order->subtotal_price;
            // $invoice->total_price = $order->total_price; // should be TotalPrice in future...
            // $invoice->grace_period = $order->invoice_grace_period ?? '';

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

                    $pi = $this->stripe->paymentIntents->retrieve(
                        $stripe_invoice->payment_intent,
                        []
                    );
                    
                    if(!empty($pi?->charges?->data[0]?->receipt_url ?? null)) {
                        $meta[$this->mode_prefix .'stripe_receipt_url'] = $pi->charges->data[0]?->receipt_url;   
                    }

                    $invoice->meta = $meta;
                    
                    $invoice->save();

                    DB::commit();
                }

            } else if($stripe_billing_reason === 'subscription_cycle') {                
                // This means that subscription is cycled
                $invoice = $order->invoices()->withoutGlobalScopes()->where([
                    ['start_date', $stripe_subscription->current_period_start],
                    ['end_date', $stripe_subscription->current_period_end],
                ])->first();

                
                // if new invoice is already created at this moment, it means that invoice.paid already happened, so skip creation cuz invoice already exists and is paid
                if(empty($invoice)) { 
                    
                    /*
                    * Create Invoice
                    */
                    $invoice = new Invoice();
                    $invoice->is_temp = false;
                    $invoice->payment_method_type = (Payments::stripe())::class;
                    $invoice->payment_method_id = Payments::stripe()->id;

                    // Change invoice status to paid if mode is 'payment', but if it's a subscription, change status to 'pending' because status will truly change on 'invoice.paid' webhook
                    $invoice->order_id = $order->id;
                    $invoice->shop_id = $order->shop_id;
                    $invoice->user_id = $order->user_id;
                    $invoice->payment_status = PaymentStatusEnum::pending()->value;
                    $invoice->invoice_number = 'invoice-draft-'.Uuid::generate(4)->string;

                    // Take period start and end from subscription!
                    $invoice->start_date = $stripe_subscription->current_period_start;
                    $invoice->end_date = $stripe_subscription->current_period_end;

                    $invoice->due_date = $stripe_invoice->due_date ?? null;

                    $invoice->base_price = $order->base_price;
                    $invoice->discount_amount = $order->discount_amount;
                    $invoice->subtotal_price = $stripe_invoice->subtotal / 100; // take from stripe and divide by 100
                    $invoice->total_price = $stripe_invoice->total / 100; // take from stripe and divide by 100
                    
                    $invoice->email = $order->email;
                    $invoice->billing_first_name = $order->billing_first_name;
                    $invoice->billing_last_name = $order->billing_last_name;
                    $invoice->billing_company = ''; // TODO: Get company name from invoice somehow...
                    $invoice->billing_address = $order->billing_address;
                    $invoice->billing_country = $order->billing_country;
                    $invoice->billing_state = $order->billing_state;
                    $invoice->billing_city = $order->billing_city;
                    $invoice->billing_zip = $order->billing_zip;
                    
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
                    
                    // On subscription_cycle, this is probably empty, but let it be just in case
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
            } else {
                // No idea...
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
            $user_subscriptions = $order->user_subscriptions()->withoutGlobalScopes()->get();

            if($stripe_billing_reason === 'subscription_create') {
                // This means that subscription is created for the first time
                $invoice = $order->invoices()->withoutGlobalScopes()->firstOrFail();
                
                if (!empty($invoice)) {
                    $invoice->is_temp = false; // Make this Invoice real!!!
                    $invoice->payment_status = PaymentStatusEnum::paid()->value;
                    $meta = $invoice->meta;
                    $meta[$this->mode_prefix .'stripe_invoice_paid'] = $stripe_invoice->paid ?? true;

                    $pi = $this->stripe->paymentIntents->retrieve(
                        $stripe_invoice->payment_intent,
                        []
                    );
                    
                    if(!empty($pi?->charges?->data[0]?->receipt_url ?? null)) {
                        $meta[$this->mode_prefix .'stripe_receipt_url'] = $pi->charges->data[0]?->receipt_url;   
                    }
                    $invoice->meta = $meta;
                    $invoice->save();

                    DB::commit();
                }

            } else if($stripe_billing_reason === 'subscription_cycle') {
                // This means that subscription is cycled
                
                $invoice = $order->invoices()->withoutGlobalScopes()->where([
                    ['start_date', $stripe_subscription->current_period_start],
                    ['end_date', $stripe_subscription->current_period_end],
                ])->first();

                // if new invoice is already created at this moment, it means that invoice.paid already happened, so skip creation cuz invoice already exists and is paid
                if(empty($invoice)) {
                    /*
                    * Create Invoice
                    */
                    $invoice = new Invoice();
                    $invoice->is_temp = false;
                    $invoice->payment_method_type = (Payments::stripe())::class;
                    $invoice->payment_method_id = Payments::stripe()->id;

                    // Change invoice status to paid if mode is 'payment', but if it's a subscription, change status to 'pending' because status will truly change on 'invoice.paid' webhook
                    $invoice->order_id = $order->id;
                    $invoice->shop_id = $order->shop_id;
                    $invoice->user_id = $order->user_id;
                    $invoice->payment_status = PaymentStatusEnum::paid()->value;
                    $invoice->invoice_number = $stripe_invoice->number ?? '';

                    // Take period start and end from subscription!
                    $invoice->start_date = $stripe_subscription->current_period_start;
                    $invoice->end_date = $stripe_subscription->current_period_end;

                    $invoice->due_date = $stripe_invoice->due_date ?? null;

                    $invoice->base_price = $order->base_price;
                    $invoice->discount_amount = $order->discount_amount;
                    $invoice->subtotal_price = $stripe_invoice->subtotal / 100; // take from stripe and divide by 100
                    $invoice->total_price = $stripe_invoice->total / 100; // take from stripe and divide by 100
                    
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
                    // this means that invoice was created on invoice.create properly
                    $invoice->payment_status = PaymentStatusEnum::paid()->value;
                    $invoice->invoice_number = $stripe_invoice->number ?? '';
                }

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
                $meta[$this->mode_prefix .'stripe_invoice_paid'] = $stripe_invoice->paid ?? true;

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


                // We are sure that invoice is paid so we make user_subscription(s) active and paid too (even though they may already be active and paid as a result of subscription.updated webhook)!
                if ($user_subscriptions->isNotEmpty()) {
                    foreach($user_subscriptions as $subscription) {
                        $subscription->status = UserSubscriptionStatusEnum::active()->value;
                        $subscription->payment_status = PaymentStatusEnum::paid()->value;

                        $subscription->save();
                    }
                }

                DB::commit();
            } else {
                // No idea...
            }

        } catch (\Throwable $e) {
            Log::error($e);
            DB::rollBack();
            http_response_code(400);
        }

        http_response_code(200);
        die();
    }

    // invoice.payment_failed
    public function whInvoicePaymentFailed($event)
    {
        // $stripe_invoice = $event->data->object;
        // $stripe_subscription_id = $stripe_invoice->subscription;

        // // TODO: What to do if payment is failed
        // try {
        //     $invoice = Invoice::withoutGlobalScopes()->whereJsonContains('meta->'.$this->mode_prefix.'stripe_invoice_id', $stripe_invoice->id)->first();
        //     $user_subscription = UserSubscription::withoutGlobalScopes()->whereJsonContains('data->'.$this->mode_prefix.'stripe_latest_invoice_id', $stripe_invoice->id)->first();

        //     $invoice->invoice_number = $stripe_invoice->number;
        //     $invoice->payment_status = PaymentStatusEnum::unpaid()->value;

        //     $meta = $invoice->meta;
        //     $meta[$this->mode_prefix .'stripe_invoice_id'] = $stripe_invoice->id ?? '';
        //     $meta[$this->mode_prefix .'stripe_hosted_invoice_url'] = $stripe_invoice->hosted_invoice_url ?? '';
        //     $meta[$this->mode_prefix .'stripe_invoice_pdf_url'] = $stripe_invoice->invoice_pdf ?? '';
        //     $meta[$this->mode_prefix .'stripe_invoice_number'] = $stripe_invoice->number ?? '';
        //     $meta[$this->mode_prefix .'stripe_customer_id'] = $stripe_invoice->customer ?? '';
        //     $meta[$this->mode_prefix .'stripe_payment_intent_id'] = $stripe_invoice->payment_intent ?? ''; // this will be null on all future automatic reccuring payments
        //     $meta[$this->mode_prefix .'stripe_subscription_id'] = $stripe_subscription_id; // store subscription ID in invoice meta
        //     $meta[$this->mode_prefix .'stripe_currency'] = $stripe_invoice->currency ?? null;
        //     $invoice->meta = $meta;

        //     $invoice->save();

        //     // Because payment failed, we should disable all user_subscriptions related to current stripe_subscription_id
        //     UserSubscription::withoutGlobalScopes()->whereJsonContains('data->'.$this->mode_prefix.'stripe_subscription_id', $stripe_subscription_id)->update([
        //         'payment_status' => PaymentStatusEnum::unpaid()->value,
        //         'status' => UserSubscriptionStatusEnum::inactive()->value,
        //     ]);
        // } catch (\Exception $e) {
        // }

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

                    $subscription->save();

                    // Status of subscription in this webhook is always: "status": "incomplete",
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

                        if($stripe_invoice->paid) {
                            // invoice is paid at this point in time; DON'T DO ANYTHING IF STRIPE INVOICE IS NOT PAID!
                            $subscription->status = UserSubscriptionStatusEnum::active()->value;
                            $subscription->payment_status = PaymentStatusEnum::paid()->value;
                        }
    
                        $data = $subscription->data;
                        $data[$this->mode_prefix .'stripe_latest_invoice_id'] = $latest_invoice_id;
                        $subscription->data = $data;
                    }

                    $subscription->save();
                }
            }
        } catch (\Exception $e) {
            http_response_code(400);
            die($e->getMessage());
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
