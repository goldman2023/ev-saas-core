<?php

namespace App\Models;

use App\Traits\SocialCommentsTrait;


class Activity extends \Spatie\Activitylog\Models\Activity
{
    use SocialCommentsTrait;
}