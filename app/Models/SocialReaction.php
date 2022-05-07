<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialReaction extends WeBaseModel
{
    protected $table = 'social_reactions';

    protected $fillable = ['id', 'user_id', 'subject_id', 'subject_type', 'type', 'created_at'];

    protected $casts = [
        
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subject()
    {
        return $this->morphTo();
    }
}
