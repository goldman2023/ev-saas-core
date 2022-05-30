<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryRelationship extends WeBaseModel
{
    use HasFactory;

    protected $fillable = ['subject_type', 'subject_id', 'category_id'];

    public $timestamps = false;

    public function subject()
    {
        return $this->morphTo('subject');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
