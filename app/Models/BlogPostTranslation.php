<?php

namespace App\Models;

use App\Traits\GalleryTrait;
use App\Traits\IsTranslation;
use App\Traits\PermalinkTrait;
use App\Traits\TranslationTrait;
use App\Traits\UploadTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

// use GetStream\StreamLaravel\Eloquent\ActivityTrait;

class BlogPostTranslation extends EVBaseModel
{
    use HasSlug;

    protected $table = 'blog_post_translations';

    protected $fillable = ['title', 'excerpt', 'content', 'meta_title', 'meta_description', 'meta_keywords'];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function blog_post() {
        return $this->belongsTo(BlogPost::class, 'blog_post_id');
    }

}
