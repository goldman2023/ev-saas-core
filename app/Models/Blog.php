<?php

namespace App\Models;

use App\Traits\PermalinkTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Sluggable\HasSlug;

// use GetStream\StreamLaravel\Eloquent\ActivityTrait;

class Blog extends Model
{
    use SoftDeletes;
    use LogsActivity;
    use PermalinkTrait;

    public const ROUTING_SINGULAR_NAME_PREFIX = 'news';
    public const ROUTING_PLURAL_NAME_PREFIX = 'news';



    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function visit()
    {
        return visits($this)->relation();
    }

}
