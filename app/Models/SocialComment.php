<?php

namespace App\Models;

use App\Traits\SocialReactionsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class SocialComment extends WEBaseModel
{
    use HasFactory;
    use LogsActivity;
    use SocialReactionsTrait;


    protected $fillable = ['user_id', 'shop_id', 'comment_text', 'parent_id', 'subject_id', 'subject_type', 'rating'];

    public function replies()
    {
        return $this->hasMany(self::class, 'parent_id')->latest();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
