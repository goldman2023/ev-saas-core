<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValueTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'lang', 'attribute_value_id'];
}
