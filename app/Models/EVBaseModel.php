<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Str;

class EVBaseModel extends Model
{
    protected array $core_properties = [];

    /**
     * Create a new Eloquent model instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // After this moment Model is a) booted, b) traits are initialized, c) attributes are filled from original values
        // What is left to do is define $core_properties of the newly created Model object, otherwise we'll face `Undefined property` error if we ever try to access core_property of the newly created model
        $this->initCoreProperties();
    }

    public function initCoreProperties() {
        if($this->core_properties) {
            foreach($this->core_properties as $property) {
                $this->$property = null;
            }
        }
    }

    public function appendCoreProperties($properties = [])
    {
        $this->core_properties = array_unique(
            array_merge($this->core_properties, $properties)
        );

        return $this;
    }

    public function getCoreProperties(): array
    {
        return $this->core_properties;
    }

    public function getCorePropertiesMutators(): array
    {
        return array_map(function($property) {
            return $this->getPropertyMutatorName($property);
        }, $this->core_properties);
    }

    protected function getPropertyMutatorName($name, $inverse = false) {
        if($inverse) {
            return Str::snake(ltrim(rtrim($name, 'Attribute'), 'get'));
        }

        return 'get'.Str::studly($name).'Attribute';
    }

    /**
     * Set a given attribute on the model.
     *
     * Differs from default Laravel setAttribute() by:
     * - If property being set is among $core_properties, set the property directly to instance instead of attributes array
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    public function setAttribute($key, $value): mixed
    {
        if(in_array($key, $this->getCoreProperties(), true)) {
            $this->{$key} = $value;
            return $this;
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * Get a given attribute from the model.
     *
     * There are two ways of accessing Model properties.
     * 1. Using OBJECT notation - `$model->property`
     * 2. Using ARRAY notation - `$model[property]` (This is possible because base Eloquent/Model implements ArrayAccess php interface - check https://php.net/manual/en/class.arrayaccess.php)
     *
     * Important thing to note regarding the core_properties is that:
     * 1. If you access core_property using OBJECT notation ($model->property), magic method __get() will never be called, thus getAttribute() WILL NOT be called too!
     * 2. If you access core_property using ARRAY notation ($model[property]), offsetGet() method will be called, thus getAttribute() WILL be called too!
     *
     * It is really important to override both setAttribute() and getAttribute() methods properly because laravel functions and various other packages
     * mix the usage of object and array notation when accessing model properties. We cannot rely on just one use case!!!
     *
     * @param  string  $key
     * @return mixed
     */
    public function getAttribute($key): mixed
    {
        if(in_array($key, $this->getCoreProperties(), true)) {
            return $this->{$key};
        }

        return parent::getAttribute($key);
    }

    /**
     * Handle dynamic method calls into the model.
     *
     * Differs from default Laravel __call() by:
     * - If called property mutator is for one the properties in the $core_properties, just return the core_property!
     * - get{CoreProperty}Attribute() are not defined because core_properties do not have mutators yet (if not explicitely added in some Model),
     * and calling mutators like that will throw an error instead of returning the desired core_property
     *
     * For now, all core_properties "mutations" are done when core_property is being set (if there are no explicit mutators added in the Model itself) !
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if(in_array($method, $this->getCorePropertiesMutators(), true)) {
            return $this->{$this->getPropertyMutatorName($method, true)};
        }

        return parent::__call($method, $parameters);
    }
}
