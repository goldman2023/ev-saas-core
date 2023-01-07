<?php

namespace App\Http\Services\Stripe\Traits\Webhooks;

use DB;
use Log;
use App\Enums\UserTypeEnum;
use App\Enums\UserEntityEnum;

trait CustomerWebhooks
{
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

            // DEPRECATED: Update address and stuff (DONT UPDATE USER META BASED ON STRIPE BILLING INFO!!!)
            // if($user->entity === 'company') {
            //     $user->saveUserMeta('address_country', $customer->address->country);
            //     $user->saveUserMeta('address_city', $customer->address->city);
            //     $user->saveUserMeta('address_line', $customer->address->line1);
            //     $user->saveUserMeta('address_postal_code', $customer->address->postal_code);
            //     $user->saveUserMeta('address_state', $customer->address->state);
            // }
        }
    }
}