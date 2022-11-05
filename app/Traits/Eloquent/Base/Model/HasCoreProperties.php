<?php

namespace App\Traits\Eloquent\Base\Model;

trait HasCoreProperties
{
    protected array $core_properties = [];

    public function initCoreProperties(array $attributes = [], $only = [])
    {
        if (! empty($this->core_properties)) {
            foreach ($this->core_properties as $property) {
                if (empty($only) || in_array($property, $only, true)) {
                    if (isset($attributes[$property])) {
                        $this->{$property} = $attributes[$property];
                    } else {
                        $this->$property = null;
                    }
                }
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
        return array_map(function ($property) {
            return $this->getPropertyMutatorName($property);
        }, $this->core_properties);
    }

    public function getDynamicUploadPropertiesMutators(): array
    {
        if(method_exists($this, 'getDynamicModelUploadProperties')) {
            return array_map(function ($property) {
                return $this->getPropertyMutatorName($property);
            }, array_column($this->getDynamicModelUploadProperties(), 'property_name'));
        }

        return [];
    }

    /*
     * Append core properties to Array along with attributes and relations properties!
     */
    public function corePropertiesToArray(): array
    {
        $core_properties = [];
        foreach ($this->getCorePropertiesMutators() as $core_property_mutator) {
            $core_properties[$this->getPropertyMutatorName($core_property_mutator, true)] = $this->{$core_property_mutator}();
        }

        return $core_properties;
    }

    /*
     * Remove Core Properties from attributesToArray() function returned data!
     */
    public function attributesToArray()
    {
        $all_attributes = parent::attributesToArray();
        $core_properties = array_fill_keys($this->getCoreProperties(), null);

        return array_diff_key($all_attributes, $core_properties);
    }
}
