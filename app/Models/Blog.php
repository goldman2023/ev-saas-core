<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use GetStream\StreamLaravel\Eloquent\ActivityTrait;

class Blog extends Model
{
    use SoftDeletes;

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
