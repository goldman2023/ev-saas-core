<?php

namespace App\Models;

use App;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\TranslationTrait;

class AttributeValue extends EVBaseModel
{
    use HasFactory;
    use TranslationTrait;

    protected $appends = ['selected'];

    protected $fillable = ['attribute_id', 'values'];

    public static function boot() {
        parent::boot();
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function attribute_value_relationship(){
        return $this->hasMany(AttributeRelationship::class, 'attribute_value_id', 'id');
    }

    public function getSelectedAttribute() {
        return false;
    }

    public function getTranslationModel(): ?string {
        return AttributeValueTranslation::class;
    }
}
