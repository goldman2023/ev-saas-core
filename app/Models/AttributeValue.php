<?php

namespace App\Models;

use App;
use App\Traits\TranslationTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends EVBaseModel
{
    use HasFactory;
    use TranslationTrait;

    public $selected;

    protected $appends = ['selected'];

    protected $fillable = ['attribute_id', 'values', 'selected'];

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

    public function getTranslationModel(): ?string
    {
        return AttributeValueTranslation::class;
    }
}
