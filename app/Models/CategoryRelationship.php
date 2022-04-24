<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;

class CategoryRelationship extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory, Auditable;

    public function subject()
    {
        return $this->morphTo('subject');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
