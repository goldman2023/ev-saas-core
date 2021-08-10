<?php


namespace App\Http\Controllers\Api\V2;


class PaymentTypesController
{

    public function getList()
    {
        $payment_types = array();

        if (\App\Models\BusinessSetting::where('type', 'paypal_payment')->first()->value == 1) {
            $payment_type = array();
            $payment_type['payment_type'] = 'paypal_payment';
            $payment_type['payment_type_key'] = 'paypal';
            $payment_type['image'] = static_asset('assets/img/cards/paypal.png');
            $payment_type['name'] = "Paypal";
            $payment_type['title'] = "Checkout with Paypal";

            $payment_types[] = $payment_type;
        }

        if (\App\Models\BusinessSetting::where('type', 'stripe_payment')->first()->value == 1) {
            $payment_type = array();
            $payment_type['payment_type'] = 'stripe_payment';
            $payment_type['payment_type_key'] = 'stripe';
            $payment_type['image'] = static_asset('assets/img/cards/stripe.png');
            $payment_type['name'] = "Stripe";
            $payment_type['title'] = "Checkout with Stripe";

            $payment_types[] = $payment_type;
        }

        if (\App\Models\BusinessSetting::where('type', 'wallet_system')->first()->value == 1) {
            $payment_type = array();
            $payment_type['payment_type'] = 'wallet_system';
            $payment_type['payment_type_key'] = 'wallet';
            $payment_type['image'] = static_asset('assets/img/cards/wallet.png');
            $payment_type['name'] = "Wallet";
            $payment_type['title'] = "WalletPayment";

            $payment_types[] = $payment_type;
        }

        if (\App\Models\BusinessSetting::where('type', 'cash_payment')->first()->value == 1) {
            $payment_type = array();
            $payment_type['payment_type'] = 'cash_payment';
            $payment_type['payment_type_key'] = 'cash_on_delivery';
            $payment_type['image'] = static_asset('assets/img/cards/cod.png');
            $payment_type['name'] = "Cash Payment";
            $payment_type['title'] = "Cash on delivery";

            $payment_types[] = $payment_type;
        }

        return response()->json($payment_types);



    }

}
