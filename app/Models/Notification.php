<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Notification extends WeBaseModel
{
    use HasFactory;
    use LogsActivity;

    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }

}
