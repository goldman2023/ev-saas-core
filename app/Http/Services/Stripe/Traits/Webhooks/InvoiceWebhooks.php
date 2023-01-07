<?php

namespace App\Http\Services\Stripe\Traits\Webhooks;

use DB;
use Log;
use App\Models\Order;
use App\Enums\PaymentStatusEnum;
use App\Models\UserSubscription;
use App\Enums\UserSubscriptionStatusEnum;
use App\Notifications\Invoice\InvoicePaymentFailed;

trait InvoiceWebhooks
{
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
                $order->saveQuietly();
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

                    $invoice->saveQuietly();

                    DB::commit();
                }

            } else if($stripe_billing_reason === 'subscription_cycle') {
                $invoice = $order->invoices()->withoutGlobalScopes()->get()->firstWhere('meta.'.stripe_prefix('stripe_invoice_id'), $stripe_invoice->id);

                // Subscription is cycled
                // New order and invoice will be created in subscription.updated webhook
                //$this->createInvoice(order: $order, stripe_invoice: $stripe_invoice, stripe_subscription: $stripe_subscription);

                //DB::commit();
            } else if($stripe_billing_reason === 'subscription_update') {
                $invoice = $order->invoices()->withoutGlobalScopes()->get()->firstWhere('meta.'.stripe_prefix('stripe_invoice_id'), $stripe_invoice->id);

                // Subscription is updated (downgraded, upgraded etc.) - DON'T DO ANYTHING HERE!!!
                // New order and invoice will be created in subscription.updated webhook
                // $this->createInvoice(order: $order, stripe_invoice: $stripe_invoice, stripe_subscription: $stripe_subscription);

                // DB::commit();
            }

            // Set invoice customer data
            if(!empty($invoice) && !empty($invoice->user ?? null)) {
                $user = $invoice->user;

                // Save billing info
                $invoice->billing_first_name = $order->billing_first_name;
                $invoice->billing_last_name = $order->billing_last_name;
                $invoice->billing_company = $user->getUserMeta('company_name');
                $invoice->billing_address = $order->billing_address;
                $invoice->billing_country = $order->billing_country;
                $invoice->billing_state = $order->billing_state;
                $invoice->billing_city = $order->billing_city;
                $invoice->billing_zip = $order->billing_zip;
                
                $invoice->mergeData([
                    'customer' => [
                        'entity' => $user->entity,
                    ],
                ]);
    
                if($user->entity === 'company') {
                    $invoice->mergeData([
                        'customer' => [
                            'billing_country' => $user->getUserMeta('address_country'), //$stripe_invoice->customer_address->country,
                            'vat' => $user->getUserMeta('company_vat'),
                            'company_registration_number' => $user->getUserMeta('company_registration_number'),
                            'company_name' => $user->getUserMeta('company_name'),
                        ]
                    ]);
                } else {
                    $invoice->mergeData([
                        'customer' => [
                            'billing_country' => $user->getUserMeta('address_country'), //$stripe_invoice->customer_address->country,
                        ],
                    ]);
                }

                $invoice->saveQuietly();
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
                $order->saveQuietly();

                if($stripe_billing_reason === 'subscription_create') {
                    // This means that subscription is created for the first time
                    $invoice = $order->invoices()->withoutGlobalScopes()->where('invoice_number', $stripe_invoice->number)->firstOrFail();
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
                        stripe_prefix('stripe_invoice_data') => $stripe_invoice?->toArray() ?? [],
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

                    $invoice->setRealInvoiceNumber();
                }

                // ***IMPORTANT: subscription `cycle` and `update` are moved to subscription.updated webhook
                // Keep in mind that some data is not accessible inside subsription.update (like invoice->number, sine subs_update happens beforeinvoice.paid on stripe for some reason...or at least that's a webhook order)
            }


            // We are sure that invoice is paid so we make user_subscription(s) active and paid too (even though they may already be active and paid as a result of subscription.updated webhook)!
            if (!empty($subscription)) {
                $subscription->is_temp = false;
                $subscription->setData(stripe_prefix('stripe_subscription_id'), $stripe_subscription_id);

                // If subscription has trial start/end (provided from checkout.session)
                if($stripe_subscription->status === 'trialing') {
                    $subscription->status = UserSubscriptionStatusEnum::trial()->value;
                    $subscription->payment_status = PaymentStatusEnum::unpaid()->value;
                } else {
                    $subscription->status = UserSubscriptionStatusEnum::active()->value;
                    $subscription->payment_status = PaymentStatusEnum::paid()->value;
                }

                if($stripe_billing_reason === 'subscription_cycle') {
                    // IMPORTANT: Always update subscription start/end date to reflect current period from Stripe - WE ARE SURE INVOICE IS PAID HERE!
                    $subscription->start_date = $stripe_subscription->current_period_start;
                    $subscription->end_date = $stripe_subscription->current_period_end;
                } else {
                    // Forgot why getRawOriginal() is needed -_-
                    if(empty($subscription->getRawOriginal('start_date'))) {
                        $subscription->start_date = $stripe_subscription->current_period_start;
                    }

                    // Forgot why getRawOriginal() is needed -_-
                    if(empty($subscription->getRawOriginal('end_date'))) {
                        $subscription->end_date = $stripe_subscription->current_period_end;
                    }
                }

                $subscription->saveQuietly();

                // Refresh Upcoming Invoice
                $order->refreshStripeUpcomingInvoice();
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
            $subscription = $order->user_subscription()->withoutGlobalScopes()->first();

            if($stripe_billing_reason === 'subscription_create') {
                // This means that subscription is created for the first time
                $invoice = $order->invoices()->withoutGlobalScopes()->firstOrFail();

                if (!empty($invoice)) {
                    $invoice->is_temp = false; // Make this Invoice real!!!
                    $invoice->payment_status = PaymentStatusEnum::unpaid()->value;
                    $invoice->invoice_number = !empty($stripe_invoice->number) ? $stripe_invoice->number : $invoice->invoice_number;

                    $invoice->mergeData([
                        stripe_prefix('stripe_invoice_paid') => $stripe_invoice->paid ?? true,
                        stripe_prefix('stripe_invoice_id') => $stripe_invoice->id ?? '',
                        stripe_prefix('stripe_hosted_invoice_url') => $stripe_invoice->hosted_invoice_url ?? '',
                        stripe_prefix('stripe_invoice_pdf_url') => $stripe_invoice->invoice_pdf ?? '',
                        stripe_prefix('stripe_invoice_number') => $stripe_invoice->number ?? '',
                        stripe_prefix('stripe_customer_id') => $stripe_invoice->customer ?? '',
                        stripe_prefix('stripe_payment_intent_id') => $stripe_invoice->payment_intent ?? '',
                        stripe_prefix('stripe_subscription_id') => $stripe_subscription_id,
                        stripe_prefix('stripe_currency') => $stripe_invoice->currency ?? null,
                        stripe_prefix('stripe_invoice_data') => $stripe_invoice?->toArray() ?? [],
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
                }

            } else if($stripe_billing_reason === 'subscription_cycle') {
                // This means that subscription is cycled
                $invoice = $this->createInvoice(order: $order, stripe_invoice: $stripe_invoice, stripe_subscription: $stripe_subscription);
            } else if($stripe_billing_reason === 'subscription_update') {
                // Subscription is updated (downgraded, upgraded etc.)
                $invoice = $this->createInvoice(order: $order, stripe_invoice: $stripe_invoice, stripe_subscription: $stripe_subscription);
            } else {
                // No idea...
            }

            // We are sure that invoice is NOT paid so we make user_subscription(s) inactive and unpaid too!
            if (!empty($subscription)) {
                $subscription->is_temp = false;

                $subscription->status = UserSubscriptionStatusEnum::inactive()->value;
                $subscription->payment_status = PaymentStatusEnum::unpaid()->value;

                if(empty($subscription->getRawOriginal('start_date'))) {
                    $subscription->start_date = $stripe_subscription->current_period_start;
                }

                if(empty($subscription->getRawOriginal('end_date'))) {
                    $subscription->end_date = $stripe_subscription->current_period_end;
                }

                $subscription->setData(stripe_prefix('stripe_subscription_id'), $stripe_subscription_id);

                $subscription->saveQuietly();
            }

            DB::commit();
        } catch (\Throwable $e) {
            Log::error($e);
            DB::rollBack();
            die(print_r($e));
            http_response_code(400);
        }

        // WeHooks 
        try {
            // Fire Subscription(s) "is created and failed" Event
            if($stripe_billing_reason === 'subscription_create') {
                do_action('invoice.payment_failed.subscription_create', $subscription, null, $stripe_invoice);
            }
            // Fire Subscription(s) "is updated and failed" Event
            else if($stripe_billing_reason === 'subscription_update') {
                do_action('invoice.payment_failed.subscription_update', $subscription, null, $stripe_invoice);
            }
            // Fire Subscription "is cycled and failed" Event
            else if($stripe_billing_reason === 'subscription_cycle') { 
                do_action('invoice.payment_failed.subscription_cycle', $subscription, $stripe_invoice);
            }
        } catch(\Throwable $e) {
            Log::error($e);
            die(print_r($e)); // TODO: Comment this die
        }

        try {
            $invoice->user->notify(new InvoicePaymentFailed($invoice));
            $invoice->saveQuietly();
        } catch(\Exception $e) {
            Log::error($e->getMessage());
            die(print_r($e));
        }

        http_response_code(200);
        die();
    }
}
