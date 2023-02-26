<?php

namespace App\Traits\Livewire;

use Categories;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\AttributeRelationship;
use App\Models\AttributeValueTranslation;

trait HasAttributes
{
    public $custom_attributes;
    public $selected_predefined_attribute_values;

    public function initializeHasAttributes()
    {
        
    }

    public static function initAttributes(&$model, &$custom_attributes, &$selected_predefined_attribute_values, $custom_content_type = null) {
        attributes_form_friendly_mapping($model, $custom_attributes, $selected_predefined_attribute_values, $custom_content_type);
        
        self::initPredefinedAttributeValues($model, $custom_attributes, $selected_predefined_attribute_values);
    }

    public static function initPredefinedAttributeValues(&$model, &$custom_attributes, &$selected_predefined_attribute_values)
    {
        predefined_attributes_form_friendly_mapping($model, $custom_attributes, $selected_predefined_attribute_values);
    }

    public function refreshAttributes(&$model)
    {
        self::initAttributes($model, $this->custom_attributes, $this->selected_predefined_attribute_values);
    }


    /**
     * @throws \Exception
     */
    protected function setAttributes(&$model, $custom_attributes = null, $selected_predefined_attribute_values = null)
    {
        
        if(empty($custom_attributes)) {
            $custom_attributes = $this->custom_attributes;
        }

        $selected_attributes = collect($custom_attributes)->filter(function ($att, $key) {
            $att = (object) $att;

            return $att->selected === true;
        });

        if ($selected_attributes) {
            foreach ($selected_attributes as $att) {
                $attribute = new Attribute();

                $att = (object) $att;
                $att_values = $att->attribute_values;

                if (! empty($att_values)) {

                    // Is-predefined attributes are dropdown/radio/checkbox and they have predefined values
                    // while other types have only one item in values array - with an ID (existing value) or without ID (not yet added value, just default template)
                    if (! $att->is_predefined) {
                        // Freestyle attributes
                        
                        foreach ($att_values as $key => $att_value) {
                            if ($att_value['values'] === null) { // Reason for this comparison is that values can be 1 or 0 for boolean - so we cannot use empty() function!!!
                                // If value is empty, unset it and later on reset array_values
                                unset($att_values[$key]);
                                continue;
                            }

                            $attribute_value_row = (! empty($att_value['id'])) ? AttributeValue::find($att_value['id']) : new AttributeValue();

                            // Create the value first
                            $attribute_value_row->attribute_id = (! empty($att_value['id'])) ? $attribute_value_row->attribute_id : $att->id;
                            $attribute_value_row->values = $att_value['values'] ?? null;
                            $attribute_value_row->selected = true;
                            $attribute_value_row->save();

                            // // Set attribute value translations for non-predefined attributes
                            // $attribute_value_translation = AttributeValueTranslation::firstOrNew(['lang' => config('app.locale'), 'attribute_value_id' => $attribute_value_row->id]);
                            // $attribute_value_translation->name = $att_value['values'] ?? null;
                            // $attribute_value_translation->save();

                            $att_values[$key] = $attribute_value_row;
                        }
                    } else {
                        // Predefined attributes

                        if(!empty($selected_predefined_attribute_values)) {
                            $selected_attribute_values = $selected_predefined_attribute_values['attribute.'.$att->id] ?? [];
                        } else {
                            $selected_attribute_values = $this->selected_predefined_attribute_values['attribute.'.$att->id] ?? [];
                        }

                        foreach ($att_values as $key => $att_value) {
                            $attribute_value_row = AttributeValue::find($att_value['id']);

                            if (is_array($selected_attribute_values) && in_array($attribute_value_row->id, $selected_attribute_values)) {
                                $attribute_value_row->selected = true;
                            } elseif (is_numeric($selected_attribute_values) && ((int) $selected_attribute_values) == $att_value['id']) {
                                $attribute_value_row->selected = true;
                            } else {
                                $attribute_value_row->selected = false;
                            }

                            $att_values[$key] = $attribute_value_row;
                        }
                    }

                    $att_values = array_values($att_values);

                    foreach ($att_values as $key => $att_value) {
                        if ($att_value->id ?? null) {

                            if ($att_value->selected ?? null) {
                                // Create or find product-attribute relationship, but don't yet persist anything to DB (hence firstOrNew, not firstOrCreate)
                                $att_rel = AttributeRelationship::firstOrNew([
                                    'subject_type' => $model::class,
                                    'subject_id' => $model->id,
                                    'attribute_id' => $att->id,
                                    'attribute_value_id' => $att_value->id,
                                ]);
                                $att_rel->for_variations = $att->type === 'dropdown' ? $att->for_variations : false;
                                
                                if ($att->type === 'text_list') {
                                    $att_rel->order = $key; // respect order for the text_list
                                }

                                $att_rel->save();
                            } else {
                                // Remove attribute relationship if "selected" is false/null
                                AttributeRelationship::where([
                                    'subject_type' => $model::class,
                                    'subject_id' => $model->id,
                                    'attribute_id' => $att->id,
                                    'attribute_value_id' => $att_value->id,
                                ])->delete();
                            }
                        }
                    }
                }
            }
        }
    }

    public function saveAttributes($minimum_required = false)
    {
        // Validate minimum required fields and insert/update row!
        // $this->validateData('minimum_required');

        $this->validateData('attributes');

        DB::beginTransaction();

        try {
            $this->setAttributes();

            $this->toastify(translate('Attributes successfully saved!'), 'success');
        } catch (\Exception $e) {
            DB::rollBack();

            $this->dispatchGeneralError(translate('There was an error while saving attributes.'));
            $this->inform(translate('There was an error while saving attributes.'), $e->getMessage(), 'fail');
        }
    }
}
