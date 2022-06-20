<?php

namespace App\Models;

use Spatie\Activitylog\Traits\LogsActivity;

class Ownership extends WeBaseModel
{
    use LogsActivity;

    protected $table = 'ownerships';

    protected $fillable = ['owner_id', 'owner_type', 'subject_id', 'subject_type', 'data', 'created_at', 'updated_at'];

    protected $casts = [
        'data' => 'array'
    ];

    public function subject() {
        return $this->morphTo('subject');
    }

    public function owner() {
        return $this->morphTo('owner');
    }

}