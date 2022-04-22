<?php

namespace App\Models;

use App\Builders\BaseBuilder;
use App\Traits\Eloquent\Base\Model\hasCoreProperties;
use Illuminate\Database\Eloquent\Model;
use Str;
use Spatie\Activitylog\LogOptions;


class EVBaseModel extends Model
{
    use hasCoreProperties;

//    public ?array $eagerLoaded = [];

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
        $this->initCoreProperties($attributes);
    }

    /**
     * Fill the model with an array of attributes. Force mass assignment.
     *
     * TODO: ->fill() function should also use initCoreProperties where it fills core properties using given attributes!!!
     * This is needed for alpineJS/Livewire core_properties model binding to work properly!
     *
     * @param  array  $attributes
     * @return $this
     */
    public function forceFill(array $attributes = [])
    {
        parent::forceFill($attributes); // Fill standard Laravel attributes
        $this->initCoreProperties($attributes); // Fill core_properties with passed data

        return $this; // Must return $this object
    }

    /**
     * Replace Eloquent/Builder with BaseBuilder (an extension of Eloquent/Builder with more features)
     *
     * @param    \Illuminate\Database\Query\Builder  $query
     * @return  BaseBuilder
     */
    public function newEloquentBuilder($query)
    {
        return new BaseBuilder($query);
    }

    protected function getPropertyMutatorName($name, $inverse = false)
    {
        if ($inverse) {
            return Str::snake(s($name)->replaceFirst('get', '')->replaceLast('Attribute', '')->__toString());
        }

        return 'get'.Str::studly($name).'Attribute';
    }

    /**
     * Convert the model instance to an array.
     *
     * NOTE: we need to include Core properties too!
     *
     * @return array
     */
    public function toArray()
    {
        return array_merge(parent::toArray(), $this->corePropertiesToArray());
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
        if (in_array($key, $this->getCoreProperties(), true)) {
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
        if (in_array($key, $this->getCoreProperties(), true)) {
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
        if (in_array($method, $this->getCorePropertiesMutators(), true)) {
            return $this->{$this->getPropertyMutatorName($method, true)};
        }

        return parent::__call($method, $parameters);
    }

    /**
     * Get the observable event names.
     *
     * Added:
     * 1. relationsRetrieved - Event which is fired after Models relations are added
     * @return array
     */
    public function getObservableEvents()
    {
        return array_merge(
            parent::getObservableEvents(),
            [
                'relationsRetrieved',
            ]
        );
    }

    /**
     * Register a relationsRetrieved model event with the dispatcher.
     *
     * @param  \Closure|string  $callback
     * @return void
     */
    public static function relationsRetrieved($callback)
    {
        static::registerModelEvent('relationsRetrieved', $callback);
    }

    /**
     * Fire the given event for the model.
     *
     * Method has to be public in order to call it from Builder.
     *
     * @param  string  $event
     * @param  bool  $halt
     * @return mixed
     */
    public function fireModelEvent($event, $halt = true)
    {
        return parent::fireModelEvent($event, $halt);
    }

    public function scopeNoEagerLoads($query)
    {
        return $query->setEagerLoads([]);
    }


    /* Default Log */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }
}
