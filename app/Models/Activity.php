<?php

namespace App\Models;

class Activity extends \Spatie\Activitylog\Models\Activity
{
    public function comments()
    {
        return $this->morphToMany(User::class, 'subject', 'social_comments');
    }
}