<?php

namespace App\Models;

use App\Traits\IsPaymentMethod;
use Closure;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PaymentMethodUniversal
 */
class PaymentMethodUniversal extends EVBaseModel
{
    use IsPaymentMethod;

    protected $table = 'payment_methods_universal';

    protected $fillable = ['enabled','name','gateway','description','instructions','data'];

    protected $casts = [
        'data' => 'object',
        'enabled' => 'boolean'
    ];


    public function shop()
    {
        return $this->belongsToMany(Shop::class, 'payment_methods_universal_relationships', 'upm_id', 'shop_id')->withPivot('enabled');
    }
}
