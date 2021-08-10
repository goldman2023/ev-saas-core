<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Event;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class EventTranslation extends Model
{
    use HasFactory;
    use HasSlug;

    protected $fillable = ['event_id','title', 'description', 'lang'];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function event(){
      return $this->belongsTo(Event::class);
    }
}
