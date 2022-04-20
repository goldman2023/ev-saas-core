<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AttributeValuesSelected implements Rule
{
    public $pretty_name;

    /**
     * Determine if the validation rule passes.
     *
     * Check if any attribute value of the selected attribute is selected.
     * E.g: If user selected color as an attribute but didn't specify any values, fail the validation
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->pretty_name = $value['name'] ?? $attribute;

        // If attribute is selected, check it
        if (($value['selected'] ?? null) || ($value['for_variations'] ?? null)) {
            $att_values = $value['attribute_values'];
            $passed = false;

            // Try to find at least one selected attribute value, otherwise it cannot pass!
            if ($att_values) {
                foreach ($att_values as $val) {
                    if ($val['selected'] ?? null) {
                        $passed = true;
                    }
                }
            }

            return $passed;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return translate('The '.$this->pretty_name.' cannot be empty. You must select at least one value.');
    }
}
