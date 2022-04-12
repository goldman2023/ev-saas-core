<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialComment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'shop_id', 'comment_text', 'parent_id', 'subject_id', 'subject_type'];

    public function replies()
    {
        return $this->hasMany(SocialComment::class, 'parent_id')->latest();
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
