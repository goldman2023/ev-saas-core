<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class WeQuizResults extends WeBaseModel
{
    use HasFactory;
    use LogsActivity;

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function quiz() {
        return $this->belongsTo(WeQuiz::class);
    }
}
