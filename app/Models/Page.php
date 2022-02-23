<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use App;

class Page extends EVBaseModel
{
    use HasSlug;

    protected $table = 'pages';

    protected $casts = [
        'id' => 'string',
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


    // public function getTranslation($field = '', $lang = false){
    //     $lang = $lang == false ? App::getLocale() : $lang;
    //     $page_translation = $this->hasMany(PageTranslation::class)->where('lang', $lang)->first();
    //     return $page_translation != null ? $page_translation->$field : $this->$field;
    // }

    // public function page_translations(){
    //   return $this->hasMany(PageTranslation::class);
    // }
}
