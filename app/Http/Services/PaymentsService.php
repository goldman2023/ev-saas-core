<?php

namespace App\Http\Services;

use App\Models\PaymentMethodUniversal;
use App\Models\Shop;
use App\Models\ShopSetting;
use App\Models\TenantSetting;
use App\Models\User;
use Cache;
use Illuminate\Database\Eloquent\Collection;
use Session;
use EVS;
use FX;

class PaymentsService
{
    protected $payment_methods = null;
    protected $payment_methods_all = null;
    protected $stripe;
    protected $paypal;
    protected $wire_transfer;
    protected $paysera;

    public function __construct($app)
    {
        $this->payment_methods = PaymentMethodUniversal::where('enabled', 1)->get();
        $this->payment_methods_all = PaymentMethodUniversal::all();

        $this->stripe = $this->payment_methods_all->where('gateway', 'stripe')->first();
        $this->paypal = $this->payment_methods_all->where('gateway', 'paypal')->first();
        $this->wire_transfer = $this->payment_methods_all->where('gateway', 'wire_transfer')->first();
        $this->paysera = $this->payment_methods_all->where('gateway', 'paysera')->first();
    }

    public function getPaymentMethods() {
        return $this->payment_methods;
    }

    public function getPaymentMethodsForSelect() {
        return $this->payment_methods->keyBy('gateway')->map(fn($item) => $item->name);
    }

    public function getPaymentMethodsName() {
        return $this->payment_methods->map(fn($item) => $item->name);
    }

    public function getPaymentMethodsGateway() {
        return $this->payment_methods->map(fn($item) => $item->gateway);
    }

    public function getPaymentMethodsAll() {
        return $this->payment_methods_all;
    }

    // Wire Transfer
    public function wire_transfer() {
        return $this->wire_transfer;
    }
    // END Wire Transfer

    // Stripe
    public function stripe() {
        return $this->stripe;
    }
    public function isStripeEnabled() {
        return $this->stripe->enabled ?? false;
    }
    public function isStripeCheckoutEnabled() {
        return $this->stripe->stripe_checkout_enabled ?? false;
    }
    public function isStripeLiveMode() {
        if($this->stripe) {
            return $this->stripe->stripe_mode === 'live';

        } else {
            return abort(404);
        }
    }
    public function isStripeTestMode() {
        return $this->stripe->stripe_mode !== 'live';
    }
    // END Stripe functions

    // Paypal
    public function paypal() {
        return $this->paypal;
    }
    // END Paypal

    // Paysera
    public function paysera() {
        return $this->paysera;
    }
    // END Paysera
}
