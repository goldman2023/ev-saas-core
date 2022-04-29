<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follow extends WeBaseModel
{
    protected $table = 'follows';

    protected $fillable = ['id', 'user_id', 'subject_id', 'subject_type'];

    protected $casts = [
        
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subject()
    {
        return $this->morphTo();
    }
}
