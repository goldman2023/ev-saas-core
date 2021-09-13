<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;
use App\Models\AttributeTranslation;

class Attribute extends Model
{
    protected $with = ['attribute_values', 'attributes_relationship'];

    protected $casts = [
        'custom_properties' => 'object'
    ];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($attribute) {
            $attribute->attribute_translations()->delete();
            $attribute->attributes_relationship()->delete();
            foreach ($attribute->attribute_values as $value) {
                $value->delete();
            }
        });
    }

    public function attributes_relationship()
    {
        return $this->hasMany(AttributeRelationship::class, 'attribute_id', 'id');
    }

    public function attribute_values()
    {
        return $this->hasMany(AttributeValue::class, 'attribute_id', 'id');
    }


    public function getTranslation($field = '', $lang = false)
    {
        $lang = $lang == false ? App::getLocale() : $lang;
        $attribute_translation = $this->hasMany(AttributeTranslation::class)->where('lang', $lang)->first();
        return $attribute_translation != null ? $attribute_translation->$field : $this->$field;
    }

    public function attribute_translations()
    {
        return $this->hasMany(AttributeTranslation::class);
    }

    public function included_categories()
    {
        //return $this->belongsToMany(RelatedModel, pivot_table_name, foreign_key_of_current_model_in_pivot_table, foreign_key_of_other_model_in_pivot_table);
        return $this->belongsToMany(
            Category::class,
            'attribute_categories',
            'attribute_id',
            'category_id'
        );
    }
}
