<?php

namespace App\Traits;

use App\Models\User;
use App\Models\Shop;
use App\Models\Category;
use Route;

trait SocialCommentsTrait
{
    public function comments()
    {
        return $this->morphToMany(User::class, 'subject', 'social_comments');
    }
}
