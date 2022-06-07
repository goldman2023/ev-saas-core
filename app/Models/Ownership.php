<?php

namespace App\Models;

class Ownership extends WeBaseModel
{
    protected $table = 'ownerships';

    protected $fillable = ['owner_id', 'owner_type', 'subject_id', 'subject_type', 'data', 'created_at', 'updated_at'];

    protected $casts = [
        'data' => 'array'
    ];

    public function subject() {
        return $this->morphTo('subject');
    }

}