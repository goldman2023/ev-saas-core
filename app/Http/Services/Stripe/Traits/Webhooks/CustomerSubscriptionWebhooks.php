<?php

namespace App\Http\Services\Stripe\Traits\Webhooks;

use DB;
use Log;
use App\Models\Order;
use App\Models\Invoice;
use App\Enums\PaymentStatusEnum;
use App\Models\UserSubscription;
use App\Enums\UserSubscriptionStatusEnum;
use App\Notifications\Invoice\InvoicePaymentFailed;

trait CustomerSubscriptionWebhooks
{
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

               // 5. Update stripe subscription with metadata needed for further actions (cycle/update etc.)
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

           $order = Order::withoutGlobalScopes()->with(['user_subscription'])->findOrFail($order_id);
           $subscription = !empty($order->user_subscription) ? $order->user_subscription : UserSubscription::withoutGlobalScopes()->findOrFail($stripe_subscription->metadata?->subscription_id ?? null);
           
           if (!empty($subscription)) {
               $subscription->is_temp = false;

               $subscription->start_date = $stripe_subscription->current_period_start;
               $subscription->end_date = $stripe_subscription->current_period_end;

               $subscription->setData(stripe_prefix('stripe_subscription_id'), $stripe_subscription_id);
               $subscription->setData(stripe_prefix('stripe_latest_invoice_id'), $stripe_subscription->latest_invoice ?? null);

               // Only change status and payment_status of subscription and order if stripe subscription is in Trial mode
               if($stripe_subscription->status === 'trialing') {
                   $subscription->status = UserSubscriptionStatusEnum::trial()->value;
                   $subscription->payment_status = PaymentStatusEnum::unpaid()->value;
               }

               $subscription->save();

               // Save date of first trial for a given user!
               if($stripe_subscription->status === 'trialing') {
                   $started_trials[] = [
                       'shop_id' => $order->shop_id,
                       'started_on' => time(),
                   ];
   
                   $subscription->user->saveUserMeta('started_trials_on', $started_trials);
               }

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
               $subscription->is_temp = false;

               // $subscription->start_date = $stripe_subscription->current_period_start;
               // $subscription->end_date = $stripe_subscription->current_period_end;

               if($stripe_subscription->cancel_at_period_end ?? false) {
                   // Cancel
                   $subscription->status = UserSubscriptionStatusEnum::active_until_end()->value; // Set to active_until_end because only on 'invoice.paid' we are sure that subscription is 100% paid!
                   $subscription->end_date = $stripe_subscription->cancel_at ?? '';

               } else if($previous_attributes->cancel_at_period_end ?? false && empty($stripe_subscription->cancel_at_period_end)) {
                   // Renew
                   // Check if previous state was canceled subscription and new `cancel_at_period_end` is null - revive if true
                   $subscription->status = UserSubscriptionStatusEnum::active()->value; // Set to active_until_end because only on 'invoice.paid' we are sure that subscription is 100% paid!
               } else {
                   // Subscription start/end timestamps MUST NOT BE UPDATED HERE, cuz we don't know if invoice is really paid or not
                   // $subscription->start_date = $stripe_subscription->current_period_start;
                   // $subscription->end_date = $stripe_subscription->current_period_end;

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

                   $subscription->setData(stripe_prefix('stripe_subscription_id'), $stripe_subscription_id);
                   $subscription->setData(stripe_prefix('stripe_latest_invoice_id'), $latest_invoice_id);

                   // Determine if subscription is cycled or upgraded/downgraded
                   if($stripe_billing_reason === 'subscription_cycle' && !empty($previous_attributes?->current_period_start ?? null) && !empty($previous_attributes?->current_period_end ?? null)) {
                       // IMPORTANT: Check if latest stripe invoice is paid or not (it's usually DRAFT at this point when subscription cycling happens), and if it's not, use previous attributes for start/end!!!
                       // if(!$stripe_invoice->paid) {
                       //     // Subscription start/end timestamps (on our end) MUST ONLY be updated on invoice.paid - otherwise, they stay as they are!!!
                       //     $subscription->start_date = $previous_attributes->current_period_start;
                       //     $subscription->end_date = $previous_attributes->current_period_end;
                       // }

                       // This means that subscription is cycled - just create a new invoice
                       $new_invoice = $this->createInvoice(order: $order, stripe_invoice: $stripe_invoice, stripe_subscription: $stripe_subscription);

                       // Update latest_invoice_id in stripe subscription metadata
                       $new_metadata = $stripe_subscription->metadata;
                       $new_metadata->latest_invoice_id = $new_invoice->id;
                   } else if(($stripe_billing_reason === 'subscription_update' || $stripe_billing_reason === 'subscription_create') && !empty($previous_attributes?->plan?->id ?? null)) {
                       $subscription->start_date = $stripe_subscription->current_period_start;
                       $subscription->end_date = $stripe_subscription->current_period_end;
                       
                       // MAY HAPPEN THAT billing_reason is subscription_create!!!

                       // With condition `!empty($previous_attributes?->plan?->id ?? null)` we are preventing processing any subscription change which is NOT related to it's products/items changes, like metadata change and similar!

                       // Check if Order with latest_invoice_id already exists BUT ALSO CHECK IF previous plan price (if exists) is different than current plan price!
                       // Important observation: Stripe sometimes issues the same invoice for certain subscription.changes, example is downgrade. Since there is some proration, invoice MAY stay the same,
                       // but content of subscription is changed (different products included in subscription)
                       // For this reaon, we cannot just depend on identifying Order only based on `latest_invoice_id`. We must include previous and new price(s) too, in order to know if subscription content really changed
                       // *IMPORTANT* - Getting previous and new price MAY BE DIFFERENT based on multi-product subscriptions and single-product ones. Bu we'll see soon :)
                       // IMORTANT**** -> THIS WILL BE SLOOOOOOOOOOOOW QUERY cuz meta json cols are not indexed!
                       $existing_order = Order::query()->withoutGlobalScopes()->whereJsonContains('meta->' . $this->mode_prefix .'stripe_latest_invoice_id', $stripe_subscription->latest_invoice)->first();
                       $existing_invoice = Invoice::query()->withoutGlobalScopes()->whereJsonContains('meta->' . $this->mode_prefix .'stripe_invoice_id', $stripe_subscription->latest_invoice)->first();

                       // Code `should-procceed` ONLY if:
                       // 1. Both Order and Invoice with `latest_invoice_id` cannot be found in our DB
                       // OR
                       // 2. Previous attributes plan->id (actually previous subscription price ID) is different than current subscription price ID

                       if(get_tenant_setting('multi_item_subscription_enabled')) {
                           $should_proceed = (empty($existing_order) && empty($existing_invoice)) || (($stripe_subscription?->plan?->id ?? 1) !== ($previous_attributes->plan->id ?? 1));; // TODO: This must work according to multi-plan purchase
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

                   } else if(($stripe_billing_reason === 'subscription_update' || $stripe_billing_reason === 'subscription_create') && !empty($previous_attributes?->current_period_end ?? null) && !empty($previous_attributes?->trial_end ?? null)) {
                       $subscription->start_date = $stripe_subscription->current_period_start;
                       
                       // This means that Trial end_date was changed from Stripe
                       $invoice_id = $stripe_subscription->metadata->invoice_id;
                       $existing_invoice = Invoice::query()->withoutGlobalScopes()->find($invoice_id);
                       
                       if(!empty($existing_invoice)) {
                           $existing_invoice->end_date = $stripe_subscription?->trial_end ?? $existing_invoice->end_date;
                           $existing_invoice->saveQuietly();
                       }

                       $subscription->end_date = $stripe_subscription?->trial_end ?? $subscription->end_date;
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
           $order = Order::withoutGlobalScopes()->findOrFail($stripe_subscription->metadata->order_id ?? null);
           $subscription = $order->user_subscription;

           // This means that subscription is finally canceled (no revive is possible and it's final, so we should disable subscription on our end!)
           if (!empty($subscription)) {
               // Delete subscription on our end! User will have to go through standard process again!
               $subscription->status = UserSubscriptionStatusEnum::canceled()->value;
               // $subscription->forceDelete();
               $subscription->save();
           }
       } catch (\Exception $e) {
           http_response_code(400);
           die($e->getMessage());
       }
   }
}
