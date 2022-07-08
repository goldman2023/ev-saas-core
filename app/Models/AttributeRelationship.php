<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use Illuminate\Database\Eloquent\Relations\MorphPivot;

class AttributeRelationship extends MorphPivot //implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory;

    protected $table = 'attribute_relationships';

    protected $fillable = ['subject_type', 'subject_id', 'attribute_id', 'attribute_value_id'];

    protected $casts = [
        'for_variations' => 'boolean',
    ];

    public function attributable()
    {
        return $this->morphTo('subject');
    }

    public function attribute_value()
    {
        return $this->belongsTo(AttributeValue::class, 'attribute_value_id', 'id');
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id', 'id');
    }
}
