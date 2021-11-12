<?php
namespace App\Traits;


use App\Models\Attribute;
use App\Models\AttributeRelationship;
use App\Models\Product;

trait AttributeTrait
{
    /**
     * Boot the trait
     *
     * @return void
     */
    protected static function bootAttributeTrait()
    {
        // When model data is retrieved, populate model prices data!
        static::retrieved(function ($model) {
            // Load Custom Attributes
            $load_custom_attributes = $model->custom_attributes;
        });
    }

    public function custom_attributes()
    {
        // Load all product attributes along with relations and values! Attribute -> Relation -> Value
        return $this->morphToMany(Attribute::class, 'subject', 'attribute_relationships', null, 'attribute_id')
            ->distinct()
            ->withOnly([
                'attribute_values' => function($query) {
                    $query->where([
                        ['subject_id', '=', $this->id],
                        ['subject_type', '=', get_class($this)]
                    ]);
                },
                'attribute_relationships' => function($query) {
                    $query->where([
                        ['subject_id', '=', $this->id],
                        ['subject_type', '=', get_class($this)]
                    ]);
                },
                //'attribute_relationships.attribute_value'
            ]);
    }

    public function seo_attributes() {
        return $this->custom_attributes->filter(function($att, $index) {
            return $att->where('is_schema', 1);
        });
    }

    public function admin_attributes() {
        return $this->custom_attributes->filter(function($att, $index) {
            return $att->where('is_admin', 1);
        });
    }

    public function filterable_attributes() {
        return $this->custom_attributes->filter(function($att, $index) {
            return $att->where('filterable', 1);
        });
    }

    public function variant_attributes()
    {
        return $this->custom_attributes->filter(function($att, $index) {
            return $att->attribute_relationships->firstWhere('for_variations', 1);
        });
    }

    /*public function attributes() {
        return $this->morphMany(AttributeRelationship::class, 'subject');
    }*/


}
