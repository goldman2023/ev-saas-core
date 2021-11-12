<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;
use App\Models\AttributeTranslation;
use App\Models\AttributeGroup;

class Attribute extends Model
{
    protected $with = ['attribute_values'];

    protected $casts = [
        'custom_properties' => 'object'
    ];

    protected $appends = ['is_predefined'];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($attribute) {
            $attribute->attribute_translations()->delete();
            $attribute->attribute_relationships()->delete();
            foreach ($attribute->attribute_values as $value) {
                $value->delete();
            }
        });
    }

    /**
     * Checks if attribute has one or multiple values
     *
     * @return bool
     */
    public function getIsPredefinedAttribute()
    {
        return $this->type === 'dropdown' || $this->type === 'checkbox' || $this->type === 'radio';
    }

    public function attribute_relationships()
    {
        return $this->hasMany(AttributeRelationship::class, 'attribute_id', 'id');
    }

    public function attribute_values()
    {
        return $this->hasManyThrough(AttributeValue::class, AttributeRelationship::class, 'attribute_id', 'id', 'id', 'attribute_value_id');
    }

    public function get_group() {
        if ($this->group !== NULL) {
            return AttributeGroup::findOrFail($this->group);
        }

        return new AttributeGroup;
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
