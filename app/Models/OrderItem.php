<?php

namespace App\Models;

use App\Traits\UploadTrait;
use App\Traits\GalleryTrait;
use App\Traits\AttributeTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OrderItem
 */
class OrderItem extends WeBaseModel
{
    use AttributeTrait;
    use UploadTrait;
    use GalleryTrait;

    protected $table = 'order_items';

    protected $fillable = ['subject_id', 'subject_type', 'name', 'excerpt', 'base_price', 'discount_amount', 'subtotal_price', 'total_price', 'tax', 'quantity', 'ordering', 'serial_numbers', 'variant', 'created_at', 'updated_at'];

    protected $visible = ['id', 'subject_id', 'subject_type', 'name', 'excerpt', 'base_price', 'discount_amount', 'subtotal_price', 'total_price', 'tax', 'quantity', 'ordering', 'serial_numbers', 'variant', 'created_at', 'updated_at'];

    protected $guarded = [];

    protected $casts = [
        'serial_numbers' => 'array',
        'variant' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function subject()
    {
        return $this->morphTo('subject');
    }

    public function getDynamicModelUploadProperties(): array
    {
        return [];
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
