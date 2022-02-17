<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;
use App\Models\AttributeTranslation;
use App\Models\AttributeGroup;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use App\Traits\TranslationTrait;

class Attribute extends EVBaseModel
{
    use HasSlug;
    use TranslationTrait;

    // TODO: Think about uncommenting this because Attribute inherits EVBaseModel
//    protected $with = ['attribute_relationships', 'attributes_values'];

    protected $casts = [
        'custom_properties' => 'object',
        'filterable' => 'boolean',
        'is_admin' => 'boolean',
        'is_schema' => 'boolean',
        'is_default' => 'boolean',
    ];

    protected $appends = ['is_predefined'];

    public static function boot()
    {
        parent::boot();

        // TODO: Move this AttributeObserver
        static::deleting(function ($attribute) {
            $attribute->attribute_translations()->delete();
            $attribute->attribute_relationships()->delete();
            foreach ($attribute->attribute_values as $value) {
                $value->delete();
            }
        });
    }

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

    public function getTranslationModel(): ?string
    {
        return AttributeTranslation::class;
    }

    /*
     * Scope searchable parameters
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(
            fn ($query) =>  $query->where('name', 'like', '%'.$term.'%')
        );
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
        if($this->is_predefined) {
            // If attribute is predefined, there is only strict amount of values that it should return from DB, 
            // it should not use hasManyThrough relationship, but hasMany, because it does not depend on any AttributeRelationship
            return $this->hasMany(AttributeValue::class, 'attribute_id', 'id');
        } 

        return $this->hasManyThrough(AttributeValue::class, AttributeRelationship::class, 'attribute_id', 'id', 'id', 'attribute_value_id');
    }

    public function group() {
        return $this->belongsTo(AttributeGroup::class, 'group_id');
    }

    public function get_group() {
        if (!empty($this->group_id)) {
            return AttributeGroup::findOrFail($this->group_id);
        }

        return new AttributeGroup;
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
