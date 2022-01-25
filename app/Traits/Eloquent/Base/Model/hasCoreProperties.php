<?php

namespace App\Traits\Eloquent\Base\Model;

trait hasCoreProperties
{
    protected array $core_properties = [];

    public function initCoreProperties($only = []) {
        if(!empty($this->core_properties)) {
            foreach($this->core_properties as $property) {
                if(empty($only) || in_array($property, $only, true)) {
                    $this->$property = null;
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
        return array_map(function($property) {
            return $this->getPropertyMutatorName($property);
        }, $this->core_properties);
    }

    /*
     * Append core properties to Array along with attributes and relations properties!
     */
    public function corePropertiesToArray(): array
    {
        $core_properties = [];
        foreach($this->getCorePropertiesMutators() as $core_property_mutator) {
            $core_properties[$this->getPropertyMutatorName($core_property_mutator, true)] = $this->{$core_property_mutator}();
        }

        return $core_properties;
    }
}
