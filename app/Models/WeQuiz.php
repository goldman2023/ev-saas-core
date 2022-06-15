<?php

namespace App\Models;

use App\Traits\PermalinkTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class WeQuiz extends WeBaseModel
{
    use HasFactory;
    use LogsActivity;
    use HasSlug;
    use PermalinkTrait;
    use LogsActivity;

    protected $table = "we_quizzes";

    protected $casts = [
        'quiz_json' => 'array',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function results() {
        return $this->hasMany(WeQuizResult::class, 'quiz_id', 'id');
    }

    public function scopeMy($query)
    {
        return $query->where('user_id', '=', auth()->user()?->id ?? null);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public static function getRouteName()
    {
        return 'custom-pages.show_custom_page';
    }
}
