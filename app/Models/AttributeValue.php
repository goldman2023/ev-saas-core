<?php

namespace App\Models;

use App;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;

    public static function boot() {
        parent::boot();

        static::deleting(function($attribute_value) {
             $attribute_value->attribute_value_translations()->delete();
             $attribute_value->attribute_value_relationship()->delete();
        });
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function attribute_value_translations(){
        return $this->hasMany(AttributeValueTranslation::class);
    }

    public function attribute_value_relationship(){
        return $this->hasMany(AttributeRelationship::class, 'attribute_value_id', 'id');
    }

    public function getTranslation($field = '', $lang = false){
        $lang = $lang == false ? App::getLocale() : $lang;
        $attribute_translation = $this->hasMany(AttributeValueTranslation::class)->where('lang', $lang)->first();
        return $attribute_translation != null ? $attribute_translation->$field : $this->values;
      }
}
