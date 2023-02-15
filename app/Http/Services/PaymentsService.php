<?php

namespace App\Http\Services;

use DB;
use FX;
use WE;
use Log;
use Cache;
use Session;
use App\Models\Shop;
use App\Models\User;
use App\Models\Invoice;
use App\Models\ShopSetting;
use Illuminate\Http\Request;
use App\Models\TenantSetting;
use App\Models\PaymentMethodUniversal;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Services\PaymentMethods\PayseraGateway;


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

    // Actions
    public function executePayment(Request $request, $invoice_id, $payment_gateway = null, $livewire_redirect = false) {
        try {
            if($invoice_id instanceof Invoice) {
                $invoice = $invoice_id;
            } else {
                $invoice = Invoice::with('payment_method')->findOrFail($invoice_id);
            }

            if($invoice->user_id !== (auth()->user()?->id ?? null)) {
                // If current user is not the same as the invoice user, forbid access to payment execution
                abort(403);
            }

            if(empty($payment_gateway)) {
                $payment_gateway = $invoice->payment_method->gateway;
            }

            if(!self::getPaymentMethodsGateway()->contains($payment_gateway)) {
                throw new \Exception('Payment gateway: '.$payment_gateway.'; not enabled or does not exist in PaymentsService');
            }

            // TODO: Add different payment methods checkout flows here (going to payment gateway page with callback URL for payment_status change route)
            if ($payment_gateway === 'wire_transfer') {
                return redirect()->route('checkout.order.received', $invoice->order_id);
            } else if ($payment_gateway === 'stripe') {

            } else if ($payment_gateway === 'paypal') {
                
            } elseif ($payment_gateway === 'paysera') {
                $paysera = new PayseraGateway(
                    order: $invoice->order,
                    invoice: $invoice,
                    payment_method: self::$payment_gateway(),
                    lang: 'ENG',
                    paytext: translate('Payment for goods and services (for nb. [order_nr]) ([site_name])')
                );
                return $paysera->pay();
            }
        } catch(\Throwable $e) {
            Log::error($e);
            // abort(500);
            dd($e);
        }
    }

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
