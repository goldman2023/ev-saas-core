<?php


namespace App\Traits;


use App\Models\AttributeRelationship;

trait LoggingTrait
{
    /**
     * used to provide easy logging experience
     * @param $caused_on
     * @param $description
     * @param array $properties_array
     */
    public function log($caused_on, $description, array $properties_array = []){
        activity()
            ->on($caused_on)
            ->by(\auth()->user())
            ->withProperties($properties_array)
            ->log($description);
    }
    public function simpleLog($message){
        activity()->log($message);
    }
}
