<?php

namespace App\Models;

use App\Traits\GalleryTrait;
use App\Traits\HasStatus;
use App\Traits\UploadTrait;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends WeBaseModel
{
    use HasSlug;
    use HasFactory;
    use HasStatus;
    use UploadTrait;
    use GalleryTrait;

    protected $table = 'sections';

    protected $fillable = ['type', 'title', 'slug', 'order', 'content', 'settings', 'meta_title', 'meta_description', 'created_at', 'updated_at'];

    public function getDynamicModelUploadProperties() : array {
        return [];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /*
     * Scope searchable parameters
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(
            fn ($query) =>  $query
                ->where('title', 'like', '%'.$term.'%')
        );
    }

}
