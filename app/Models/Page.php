<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use App;
use App\Traits\TranslationTrait;

class Page extends EVBaseModel
{
    use HasSlug;

    protected $table = 'pages';

    protected $fillable = ['title', 'type', 'content', 'meta_title', 'meta_description', 'created_at', 'updated_at'];

    protected $casts = [
        // 'id' => 'string',
        'content' => 'json',
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }


    public function page_previews() {
        return $this->hasMany(PagePreview::class, 'page_id');
    }

    // public function getTranslation($field = '', $lang = false){
    //     $lang = $lang == false ? App::getLocale() : $lang;
    //     $page_translation = $this->hasMany(PageTranslation::class)->where('lang', $lang)->first();
    //     return $page_translation != null ? $page_translation->$field : $this->$field;
    // }

    // public function page_translations(){
    //   return $this->hasMany(PageTranslation::class);
    // }
}
