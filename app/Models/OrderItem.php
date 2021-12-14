<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OrderDetail
 */
class OrderItem extends Model
{
    protected $table = 'order_items';

    protected $fillable = ['subject_id', 'subject_type', 'title', 'excerpt', 'base_price', 'discount_amount', 'subtotal_price', 'total_price', 'tax', 'created_at', 'updated_at'];
    protected $visible = ['id', 'subject_id', 'subject_type', 'title', 'excerpt', 'base_price', 'discount_amount', 'subtotal_price', 'total_price', 'tax', 'created_at', 'updated_at'];
    protected $guarded = [];

    protected $casts = [
        'phone_numbers' => 'array',
        'serial_numbers' => 'array',
        'same_billing_shipping' => 'boolean',
        'viewed' => 'boolean'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function subject()
    {
        return $this->morphTo('subject');
    }

//    public function pickup_point()
//    {
//        return $this->belongsTo(PickupPoint::class);
//    }
//
//    public function refund_request()
//    {
//        return $this->hasOne(RefundRequest::class);
//    }

//    public function affiliate_log()
//    {
//        return $this->hasMany(AffiliateLog::class);
//    }
}
