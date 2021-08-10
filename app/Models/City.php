<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class City extends Model
{
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function getTranslation($field = '', $lang = false){
        $lang = $lang == false ? App::getLocale() : $lang;
        $city_translation = $this->hasMany(CityTranslation::class)->where('lang', $lang)->first();
        return $city_translation != null ? $city_translation->$field : $this->$field;
    }

    public function city_translations(){
      return $this->hasMany(CityTranslation::class);
    }
}
