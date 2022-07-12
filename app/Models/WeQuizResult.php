<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class WeQuizResult extends WeBaseModel
{
    use HasFactory;
    use LogsActivity;

    protected $table = 'we_quiz_results';

    protected $fillable = ['user_id', 'quiz_id', 'quiz_answers', 'quiz_meta', 'quiz_passed'];

    /* TODO: add status pending for quiz results */
    protected $casts = [
        'quiz_answers' => 'array',
        'quiz_passed' => 'boolean',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function quiz() {
        return $this->belongsTo(WeQuiz::class);
    }
}
