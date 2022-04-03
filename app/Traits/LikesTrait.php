<?php

namespace App\Traits;

use App\Models\User;
use Route;

trait LikesTrait
{
    abstract public static function getRouteName();

    public function likes()
    {
        return $this->morphToMany(User::class, 'subject', 'wishlists');
    }
}
