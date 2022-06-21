<?php

namespace App\Models;

use Spatie\Activitylog\Traits\LogsActivity;

class Ownership extends WeBaseModel
{
    use LogsActivity;

    protected $table = 'ownerships';

    protected $fillable = ['owner_id', 'owner_type', 'subject_id', 'subject_type', 'order_id', 'data', 'created_at', 'updated_at'];

    protected $casts = [
        'data' => 'array',
        'notify_owner_when_updated' => 'boolean',
    ];

    public function subject() {
        return $this->morphTo('subject');
    }

    public function owner() {
        return $this->morphTo('owner');
    }

    public function order() {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function getOrderItem() {
        if(!empty($this->order_id) && !empty($this->order)) {
            return $this->order->order_items->filter(fn($item) => $item->subject_id === $this->subject_id && $item->subject_type === $this->subject_type)->first();
        }

        return null;
    }

    public function scopeMy($query)
    {
        return $query->where([
            ['owner_id', '=', auth()->user()?->id ?? null],
            ['owner_type', '=', User::class]
        ]);
    }
}