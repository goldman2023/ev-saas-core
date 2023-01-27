<?php

namespace App\Http\Services;

use DB;
use FX;
use EVS;
use Cache;
use Session;
use App\Models\Shop;
use App\Models\User;
use App\Models\Invoice;
use App\Models\ShopSetting;
use App\Models\TenantSetting;
use App\Models\PaymentMethodUniversal;
use Illuminate\Database\Eloquent\Collection;

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

        // TODO: This should be done in some new admin middleware (maybe inside IsAdmin)
        $all_possible_gateways = \App\Enums\PaymentGatewaysEnum::labels();
        if (! empty($all_possible_gateways)) {
            $gateways_in_db = $this->payment_methods_all->pluck('gateway');

            foreach ($all_possible_gateways as $gateway => $label) {
                if (! $gateways_in_db->contains($gateway)) {
                    DB::table('payment_methods_universal')->insert([
                        'enabled' => 0,
                        'name' => $label,
                        'gateway' => $gateway,
                        'description' => '',
                        'instructions' => '',
                        'data' => json_encode([]),
                    ]);
                }
            }
        }
        // Move the logic in middleware ^^^
    }

    public function getPaymentMethods()
    {
        return $this->payment_methods;
    }

    public function getPaymentMethodsForSelect()
    {
        return $this->payment_methods->keyBy('gateway')->map(fn ($item) => $item->name);
    }

    public function getPaymentMethodsName()
    {
        return $this->payment_methods->map(fn ($item) => $item->name);
    }

    public function getPaymentMethodsGateway()
    {
        return $this->payment_methods->map(fn ($item) => $item->gateway);
    }

    public function getPaymentMethodsAll()
    {
        return $this->payment_methods_all;
    }

    // Wire Transfer
    public function wire_transfer()
    {
        return $this->wire_transfer;
    }
    // END Wire Transfer

    // Stripe
    public function stripe()
    {
        return $this->stripe;
    }

    public function isStripeEnabled()
    {
        return $this->stripe->enabled ?? false;
    }

    public function isStripeCheckoutEnabled()
    {
        return $this->stripe->stripe_checkout_enabled ?? false;
    }

    public function isStripeLiveMode()
    {
        return ($this->stripe?->stripe_mode ?? null) === 'live';
    }

    public function isStripeTestMode()
    {
        return ($this->stripe?->stripe_mode ?? null) !== 'live';
    }
    // END Stripe functions

    // Paypal
    public function paypal()
    {
        return $this->paypal;
    }
    // END Paypal

    // Paysera
    public function paysera()
    {
        return $this->paysera;
    }
    // END Paysera

    // HELPERS
    public function getViaLabel($gateway) {
        if($gateway instanceof Invoice) {
            $gateway = $gateway->getPaymentMethodGateway();
        }
        
        return match ($gateway) {
            'stripe' => translate('Via Stripe'),
            'paypal' => translate('Via Paypal'),
            'paysera' => translate('Via Paysera'),
            'wire_transfer' => translate('Via Bank Transfer'),
        };
    }
}
