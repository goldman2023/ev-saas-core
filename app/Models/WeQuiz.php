<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeQuiz extends Model
{
    use HasFactory;

    protected $table = "we_quizzes";

    public function user() {
        return $this->belongsTo(User::class);
    }
}
