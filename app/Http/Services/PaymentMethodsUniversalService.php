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

class PaymentMethodsUniversalService
{
    protected $payment_methods = null;
    protected $payment_methods_all = null;


    public function __construct($app)
    {
        $this->payment_methods = PaymentMethodUniversal::where('enabled', 1)->get();
        $this->payment_methods_all = PaymentMethodUniversal::all();
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
}
