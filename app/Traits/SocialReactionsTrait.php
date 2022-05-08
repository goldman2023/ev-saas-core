<?php

namespace App\Traits;

use App\Models\User;
use App\Models\Shop;
use App\Models\Category;
use App\Enums\SocialReactionsEnum;
use Route;

trait SocialReactionsTrait
{
    public function likes()
    {
        return $this->morphToMany(User::class, 'subject', 'social_reactions')->where('type', SocialReactionsEnum::like()->value);
    }
}
