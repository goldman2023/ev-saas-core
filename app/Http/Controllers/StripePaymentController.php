<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\TenantSetting;
use App\Models\Seller;
use Session;
use Stripe\Stripe;
use StripeService;

class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        return view('frontend.payment.stripe');
    }

    public function webhooks(Request $request) {
        return StripeService::processWebhooks($request);
    }
}
