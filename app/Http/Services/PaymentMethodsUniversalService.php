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

    public function __construct($app)
    {
        $this->payment_methods = PaymentMethodUniversal::where('enabled', 1)->get();
    }

    public function getPaymentMethods() {
        return $this->payment_methods;
    }

    public function getPaymentMethodsName() {
        return $this->payment_methods->map(fn($item) => $item->name);
    }

    public function getPaymentMethodsGateway() {
        return $this->payment_methods->map(fn($item) => $item->gateway);
    }
}
