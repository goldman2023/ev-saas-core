<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Facades\CartService;
use App\Enums\OrderTypeEnum;
use App\Enums\PaymentStatusEnum;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Invoice;
use Cache;
use Illuminate\Database\Eloquent\Collection;
use Session;
use EVS;
use FX;
use DB;
use Stripe;
use Payments;
use Carbon;
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

        // Set supported shipping countries
        $this->supported_shipping_countries = array_values(array_diff(['LT', 'RS', 'DE', 'GB', 'ES', 'FR', 'US'], $this->unsupported_shipping_countries));
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


    public function createCheckoutLink($model, $qty = 1, $preview = true)
    {
        // Check if Stripe Product actually exists
        $stripe_product_id = $model->core_meta()->where('key', '=', $this->mode_prefix . 'stripe_product_id')->first()?->value ?? null;

        try {
            $stripe_product = $this->stripe->products->retrieve($stripe_product_id, []);
        } catch(\Exception $e) {
            // What if there is no product in stripe under given ID?

            // 1. Create a product and price if product is missing in Stripe
            $stripe_product = $this->createStripeProduct($model);
            // return $this->createCheckoutLink($model, $qty); // try again after product and price are created
        }


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

        // If Preview, then don't crete temp order
        if($preview) {
            // Create an Order
            $order = $this->createTempOrder($model, $qty);
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
            'billing_address_collection' => 'required',
            'client_reference_id' => $order->id,
            /* TODO: Create dynamic order on the fly when generating checkout link  */
            'success_url' => route('checkout.order.received', ['id' => $order->id]),
            'cancel_url' => route('checkout.order.canceled', ['id' => $order->id]),
            'automatic_tax' => [
                'enabled' => false,
            ],
        ];

        // Check if Modal is digital or not, and based on that display or hide Stripe shipping options
        if(!$model->is_digital ?? true) {
            // If $model is not digital (like standard non-digital product)
            $stripe_args['shipping_address_collection'] = [
                // TODO: Put all allowed shipping countries two-letter codes here. Keep in mind there should be two allowed_shipping_countries settings. One in TenantSettings and other in ShopSettings. ShpoSettings one is used when app is a marketplace!
                'allowed_countries' => $this->supported_shipping_countries // this is test for now - get ALL codes
            ];
        }

        /* Guest Checkout, do not add email for guests */
        if (auth()->user()) {
            $email =  auth()->user()->email;
            $stripe_args['customer_email'] = $email;
        } else {
            $email = '';
        }

        // Create a Stripe Checkout Link
        $checkout_link = $this->stripe->checkout->sessions->create($stripe_args);

        // Save payment intent inside Order meta
        $meta = $order->meta;
        $meta['stripe_payment_intent_id'] = $checkout_link['payment_intent'] ?? null; // store payment intent id
        $meta['stripe_checkout_session_id'] = $checkout_link['id'] ?? null; // store chekout session id
        $order->meta = $meta;

        $order->save();

        return $checkout_link['url'] ?? null;
    }

    protected function createTempOrder($model, $qty) {
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
            $order->same_billing_shipping = false;
            $order->buyers_consent = true;
            $order->is_temp = true;
            $order->email = '';

            // TODO: Should be handled differently
            if($model instanceof Plan) {
                /*
                * Invoicing data for SUBSCRIPTIONS/PLANS or INCREMENTAL orders
                */
                $order->type = OrderTypeEnum::subscription()->value;
                $order->number_of_invoices = -1; // 'unlimited' for subscriptions
                $order->invoicing_period = 'month'; // TODO: Add monthly/annual switch
                $order->invoice_grace_period = 0;
                $order->invoicing_start_date = Carbon::now()->timestamp; // when invoicing starts
            } else {
                $order->type = OrderTypeEnum::standard()->value;
                $order->number_of_invoices = 1; // 'unlimited' for subscriptions
                $order->invoicing_period = null; // TODO: Add monthly/annual switch
                $order->invoice_grace_period = $default_grace_period;
                $order->invoicing_start_date = Carbon::now()->timestamp; // when invoicing starts
            }

            // If user is logged in
            if(Auth::check()) {
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
            $order->save();

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
            $order_item->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            // TODO: Think about fallback or some error page to notify user that there's an error on Order creation just before StripeCheckout redirect.
            dd($e);
        }

        return $order;
    }


    public function processWebhooks(Request $request) {
        // This is your Stripe CLI webhook secret for testing your endpoint locally.
        $endpoint_secret = 'whsec_IUN8xCktKu64YeKHp28hzpMZLjbFdic4';

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            http_response_code(400);
            exit();
        }


        // Handle the event
        switch ($event->type) {
            case 'charge.succeeded':
                $charge = $event->data->object;
                break;
            case 'checkout.session.completed':
                DB::beginTransaction();

                try {
                     // Populate Order with data from stripe
                    $session = $event->data->object;
                    $order = Order::withoutGlobalScopes()->findOrFail($session->client_reference_id);
                    $order->payment_status = PaymentStatusEnum::paid()->value;
                    $order->is_temp = false;
                    $order->email = empty($order->email) ? $session->customer_details->email : $order->email;
                    $order->billing_first_name = explode(' ', $session->customer_details->name)[0] ?? '';
                    $order->billing_last_name = explode(' ', $session->customer_details->name)[1] ?? '';
                    $order->billing_address = !empty($session->customer_details->address->line1) ? $session->customer_details->address->line1 : '';
                    $order->billing_country = !empty($session->customer_details->address->country) ? $session->customer_details->address->country : '';
                    $order->billing_state = !empty($session->customer_details->address->state) ? $session->customer_details->address->state : '';
                    $order->billing_city = !empty($session->customer_details->address->city) ? $session->customer_details->address->city : '';
                    $order->billing_zip = !empty($session->customer_details->address->postal_code) ? $session->customer_details->address->postal_code : '';
                    $order->phone_numbers = !empty($session->customer_details->phone) ? $session->customer_details->phone : [];

                    $order->shipping_method = ''; // TODO: Should mimic shipping_method from tenant!!!

                    $order->shipping_first_name = explode(' ', $session->shipping->name)[0] ?? '';
                    $order->shipping_last_name = explode(' ', $session->shipping->name)[1] ?? '';
                    $order->shipping_address = !empty($session->shipping->address->line1) ? $session->shipping->address->line1 : '';
                    $order->shipping_country = !empty($session->shipping->address->country) ? $session->shipping->address->country : '';
                    $order->shipping_state = !empty($session->shipping->address->state) ? $session->shipping->address->state : '';
                    $order->shipping_city = !empty($session->shipping->address->city) ? $session->shipping->address->city : '';
                    $order->shipping_zip = !empty($session->shipping->address->postal_code) ? $session->shipping->address->postal_code : '';
                    $order->save();

                    // Check if $model has stock and reduce it if it does!!!
                    $order_item =  $order->order_items->first();
                    $model = $order_item->subject;

                    if(method_exists($model, 'stock')) {
                        // Reduce the stock quantity of an $model
                        $serial_numbers = $model->reduceStock();

                        // Serial Numbers only work for Simple Products.
                        // TODO: Make Product Variations support serial numbers!
                        if($model->use_serial) {
                            $order_item->serial_numbers = $serial_numbers; // reduceStockBy returns serial numbers in array if $model uses serials
                        } else {
                            $order_item->serial_numbers = null;
                        }
                    }

                    /*
                    * Create Invoice
                    */
                    $invoice = new Invoice();

                    $invoice->order_id = $order->id;
                    $invoice->shop_id = $order->shop_id;
                    $invoice->user_id = $order->user_id;
                    $invoice->payment_method_type = (Payments::stripe())::class;
                    $invoice->payment_method_id = Payments::stripe()->id;
                    $invoice->payment_status = PaymentStatusEnum::paid()->value;
                    $invoice->invoice_number = Invoice::generateInvoiceNumber($order->billing_first_name, $order->billing_last_name, $order->billing_company); // Default: VJ21012022

                    $invoice->email = $order->email;
                    $invoice->billing_first_name = !empty($order->billing_first_name) ? $order->billing_first_name : '';
                    $invoice->billing_last_name = !empty($order->billing_last_name) ? $order->billing_last_name : '';
                    $invoice->billing_company = !empty($order->billing_company) ? $order->billing_company : '';
                    $invoice->billing_address = !empty($order->billing_address) ? $order->billing_address : '';
                    $invoice->billing_country = !empty($order->billing_country) ? $order->billing_country : '';
                    $invoice->billing_state = !empty($order->billing_state) ? $order->billing_state : '';
                    $invoice->billing_city = !empty($order->billing_city) ? $order->billing_city : '';
                    $invoice->billing_zip = !empty($order->billing_zip) ? $order->billing_zip : '';


                    // Take invoice totals from Cart
                    $invoice->base_price = $order->base_price;
                    $invoice->discount_amount = $order->discount_amount;
                    $invoice->subtotal_price = $order->subtotal_price;
                    $invoice->total_price = $order->total_price; // should be TotalPrice in future...


                    $invoice->shipping_cost = 0; // TODO: Don't forget to change this when shipping mechanism is created
                    $invoice->tax = 0; // TODO: Don't forget to change this when tax mechanism is created

                    // TODO: Add Shop Settings for general due_date and grace_period
                    // TODO: Trial can determine invoicing start_date because trial can append X days on top of current date-time, so invoicing starts on e.g. 15 days from current date, or 30 or X
                    $invoice->start_date = $order->invoicing_start_date; // current unix_timestamp (for non-trial plans)
                    $invoice->due_date = null; // Default due_date is NULL days for subscription (if not trial mode, if it's trial it's null)
                    $invoice->grace_period = $order->invoice_grace_period; // NULL; or 5 days grace_period by default

                    $invoice->save();

                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    http_response_code(400);
                    die($e->getMessage());
                }

                break;
            case 'checkout.session.expired':
                // Checkout Session Expired webhook
                DB::beginTransaction();

                try {
                     // Remove Temp order when stripe checkout session expires, BUT only if order is made by guest user (user_id == null)
                    $session = $event->data->object;
                    $order = Order::withoutGlobalScopes()->findOrFail($session->client_reference_id);

                    if(empty($order->user_id)) {
                        // Temp order is not linked to a user, so remove it fully!
                        $order->forceDelete();
                    }

                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    http_response_code(400);
                    die($e->getMessage());
                }

                break;
            case 'payment_intent.created':
                $paymentIntent = $event->data->object;
                break;
            case 'payment_intent.canceled':
                $paymentIntent = $event->data->object;
                break;
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object;
                break;
            // ... handle other event types
            default:
                echo 'Received unknown event type ' . $event->type;
        }

        http_response_code(200);
    }
}
