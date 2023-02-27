<?php

use App\Models\Attribute;
use App\Traits\AttributeTrait;

if (!function_exists('attributes_form_friendly_mapping')) {
    function attributes_form_friendly_mapping(&$model, &$custom_attributes, &$selected_predefined_attribute_values, $custom_content_type = null)
    {
        $custom_attributes = $model->getMappedAttributes(custom_content_type: $custom_content_type);
        $selected_predefined_attribute_values = [];
        
        // Set default attributes
        foreach ($custom_attributes as $key => $attribute) {
            if ($attribute->is_predefined) {
                $attribute->selcted_values = '';
            }

            if (empty($custom_attributes[$key]->attribute_values)) {
                if (! $attribute->is_predefined) {
                    $custom_attributes[$key]->attribute_values[] = [
                        'id' => null,
                        'attribute_id' => $attribute->id,
                        'values' => '',
                        'selected' => true,
                    ];
                } else {
                    $custom_attributes[$key]->attribute_values = [];
                }
            }
        }
    }
}

if (!function_exists('predefined_attributes_form_friendly_mapping')) {
    function predefined_attributes_form_friendly_mapping(&$model, &$custom_attributes, &$selected_predefined_attribute_values)
    {
        $product_attributes = $model->custom_attributes()->get();

        // Set predefined attribute values AND select specific values if it's necessary
        foreach ($custom_attributes as $attribute) {
            if ($attribute->is_predefined) {
                if (isset($model->id) && ! empty($model->id)) {
                    
                    $product_attribute = $product_attributes->firstWhere('id', $attribute->id);

                    if ($product_attribute instanceof Attribute) {
                        $selected_predefined_attribute_values['attribute.'.$attribute->id] = $product_attribute->attribute_values->pluck('id')->toArray();
                    } else if(is_array($product_attribute) && !empty($product_attribute) && !empty($product_attribute?->custom_attributes ?? [])) {
                        $selected_predefined_attribute_values['attribute.'.$attribute->id] = collect($product_attribute->attribute_values)->pluck('id')->toArray();
                    } else {
                        $selected_predefined_attribute_values['attribute.'.$attribute->id] = [];
                    }
                } else {
                    // insert product
                    $selected_predefined_attribute_values['attribute.'.$attribute->id] = [];
                }
            }
        }
    }
}

if (!function_exists('serialize_with_form_friendly_custom_attributes')) {
    function serialize_with_form_friendly_custom_attributes($model)
    {
        if(class_has_trait($model::class, AttributeTrait::class)) {
            $custom_attributes = [];
            $selected_predefined_attribute_values = [];
            
            attributes_form_friendly_mapping($model, $custom_attributes, $selected_predefined_attribute_values);
            predefined_attributes_form_friendly_mapping($model, $custom_attributes, $selected_predefined_attribute_values);
            
            $model_array = $model->toArray();
            $model_array['custom_attributes'] = $custom_attributes;
            $model_array['selected_predefined_attribute_values'] = $selected_predefined_attribute_values;

            return $model_array;
        }
        
        return $model->toArray();
    }
}