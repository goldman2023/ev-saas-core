<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeGroup extends Model
{
    use HasFactory;

    public mixed $custom_attributes = null;

    protected $append = ['custom_attributes'];

    public function custom_attributes_relation() {
        return $this->hasMany(Attribute::class, 'group_id');
    }

    public function setCustomAttributesAttribute($attributes) {
        $this->custom_attributes = $attributes;
    }

    public function getCustomAttributesAttribute($attributes) {
        if(empty($this->custom_attributes)) {
            // If custom attributes for this group are not manually set, Query the DB
            $this->custom_attributes = $this->custom_attributes_relation()->without(['attribute_values', 'attribute_relationships'])->get();
        }

        return $this->custom_attributes;
    }
}
