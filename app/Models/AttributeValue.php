<?php

namespace App\Models;

use WEF;
use App\Traits\CoreMetaTrait;
use App\Traits\TranslationTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AttributeValue extends WeBaseModel
{
    use HasFactory;
    // use TranslationTrait;
    use CoreMetaTrait;

    public $selected;

    protected $appends = ['selected'];

    protected $fillable = ['attribute_id', 'values', 'ordering', 'selected'];
    protected $visible = ['id', 'attribute_id', 'values', 'ordering', 'selected'];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function attribute_value_relationship()
    {
        return $this->hasMany(AttributeRelationship::class, 'attribute_value_id', 'id');
    }

    public function getSelectedAttribute()
    {
        if (empty($this->selected)) {
            $this->selected = false;
        }

        return $this->selected;
    }

    public function setSelectedAttribute($value)
    {
        $this->selected = $value;

        return $this->selected;
    }

    public function getWEFDataTypes() {
        return WEF::bundleWithGlobalWEF(apply_filters('attribute_values.wef.data-types', [
            
        ]));
    }
}
