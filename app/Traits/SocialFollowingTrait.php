<?php

namespace App\Traits;

use App\Models\User;
use App\Models\Shop;
use App\Models\Category;
use Route;

trait SocialFollowingTrait
{
    public function followers()
    {
        return $this->morphToMany(User::class, 'subject', 'follows');
    }
    
    public function follows_users()
    {
        return $this->morphedByMany(User::class, 'subject', 'follows');
    }

    public function follows_shops()
    {
        return $this->morphedByMany(Shop::class, 'subject', 'follows');
    }

    public function follows_categories()
    {
        return $this->morphedByMany(Category::class, 'subject', 'follows');
    }

    public function isFollowingCategory($category_id) {
        return !empty($this->follows_categories->firstWhere('id', $category_id));
    }
}
