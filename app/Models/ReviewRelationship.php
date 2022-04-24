<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewRelationship extends Model
{
    use HasFactory;

    public function reviewable()
    {
        return $this->morphTo('subject');
    }

    public function review()
    {
        return $this->belongsTo(Review::class, 'review_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id', 'id');
    }
}
