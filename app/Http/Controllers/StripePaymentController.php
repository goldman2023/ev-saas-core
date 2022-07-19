<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Seller;
use App\Models\TenantSetting;
use Illuminate\Http\Request;
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

    public function webhooks(Request $request)
    {
        return StripeService::processWebhooks($request);
    }

    public function generateCheckoutSessionLink()
    {
        $data = json_decode(base64_decode(request()->data), true);

        // Check if data has one or more items
        if(!empty($data['items'] ?? null) && get_tenant_setting('multi_item_subscription_enabled')) {
            $link = \StripeService::createSubscriptionCheckoutLink($data['items'], $data['interval'] ?? null);
        } else {
            $model = app($data['class'])->find($data['id']);

            $link = \StripeService::createCheckoutLink($model, $data['qty'] ?? 1, $data['interval'] ?? null, $data['preview'] ?? false, $data['abandoned_order_id'] ?? null);
        }
        
        
        // Redirect to Stripe session checkout
        return redirect($link);
    }

    public function createPortalSession()
    {
        $link = \StripeService::createPortalSession();

        return redirect($link);
    }
}
