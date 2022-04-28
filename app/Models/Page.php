<?php

namespace App\Models;

use App;
use App\Traits\GalleryTrait;
use App\Traits\PermalinkTrait;
use App\Traits\TranslationTrait;
use App\Traits\UploadTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Page extends WeBaseModel
{
    use HasSlug;
    use PermalinkTrait;
    use UploadTrait;
    use GalleryTrait;

    protected $table = 'pages';

    protected $fillable = ['name', 'type', 'status', 'content', 'meta_title', 'meta_description', 'created_at', 'updated_at'];

    protected $casts = [
        // 'id' => 'string',
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
    ];

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

    /*
     * Scope searchable parameters
     */
    // public function scopeSearch($query, $term)
    // {
    //     return $query->where(
    //         fn ($query) =>  $query
    //             ->where('name', 'like', '%'.$term.'%')
    //             // ->orWhere('excerpt', 'like', '%'.$term.'%')
    //             // ->orWhere('content', 'like', '%'.$term.'%')
    //     );
    // }

    public function page_previews()
    {
        return $this->hasMany(PagePreview::class, 'page_id');
    }

    public function getContentAttribute($value)
    {
        if (empty($value)) {
            return array_values(json_decode('[]', true));
        } else {
            $decoded_json = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $decoded_json;
            }

            return $value;
        }
    }

    public function setContentAttribute($value)
    {
        if(is_array($value)) {
            $this->attributes['content'] = json_encode(array_values($value));
        } else if(is_string($value)) {
            $this->attributes['content'] = $value;
        }
    }

    public function getTranslation($field = '', $lang = false)
    {
        return $this->name;
    }

    public function getDynamicModelUploadProperties(): array
    {
        return [];
    }

    // public function page_translations(){
    //   return $this->hasMany(PageTranslation::class);
    // }
}
