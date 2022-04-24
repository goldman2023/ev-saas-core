<?php

namespace App\Models;

class PlanTranslation extends WeBaseModel
{
    protected $fillable = ['plan_id', 'title', 'excerpt', 'content', 'meta_title', 'meta_description', 'meta_keywords',  'lang'];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
