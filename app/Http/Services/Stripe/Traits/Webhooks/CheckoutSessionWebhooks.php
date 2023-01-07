<?php

namespace App\Http\Services\Stripe\Traits\Webhooks;

use DB;
use Log;
use App\Models\Order;
use App\Models\Invoice;
use App\Enums\UserTypeEnum;
use App\Enums\UserEntityEnum;
use App\Enums\PaymentStatusEnum;
use App\Models\UserSubscription;


trait CheckoutSessionWebhooks
{
    // checkout.session.completed
    public function whCheckoutSessionCompleted($event)
    {
        $session = $event->data->object;

        DB::beginTransaction();

        try {
            // Populate Order with data from stripe
            $order = Order::withoutGlobalScopes()->findOrFail($session->client_reference_id);
            $user = $order->user;

            $order->payment_status = $session->mode === 'payment' ? PaymentStatusEnum::paid()->value : PaymentStatusEnum::pending()->value;
            $order->is_temp = false;
            $order->email = empty($order->email) ? $session->customer_details->email : $order->email;
            $order->billing_company = '';

            if(empty($order->user)) {
                $order->billing_first_name = explode(' ', $session->customer_details->name)[0] ?? '';
                $order->billing_last_name = explode(' ', $session->customer_details->name)[1] ?? '';
                $order->billing_address = !empty($session->customer_details->address->line1) ? $session->customer_details->address->line1 : '';
                $order->billing_country = !empty($session->customer_details->address->country) ? $session->customer_details->address->country : '';
                $order->billing_state = !empty($session->customer_details->address->state) ? $session->customer_details->address->state : '';
                $order->billing_city = !empty($session->customer_details->address->city) ? $session->customer_details->address->city : '';
                $order->billing_zip = !empty($session->customer_details->address->postal_code) ? $session->customer_details->address->postal_code : '';
            }
            
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

            // If trial mode is active and user doesn't have `started_trial_on` or it's empty, save timestamp when user started the trial mode
            if(get_tenant_setting('plans_trial_mode') && !empty(get_tenant_setting('plans_trial_duration'))) {
                $started_trials = collect($initiator->getUserMeta('started_trials_on', []));
                $trial_data = $started_trials->firstWhere('shop_id', $order->shop_id);

                if(!empty($trial_data)) {
                    $trial_data_index = $started_trials->search(fn($item, $key) => $item['shop_id'] == $order->shop_id);

                    if(empty($trial_data['started_on'] ?? null) || !is_int($trial_data['started_on'])) {
                        $started_trials->put($trial_data_index.'.started_on', time());
                    }
                } else {
                    // This means that trial subscription was NOT started at `started_on` timestamp for the given shop
                    $started_trials[] = [
                        'shop_id' => $order->shop_id,
                        'started_on' => time()
                    ];
                }

                $initiator->saveUserMeta('started_trials_on', $started_trials);
                $initiator->saveQuietly();
            }


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

                // Update Subscription
                $subscription = UserSubscription::withoutGlobalScopes()->findOrFail($session->metadata->subscription_id ?? -1);
                $subscription->is_temp = false;
                $subscription->user_id = $initiator->id;
                $subscription->order_id = $order->id;
                $subscription->setData(stripe_prefix('stripe_subscription_id'), $session->subscription ?? null, null);
                $subscription->saveQuietly();

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

            // Get latest invoice_id
            $stripe_subscription = $this->stripe->subscriptions->retrieve(
                $session->subscription,
                []
            );

            if(!empty($stripe_subscription)) {
                $stripe_invoice = $this->stripe->invoices->retrieve(
                    $stripe_subscription->latest_invoice,
                    []
                );
            }
            
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
                stripe_prefix('stripe_invoice_data') => isset($stripe_invoice) ? ($stripe_invoice?->toArray() ?? []) : [],
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

            $invoice->setRealInvoiceNumber();
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

            if($session->mode === 'subscription') {
                $order->user_subscription()->forceDelete(); // remove subscription and it's relations
                $order->forceDelete(); // remove order, order_items and invoices
                DB::commit();
                die();
            }

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
}