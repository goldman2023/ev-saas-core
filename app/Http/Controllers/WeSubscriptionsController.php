<?php

namespace App\Http\Controllers;

use App\Facades\Payments;
use Illuminate\Http\Request;

class WeSubscriptionsController extends Controller
{
    public $stripe = null;
    //
    public function __construct()
    {
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

    public function changeFreeTrialPlan() {
        $this->stripe->subscriptions->update(
            'sub_1LAXmBASOFrdz0QBPL4r8MJJ',
            ''
            ['metadata' => ['order_id' => '6735']]
          );
    }
}
