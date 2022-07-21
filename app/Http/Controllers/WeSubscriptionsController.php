<?php

namespace App\Http\Controllers;

use StripeService;
use App\Facades\Payments;
use Illuminate\Http\Request;
use App\Models\UserSubscription;
use App\Models\Plan;

class WeSubscriptionsController extends Controller
{
    public function change_free_trial_plan(Request $request, $subscription_id, $new_plan_id) {
        $stripe = \StripeService::stripe();
        $subscription = UserSubscription::findOrFail($subscription_id);
        $new_plan = Plan::findOrFail($new_plan_id);
        $interval = $request->input('interval'); // GET parameter: annual or year


        if($subscription->isTrial()) {
            $stripe_sub_id = $subscription->getStripeSubscriptionID();
            $stripe_prod_id = $new_plan->getStripeProductID();
            $stripe_new_plan_price = null;
            
            if(!empty($stripe_sub_id) && !empty($stripe_prod_id)) {
                if($interval === 'month') {
                    $stripe_new_plan_price = $new_plan->getStripeMonthlyPriceID();
                } else if($interval === 'annual' || $interval === 'year') {
                    $stripe_new_plan_price = $new_plan->getStripeAnnualPriceID();
                } else {
                    throw new WeAPIException(message: translate('Interval parameter missing'), type: 'WeApiException', code: 400);
                }

                // Check if current plan is the same as the new plan (also take payment_interval into consideration)
                if($subscription->subject_id !== $new_plan->id || ($subscription->subject_id === $new_plan->id && $subscription->order->invoicing_period !== $interval )) {
                    
                    // 1. Get subscription first
                    $stripe_subscription = $stripe->subscriptions->retrieve(
                        $stripe_sub_id,
                        []
                    );

                    // 2. Get the subscription_item_id to change
                    $si_to_update = $stripe_subscription->items->data[0]?->id;

                    $updated_stripe_subscription = $stripe->subscriptions->update(
                        $stripe_sub_id,
                        [
                            'items' => [
                                [
                                    'id' => $si_to_update,
                                    'price' => $stripe_new_plan_price,
                                    'quantity' => 1 // TODO: change for multi-license etc. subscriptions
                                ]
                            ]
                        ]
                    );

                    if(!empty($updated_stripe_subscription->id)) {
                        return response()->json(['status' => 'success', 'data' => $updated_stripe_subscription]);
                    }
                }
            }
        }

        throw new WeAPIException(message: translate('Your previous subscription is not under trial'), type: 'WeApiException', code: 400);
    }

    public function generate_upcoming_invoice_from_stripe(Request $request, $user_subscription_id, $new_plan_id, $interval) {
        $user_subscription = UserSubscription::findOrFail($user_subscription_id);
        $new_plan = Plan::findOrFail($new_plan_id);

        return response()->json(['status' => 'success', 'data' => StripeService::getUpcomingInvoice($user_subscription, $new_plan, $interval)]);
    }

    public function calculate_potential_invoice(Request $request) {
        $cart = $request->input('cart');
        $interval = $request->input('interval');

        return response()->json(['status' => 'success', 'data' => StripeService::projectSubscriptionInvoice($cart, $interval)]);
    }
}
