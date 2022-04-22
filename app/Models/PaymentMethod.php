<?php

namespace App\Models;

use App\Traits\IsPaymentMethod;
use Closure;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PaymentMethod
 */
class PaymentMethod extends WeBaseModel
{
    use IsPaymentMethod;

    /* TODO: Add `enable_custom_payment_methods` setting to TenantSettings - by default should be 0, and if toggled, vendors will have ability to set their custom payment methods (like their Stripe/Paypal/Paysera account etc. */

    protected $table = 'payment_methods';

    protected $with = [];

    protected $fillable = ['shop_id','enabled','name','gateway','description','instructions','data'];

    protected $cast = [
        'data' => 'object',
        'enabled' => 'bool'
    ];


    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

}
