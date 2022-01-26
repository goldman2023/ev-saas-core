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

    protected function init() {
        if(auth()->user() instanceof User) {
            if (auth()->user()->isSeller() || auth()->user()->isStaff() || auth()->user()->isAdmin()) {
                $this->shop = auth()->user()->shop->first();

                $this->setSettings();
            }
        }
    }

    public function getPaymentMethods() {
        return $this->payment_methods;
    }

}