<?php

namespace App\Models;

use App\Traits\SocialCommentsTrait;


class Activity extends \Spatie\Activitylog\Models\Activity
{
    use SocialCommentsTrait;


    /* TODO: Make this into reporting Trait */
    public function scopeByDays($query, $days)
    {
        //one day (today)
        $date = \Carbon::now();

        //one month / 30 days
        $date = \Carbon::now()->subDays($days);

        return $query->where('created_at', '>' , $date);
    }
}
