<?php

namespace App\Traits;

use AttributesService;
use App\Models\Product;
use App\Models\Attribute;
use App\Builders\BaseBuilder;
use App\Models\AttributeValue;
use App\Models\AttributeRelationship;
use Illuminate\Database\Eloquent\Collection;
use App\Support\Eloquent\Relations\CustomAttributesRelation;

trait AttributeTrait
{
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;

    /**
     * Initialize the trait
     *
     * @return void
     */
    public function initializeAttributeTrait(): void
    {

    }

    /**
     * Boot the trait
     *
     * @return void
     */
    protected static function bootAttributeTrait()
    {
        // static::addGlobalScope('withCustomAttributes', function (mixed $builder) {
        //     // Load all custom attributes along with theirs relations and values!
        //     $builder->with(['custom_attributes']);
        // });

        // When model data is retrieved, populate custom_attributes!
        static::relationsRetrieved(function ($model) {

            // custom_attributes are LAZY LOADED after relations are retrieved! But use on query to get all attributes for now!
            // TODO: Create eager loading somehow through CustomAttributesRelation addEagerConstraints() and match()!
            if (!$model->relationLoaded('custom_attributes')) {
                $model->setRelation(
                    'custom_attributes',
                    $model->custom_attributes()->get()
                );
            }

            /**
             * This part of the code is run before relationsRetreived event callback in VariationTrait (because AttributeTrait must be used/declared before VariationTrait)
             * Reason for this is: Since we are eager-loading custom_attributes using hasMany relation, we need to change it's retreived data to follow this structure:
             * 1. From: AttributeRelationship -> 1) AttributeValue, 2) Attribute
             * 2. To: Attribute -> 1) AttributeRelationships, 2) AttributeValues
             */

            // $attributes = new \Illuminate\Database\Eloquent\Collection();

            // if(($model->custom_attributes?->isNotEmpty() ?? false)) {

            //     foreach($model->custom_attributes as $key => $att) {
            //         $att_rel = $att->pivot;

            //         // Insert attribute from $att_rel to $attributes if attribute being inserted is not in it
            //         if(! $attributes->contains(fn($item) => ($item?->id ?? null) === $att->id)) {
            //             $attributes->push($att);
            //         }

            //         // Find attribute by key in $attributes collection
            //         // try {
            //             $att_key = $attributes->search(fn($item) => ($item?->id ?? null) === $att->id);
            //             $main_att = $attributes->get($att_key);
            //         // } catch(\Throwable $e) {
            //         //     dd($model->custom_attributes);
            //         // }

            //         // Push $att_rel to attribute's attribute_relationships relationship
            //         if($main_att->relationLoaded('attribute_relationships')) {
            //             $main_att->setRelation('attribute_relationships', $main_att->attribute_relationships->push($att->pivot));
            //         } else {
            //             $main_att->setRelation('attribute_relationships', new \Illuminate\Database\Eloquent\Collection([$att->pivot]));
            //         }

            //         // Push attribute_value to attribute's attribute_values relationship
            //         if($main_att->relationLoaded('attribute_values')) {
            //             $main_att->setRelation('attribute_values', $main_att->attribute_values->push($att->pivot->attribute_value));
            //         } else {
            //             $main_att->setRelation('attribute_values', new \Illuminate\Database\Eloquent\Collection([$att->pivot->attribute_value]));
            //         }
            //     }

            //     // Set custom_attributes relation with changed data structure
            //     $model->setRelation('custom_attributes', $attributes);
            // }
        });
    }

    public function custom_attributes_grouped($hideEmptyGroups = true)
    {
        $att_groups = AttributesService::getGroups($this->shop ?? null);
        $custom_attributes = $this->custom_attributes;

        $att_groups = $att_groups->each(function ($group) use (&$custom_attributes) {
            $items_in_group = $custom_attributes->where('group_id', $group->id);
            $group->custom_attributes = $items_in_group;
            $custom_attributes = $custom_attributes->whereNotIn('group_id', $group->id);
        })->keyBy('name');

        // Add attributes without group to `generic` column
        $generic_group = AttributesService::newGroupInstance($custom_attributes);
        $att_groups->put($generic_group->name, $generic_group);

        return $hideEmptyGroups ? $att_groups->filter(fn ($item) => ($item->custom_attributes instanceof \Illuminate\Support\Collection ? $item->custom_attributes->isNotEmpty() : ! empty($item->custom_attributes))) : $att_groups;
    }

    public function custom_attributes()
    {
        return new CustomAttributesRelation($this);
        // return $this->morphToMany(Attribute::class, 'subject', 'attribute_relationships', null, 'attribute_id')
        //     ->with('pivot.attribute_value')
        //     ->withPivot('for_variations', 'attribute_value_id', 'order')
        //     ->using('App\Models\AttributeRelationship');

        // return $this->hasMany(AttributeRelationship::class, 'subject_id')->where('subject_type', $this::class)
        //         ->withOnly(['attribute_value', 'attribute']);
    }

    public function scopeWhereCustomAttributes($query, $selected_attributes = []) {
        if(empty($selected_attributes)) {
            $selected_attributes = AttributesService::castFilterableProductAttributesFromQueryParams(remove_inactive: true)['selected_attributes'] ?? [];
        }

        if(!empty($selected_attributes)) {
            foreach($selected_attributes as $slug => $value) {
                // New approach when custom_attributes are CustomAttributesRelation: CustomAttributesRelation class
                if(is_array($value) || is_numeric($value) || ctype_digit($value)) {
                    // TODO: check for SQL injection here ssince we are using RAW
                    $exists_string = \Str::replaceArray('?', [
                        addslashes($this::class),
                        $slug,
                        implode(',', !is_array($value) ? [$value] : $value)
                    ], 'exists (select * from `attributes` inner join `attribute_relationships` on `attributes`.`id` = `attribute_relationships`.`attribute_id` where `products`.`id` = `attribute_relationships`.`subject_id` and `attribute_relationships`.`subject_type` = \'?\' and (`slug` = \'?\' and `attribute_relationships`.`attribute_value_id` in (?)))');
                } else {
                    $exists_string = \Str::replaceArray('?', [
                        addslashes($this::class),
                        $slug,
                        is_bool($value) ? ((int) $value) : ('\''.$value.'\'')
                    ], 'exists (select * from `attributes` inner join `attribute_relationships` on `attributes`.`id` = `attribute_relationships`.`attribute_id` inner join `attribute_values` on `attribute_relationships`.`attribute_value_id` = `attribute_values`.`id` where `products`.`id` = `attribute_relationships`.`subject_id` and `attribute_relationships`.`subject_type` = \'?\' and (`slug` = \'?\' and `attribute_values`.`values` = ?))');
                }

                $query->whereRaw($exists_string);
            }

            // dd(\Str::replaceArray('?', $query->getBindings(), $query->toSql()));

            // OLD APPROACH with Eloquent Query!
            // dd($query->whereHas('custom_attributes', function($query) use($selected_attributes) {
            //     foreach($selected_attributes as $slug => $value) {
            //         $query->where(function($query) use($slug, $value) {
            //             return $query->where('slug', $slug)
            //                 ->when(is_array($value), function ($q) use ($value) {
            //                     return $q->whereIn('attribute_relationships.attribute_value_id', $value);
            //                 })
            //                 ->when(!is_array($value), function ($q) use ($value) {
            //                     return $q->where('attribute_relationships.attribute_value_id', $value);
            //                 });
            //         });
            //     }
            // })->toSql());
        }
    }

    public function getAttr($slug_or_id = null, $content_type = null) {
        if(empty($slug_or_id)) return null;
        if(empty($content_type)) $content_type =  $this::class;

        if(is_int($slug_or_id) || ctype_digit($slug_or_id)) {
            return $this->custom_attributes->firstWhere('id', (int) $slug_or_id);
        } else if(is_string($slug_or_id)) {
            return $this->custom_attributes->firstWhere('slug', $slug_or_id);
        }

        return $this->custom_attributes->firstWhere('identificator', $slug_or_id.'|'.$content_type);
    }

    public function getAttrValue($slug_or_id = null, $content_type = null) {
        if(empty($slug_or_id)) return null;
        if(empty($content_type)) $content_type =  $this::class;

        if(is_int($slug_or_id) || ctype_digit($slug_or_id)) {
            return $this->custom_attributes->firstWhere('id', (int) $slug_or_id)->attribute_values->first()->values;
        } else if(is_string($slug_or_id)) {
            $attribute =  $this->custom_attributes->firstWhere('slug', $slug_or_id);
            if($attribute) {
                return $attribute->attribute_values->first()->values;
            } else {
                return null;
            }
        }

        return $this->custom_attributes->firstWhere('identificator', $slug_or_id.'|'.$content_type)->attribute_values->first()->values;
    }

    /**
     * deleteCustomAttributes
     *
     * This function goes through model's custom attributes and removes all relationships to the $model
     * and attribute values if attribute is not predefined.
     *
     * Logic is based on attribute `is_predefined` condition:
     * 1. Attribute is predefined - since attribute values for such attribute are shared between many relationships, we are removing ONLY RELATIONSHIPS, and NOT the VALUES
     * 2. Attribute is NOT predefined - we are removing both RELATIONSHIPS and VALUES (because attribute values in this case are exclusive to relationship and $model)
     *
     * IMPORTANT: attribute_relationships inside custom_attributes are PIVOT dynamic models which means that they lack id's (primary key)
     * @return void
     */
    public function deleteCustomAttributes() {
        foreach($this->custom_attributes as $attribute) {
            if($attribute->is_predefined) {
                AttributeRelationship::where([
                    ['subject_id', $this->id],
                    ['subject_type', $this::class],
                ])->delete();
            } else {
                AttributeValue::destroy($attribute->attribute_values->pluck('id'));
                AttributeRelationship::where([
                    ['subject_id', $this->id],
                    ['subject_type', $this::class],
                ])->delete();
            }
        }
    }

    public function seo_attributes()
    {
        return $this->custom_attributes->filter(function ($att, $index) {
            return $att->is_schema === true;
        })->values();
    }

    public function admin_attributes()
    {
        return $this->custom_attributes->filter(function ($att, $index) {
            return $att->is_admin === true;
        })->values();
    }

    public function filterable_attributes($key_by = null)
    {
        $attributes = $this->custom_attributes->filter(function ($att, $index) {
            return $att->filterable === true;
        })->values();

        if (! empty($key_by)) {
            return $attributes->keyBy($key_by);
        }

        return $attributes;
    }

    public function variant_attributes($key_by = null)
    {
        $attributes = $this->custom_attributes->filter(function ($att, $index) {
            return $att->attribute_relationships->first()->for_variations === true;
        })->values();

        if (!empty($key_by)) {
            return $attributes->keyBy($key_by);
        }

        return $attributes;
    }

    /**********************************
     * Other Attributes Functions *
     **********************************/

    /**
     * Maps all the attributes with or without relations/values to one array.
     * This type of data is used in Livewire forms mostly because it contains
     * both attributes which are not set for the current product (no relations to this product)
     * and attributes which are related. This is important for Forms! We need all possible attributes for the product displayed,
     * whether their value is set or not!
     *
     * @param bool $return_object
     * @return mixed
     */
    public function getMappedAttributes(bool $return_object = true, $custom_content_type = null)
    {
        // Get mapped attributes to display them in form select element for specific content type
        $attrs = null;

        if (! empty($this->id)) {
            // For existing content type:
            // 1. Get attributes for that content type
            // 2. DO NOT fetch attribute relationships and attribute_values
            $attrs = Attribute::without('attribute_values')->with('attribute_relationships', function ($query) {
                $query->where([
                    ['subject_type', '=', $this::class],
                    ['subject_id', '=', $this->id],
                ])->select('id', 'subject_type', 'subject_id', 'attribute_id', 'attribute_value_id', 'for_variations');
            })->select('id', 'name', 'type', 'custom_properties');

            // Select Attributes of provided custom_content_type, otherwise use current model type
            if(!empty($custom_content_type)) {
                $attrs = $attrs->where('content_type', $custom_content_type);
            } else {
                $attrs = $attrs->where('content_type', $this::class);
            }

            $attrs = $attrs->get()->toArray();

            // 3. GET attribute values ids based on all attribute relationships
            $attrs_values_idx = [];
            foreach ($attrs as $key => $att) {
                $attrs[$key]['attribute_values'] = [];

                if (! empty($att['attribute_relationships'])) {
                    foreach ($att['attribute_relationships'] as $attr_rel) {
                        // Add attribute value id to array (we'll need those to query selected/typed att values from DB)
                        $attrs_values_idx[] = $attr_rel['attribute_value_id'];

                        // Determine if used for variations
                        $attrs[$key]['for_variations'] = $attr_rel['for_variations'] ?? false;
                    }
                }
            }

            // 4. Fetch ONLY attribute values for dropdown, checkbox, radio attribute types
            $relevant_attrs_idx = collect($attrs)->filter(fn ($value, $key) => $value['is_predefined'])->pluck('id')->all();
            $predefined_attrs_values = collect(AttributeValue::whereIn('attribute_id', $relevant_attrs_idx)->select('id', 'attribute_id', 'values')->get()->toArray())->groupBy('attribute_id')->transform(fn ($item, $key) => $item->keyBy('id')->toArray())->all();

            // 5. FETCH attribute values based on att. values ids provided from previously queried relationships
            $attrs_values = collect(AttributeValue::whereIn('id', $attrs_values_idx)->select('id', 'attribute_id', 'values')->get()->toArray())->transform(function ($item, $key) {
                $item['selected'] = true;

                return $item;
            })->groupBy('attribute_id')->transform(fn ($item, $key) => $item->keyBy('id')->toArray())->all();

            // 6. Replace & merge recursively predefined values with selected attribute values
            // Note: Since attributes are grouped by keys and attribute values indexes are actually values IDs for both arrays,
            // we'll have an array of all attributes and their predefined and selected/typed values for specific content type
            // Such array is real representation of possible values and selected/typed values
            $real_values = array_replace_recursive($predefined_attrs_values, $attrs_values);

            // 6. Merge selected att values to their corresponding attributes
            foreach ($attrs as $key => $item) {
                if (isset($real_values[$item['id']])) {
                    $attrs[$key]['attribute_values'] = array_values(collect($real_values[$item['id']])->toArray());
                }
            }
        } else {
            // For new content type:
            // 1. Get attributes for that content type
            // 2. DO NOT fetch attribute relationships and attribute_values
            $attrs = Attribute::without('attribute_relationships', 'attribute_values')->select('id', 'name', 'type', 'custom_properties')->where('content_type', $this::class)->get()->toArray();
            $relevant_attrs_idx = collect($attrs)->filter(fn ($value, $key) => $value['is_predefined'])->pluck('id')->all();

            // 3. Fetch ONLY attribute values for dropdown, checkbox, radio attribute types
            $predefined_attrs_values = collect(AttributeValue::whereIn('attribute_id', $relevant_attrs_idx)->select('id', 'attribute_id', 'values')->get()->toArray())->groupBy('attribute_id')->all();

            // 4. Merge predefined values to their corresponding attributes
            foreach ($attrs as $key => $item) {
                if (isset($predefined_attrs_values[$item['id']])) {
                    $attrs[$key]['attribute_values'] = collect($predefined_attrs_values[$item['id']])->toArray();
                }
            }
        }

        // Map the attributes to be used in livewire forms
        $mapped = [];

        if (! empty($attrs)) {
            foreach ($attrs as $att) {
                $att_object = $return_object ? (object) $att : $att;

                if ($return_object) {
                    $att_object->selected = true; // All attributes are selected by default
                    $att_object->for_variations = ! empty($this->id) ? ($att_object->for_variations ?? false) : false; // false if create, stays the same as previously defined on edit
                    $mapped['attribute.'.$att_object->id] = $att_object;
                } else {
                    $mapped['attribute.'.$att->id] = (object) array_merge($att_object, [
                        'selected' => true, // All attributes are selected by default
                        'for_variations' => ! empty($this->id) ? ($att_object['for_variations'] ?? false) : false,  // false if create, stays the same as previously defined on edit
                    ]);
                }
            }
        }
        // if($this instanceof \App\Models\OrderItem) {
        //     dd($mapped);
        // }
        return $mapped;
    }

    /*
     * Matrix can be consisted of array of arrays OR array of AttributeValues.
     * 1) Array of arrays - when there is more than one attribute used for variations
     * 2) Array of AttributeValues - when there is one attribute used for variations
     *
     * IMPORTANT: DO NOT STORE $variant_data items under $keys which are not default, like: $variant_data[$value->attribute_id]
     * REASON: When php data is printed in livewire component js, array keys will be reset, which produces different $variant data and throws checksum error
     * `17 => ['attribute_id' => 17, 'attribute_value_id' => 45]` becomes `0 => ['attribute_id' => 17, 'attribute_value_id' => 45]`
     * This is clearly different when JS data is sent to PHP and checksum error is thrown!!!
     * Use classic array keys (0,1,2...) OR string keys instead of integer IDs as keys because JS resets integer keys to go from 0!!!!! VERY IMPORTANT!!!!
     */
    public function generateVariantAttributeValuesMatrix()
    {
        $result = [];
        $all_att_values = $this->variant_attributes()->pluck('attribute_values');

        foreach ($all_att_values as $index => $group) {
            if ($index === 0) {
                $result = $group;
            } else {
                $result = $result->crossJoin($group);
            }
        }

        return $result;
    }

    public function get_attribute_value_by_id($id)
    {
        return AttributeValue::where('attribute_id', $id)->get();
    }
}
