<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class WeQuiz extends WeBaseModel
{
    use HasFactory;
    use LogsActivity;

    protected $table = "we_quizzes";

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function results() {
        return $this->hasMany(WeQuizResults::class, 'quiz_id', 'id');
    }

    public function scopeMy($query)
    {
        return $query->where('user_id', '=', auth()->user()?->id ?? null);
    }
}
