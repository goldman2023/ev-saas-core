<?php

namespace App\Models;

use App\Traits\TranslationTrait;
use App\Traits\UploadTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\AttributeTrait;
use App\Traits\GalleryTrait;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Job extends Model
{
    use HasFactory;
    use AttributeTrait;
    use UploadTrait;
    use HasSlug;

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

}
