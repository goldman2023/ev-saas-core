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
use App\Traits\HasStatus;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;


class Page extends WeBaseModel implements Sitemapable
{
    use HasSlug;
    use PermalinkTrait;
    use UploadTrait;
    use GalleryTrait;
    use HasStatus;
    use LogsActivity;

    protected $table = 'pages';

    protected $fillable = ['name', 'type', 'template', 'status', 'content', 'meta_title', 'meta_description', 'created_at', 'updated_at'];

    protected $casts = [
        // 'id' => 'string',
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function toSitemapTag(): Url | string | array
    {
        return route('custom-pages.show_custom_page', $this->slug);
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

    public function getPageMeta() {
        $meta = [
            'title' => $this->name,
            'description' => $this->meta_description,
            'image' => get_tenant_setting('seo_meta_image')
        ];

        if($this->getMetaImg()) {
            $meta['image'] = $this->getMetaImg();
        }

        if($this->meta_title) {
            $meta['title'] = $this->meta_title;
        }

        return $meta;
    }

    // public function page_translations(){
    //   return $this->hasMany(PageTranslation::class);
    // }
}
