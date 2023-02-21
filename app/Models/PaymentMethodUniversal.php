<?php

namespace App\Models;

use Closure;
use App\Traits\IsPaymentMethod;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PaymentMethodUniversal
 */
class PaymentMethodUniversal extends WeBaseModel
{
    use IsPaymentMethod;

    protected $table = 'payment_methods_universal';

    protected $fillable = ['enabled', 'name', 'gateway', 'description', 'instructions', 'data'];

    protected $casts = [
        'data' => 'object',
        'enabled' => 'boolean',
    ];

    public function shop()
    {
        return $this->belongsToMany(Shop::class, 'payment_methods_universal_relationships', 'upm_id', 'shop_id')->withPivot('enabled');
    }
}
