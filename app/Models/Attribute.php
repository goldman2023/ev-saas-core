<?php

namespace App\Models;

use App;
use WEF;
use App\Models\Product;
use App\Traits\CoreMetaTrait;
use Spatie\Sluggable\HasSlug;
use App\Models\AttributeGroup;
use App\Enums\AttributeTypeEnum;
use App\Traits\TranslationTrait;
use Spatie\Sluggable\SlugOptions;
use App\Models\AttributeTranslation;
use Illuminate\Database\Eloquent\Model;
use App\Support\Eloquent\Relations\AttributeValuesRelation;

class Attribute extends WeBaseModel
{
    use HasSlug;
    use TranslationTrait;
    use CoreMetaTrait;

    // protected $with = ['attribute_relationships', 'attributes_values'];
    public static $predefinedTypes = ['dropdown', 'checkbox', 'radio'];
    public static $filterableTypes = ['toggle', 'dropdown', 'checkbox', 'radio', 'number', 'date'];

    protected $fillable = ['name', 'type', 'group', 'filterable', 'content_type', 'is_admin', 'is_default', 'is_schema', 'schema_key', 'schema_value', 'custom_properties'];

    protected $casts = [
        'custom_properties' => 'object',
        'filterable' => 'boolean',
        'is_admin' => 'boolean',
        'is_schema' => 'boolean',
        'is_default' => 'boolean',
    ];

    protected $appends = ['identificator', 'is_predefined', 'is_filterable'];

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

    /*
     * Scope searchable parameters
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(
            fn ($query) =>  $query->where('name', 'like', '%'.$term.'%')
        );
    }

    public function scopeFilterable($query)
    {
        return $query->where(
            fn ($query) =>  $query->where('filterable', true)->whereIn('type', self::$filterableTypes)
        );
    }

    public function scopeForProduct($query)
    {
        return $query->where(
            fn ($query) =>  $query->where('content_type', Product::class)
        );
    }

    public function setDefault($content_type)
    {
        $this->content_type = $content_type;
        $this->name = '';
        $this->type = 'plain_text';
        $this->group = null;
        $this->filterable = false;
        $this->is_admin = false;
        $this->is_schema = false;
        $this->is_default = false;
        $this->schema_key = null;
        $this->schema_value = null;
        $this->custom_properties = null;
    }

    /**
     * Checks if attribute has predefined attribute values - only dropdown/checkbox/radio can have predefined value
     *
     * @return bool
     */
    public function getIdentificatorAttribute()
    {
        return sprintf('%s|%s', $this->slug, $this->content_type);
    }
    /**
     * Checks if attribute has predefined attribute values - only dropdown/checkbox/radio can have predefined value
     *
     * @return bool
     */
    public function getIsPredefinedAttribute()
    {
        return in_array($this->type, self::$predefinedTypes);
    }

    /**
     * Checks if attribute is filterable
     *
     * @return bool
     */
    public function getIsFilterableAttribute()
    {
        return in_array($this->type, self::$filterableTypes);
    }

    public function attribute_relationships()
    {
        return $this->hasMany(AttributeRelationship::class, 'attribute_id', 'id');
    }

    public function attribute_values()
    {
        // return new AttributeValuesRelation(
        //     model: $this,
        //     hasMany: [
        //         'related' => AttributeValue::class,
        //         'foreignKey' => 'attribute_id',
        //         'localKey' => 'id'
        //     ],
        //     hasManyThrough: [
        //         'farParent' => AttributeValue::class,
        //         'throughParent' => AttributeRelationship::class,
        //         'firstKey' => 'attribute_id',
        //         'secondKey' => 'id',
        //         'localKey' => 'id',
        //         'secondLocalKey' => 'attribute_value_id'
        //     ]
        // );

        return $this->hasManyThrough(AttributeValue::class, AttributeRelationship::class, 'attribute_id', 'id', 'id', 'attribute_value_id');
    }

    // TODO: IMPORTANT! With and Load functions for eager and non-eager load DO NOT WORK cuz parent model in that case has no attributes and is_predefined is null!!!!!
    public function attribute_predefined_values() {
        if ($this->is_predefined) {
            // If attribute is predefined, there is only strict amount of values that it should return from DB,
            // it should not use hasManyThrough relationship, but hasMany, because it does not depend on any AttributeRelationship
            return $this->hasMany(AttributeValue::class, 'attribute_id', 'id')
                ->orderByRaw("CASE WHEN ordering = 0 THEN 0 ELSE 1 END DESC") // If ordering is 0, then put it after all other...
                ->orderBy('ordering', 'ASC')
                ->groupBy('id');
        }

        return $this->attribute_values();
    }

    public function group()
    {
        return $this->belongsTo(AttributeGroup::class, 'group_id');
    }

    public function getWEFDataTypes() {
        return WEF::bundleWithGlobalWEF(apply_filters('attributes.wef.data-types', [

        ]));
    }

    /**
     * getAttrVal
     *
     * Gets the value of the attribute
     *
     * @return void
     */
    public function getAttrVal() {
        if(in_array($this->type, AttributeTypeEnum::getSingles())) {
            return $this->attribute_values->first()?->values ?? null;
        }

        return $this->attribute_values->pluck('values');
    }

    public function get_group()
    {
        if (! empty($this->group_id)) {
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

    public function getFilterableTypes() {
        return self::$filterableTypes;
    }
}
