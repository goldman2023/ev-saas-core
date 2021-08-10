<?php


namespace App\Traits;


use App\Models\AttributeRelationship;

trait AttributeTrait
{
    public function attributes(){
        return $this->morphMany(AttributeRelationship::class, 'subject');
    }

    public function seo_attributes() {
        return $this->morphMany(AttributeRelationship::class, 'subject')
                    ->whereHas('attributes', function ($attribute) {
                        $attribute->where('is_schema', true);
                    });
    }
}
