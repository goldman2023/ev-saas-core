<?php
namespace App\Support\Eloquent\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
 
class JsonData implements CastsAttributes {

    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return array
     */
    public function get($model, $key, $value, $attributes)
    {
        if(!empty($value) && is_string($value)) {
            return json_decode($value, true);
        }

        return []; // always return empty array for better handling (instead of null)
    }
 
    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  array  $value
     * @param  array  $attributes
     * @return string
     */
    public function set($model, $key, $value, $attributes)
    {
        if(!is_array($value) && !is_object($value)) {
            return null; // save as null in DB
        }
        
        return json_encode($value); // save as JSON string in DB
    }
}
