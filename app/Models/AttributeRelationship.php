<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;

class AttributeRelationship extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory, Auditable;
    public function attributable()
    {
        return $this->morphTo("subject");
    }
    public function attribute_value()
    {
        return $this->belongsTo(AttributeValue::class, 'attribute_value_id', 'id');
    }
    public function attributes(){
        return $this->belongsTo(Attribute::class, 'attribute_id', 'id');
    }
}
