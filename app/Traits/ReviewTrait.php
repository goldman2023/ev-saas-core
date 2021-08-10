<?php


namespace App\Traits;


use App\Models\ReviewRelationship;

trait ReviewTrait
{
    public function reviews(){
        return $this->morphMany(ReviewRelationship::class, 'subject');
    }
}
