<?php
namespace App\Traits;


use App\Builders\BaseBuilder;
use App\Models\Attribute;
use App\Models\AttributeRelationship;
use App\Models\AttributeValue;
use App\Models\Product;
use AttributesService;
use Illuminate\Database\Eloquent\Collection;

trait AttributeTrait
{
    /**
     * Boot the trait
     *
     * @return void
     */
    protected static function bootAttributeTrait()
    {
        static::addGlobalScope('withCustomAttributes', function (mixed $builder) {
            // Load all custom attributes along with theirs relations and values! Attribute -> Relations -> Values
//             $builder->with(['custom_attributes']);
        });

        // When model data is retrieved, populate model prices data!
        static::relationsRetrieved(function ($model) {
            // TODO: FIX EAGER LOAD OF CUSTOM ATTRIBUTES. It still does not eager load...
            if(!$model->relationLoaded('custom_attributes')) {
//                $model->load('custom_attributes');
            }
        });
    }

    public function custom_attributes_grouped($hideEmptyGroups = true) {
        $att_groups = AttributesService::getGroups($this->shop ?? null);
        $custom_attributes = $this->custom_attributes;

        $att_groups = $att_groups->each(function ($group) use(&$custom_attributes) {
            $items_in_group = $custom_attributes->where('group_id', $group->id);
            $group->custom_attributes = $items_in_group;
            $custom_attributes = $custom_attributes->whereNotIn('group_id', $group->id);
        })->keyBy('name');

        // Add attributes without group to `generic` column
        $generic_group = AttributesService::newGroupInstance($custom_attributes);
        $att_groups->put($generic_group->name, $generic_group);

        return $hideEmptyGroups ? $att_groups->filter(fn($item) => ($item->custom_attributes instanceof \Illuminate\Support\Collection ? $item->custom_attributes->isNotEmpty() : !empty($item->custom_attributes))) : $att_groups;
    }

    public function custom_attributes()
    {
//        if($this instanceof Product) {
//            dd($this);
//        }

        return $this->morphToMany(Attribute::class, 'subject', 'attribute_relationships', null, 'attribute_id')
            ->distinct()
            ->withOnly([
            'attribute_values' => function($query) {
                $query->where([
                    ['subject_id', '=', $this->id],
                    ['subject_type', '=', $this::class]
                ]);
            },
            'attribute_relationships' => function($query) {
                $query->where([
                    ['subject_id', '=', $this->id],
                    ['subject_type', '=', $this::class]
                ]);
            },
            ])
            ->withPivot('for_variations');
    }

    public function seo_attributes() {
        return $this->custom_attributes->filter(function($att, $index) {
            return $att->is_schema === 1;
        })->values();
    }

    public function admin_attributes() {
        return $this->custom_attributes->filter(function($att, $index) {
            return $att->is_admin === 1;
        })->values();
    }

    public function filterable_attributes($key_by = null) {
        $attributes = $this->custom_attributes->filter(function($att, $index) {
            return $att->filterable === 1;
        })->values();

        if(!empty($key_by)) {
            return $attributes->keyBy($key_by);
        }

        return $attributes;
    }

    public function variant_attributes($key_by = null)
    {

        $attributes =  $this->custom_attributes->filter(function($att, $index) {
            return $att->pivot->for_variations === 1;
        })->values();

        if(!empty($key_by)) {
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
    public function getMappedAttributes(bool $return_object = true) {
        // Get mapped attributes to display them in form select element for specific content type
        $attrs = null;

        if(!empty($this->id)) {
            // For existing content type:
            // 1. Get attributes for that content type
            // 2. DO NOT fetch attribute relationships and attribute_values
            $attrs = Attribute::without('attribute_values')->with('attribute_relationships', function($query) {
                $query->where([
                    ['subject_type', '=', $this::class],
                    ['subject_id', '=', $this->id]
                ])->select('id', 'subject_type', 'subject_id', 'attribute_id', 'attribute_value_id', 'for_variations');
            })->select('id','name','type','custom_properties')->where('content_type', $this::class)->get()->toArray();

            // 3. GET attribute values ids based on all attribute relationships
            $attrs_values_idx = [];
            foreach($attrs as $key => $att) {
                $attrs[$key]['attribute_values'] = [];

                if(!empty($att['attribute_relationships'])) {
                    foreach($att['attribute_relationships'] as $attr_rel) {
                        // Add attribute value id to array (we'll need those to query selected/typed att values from DB)
                        $attrs_values_idx[] = $attr_rel['attribute_value_id'];

                        // Determine if used for variations
                        $attrs[$key]['for_variations'] = $attr_rel['for_variations'] ?? false;
                    }
                }
            }

            // 4. Fetch ONLY attribute values for dropdown, checkbox, radio attribute types
            $relevant_attrs_idx = collect($attrs)->filter(fn($value, $key) => $value['is_predefined'])->pluck('id')->all();
            $predefined_attrs_values = collect(AttributeValue::whereIn('attribute_id', $relevant_attrs_idx)->select('id', 'attribute_id', 'values')->get()->toArray())->groupBy('attribute_id')->transform(fn($item, $key) => $item->keyBy('id')->toArray())->all();

            // 5. FETCH attribute values based on att. values ids provided from previously queried relationships
            $attrs_values = collect(AttributeValue::whereIn('id', $attrs_values_idx)->select('id', 'attribute_id', 'values')->get()->toArray())->transform(function($item, $key) {
                $item['selected'] = true;
                return $item;
            })->groupBy('attribute_id')->transform(fn($item, $key) => $item->keyBy('id')->toArray())->all();


            // 6. Replace & merge recursively predefined values with selected attribute values
            // Note: Since attributes are grouped by keys and attribute values indexes are actually values IDs for both arrays,
            // we'll have an array of all attributes and their predefined and selected/typed values for specific content type
            // Such array is real representation of possible values and selected/typed values
            $real_values = array_replace_recursive($predefined_attrs_values, $attrs_values);

            // 6. Merge selected att values to their corresponding attributes
            foreach($attrs as $key => $item) {
                if(isset($real_values[$item['id']])) {
                    $attrs[$key]['attribute_values'] = array_values(collect($real_values[$item['id']])->toArray());
                }
            }
        } else {
            // For new content type:
            // 1. Get attributes for that content type
            // 2. DO NOT fetch attribute relationships and attribute_values
            $attrs = Attribute::without('attribute_relationships', 'attribute_values')->select('id','name','type','custom_properties')->where('content_type', $this::class)->get()->toArray();
            $relevant_attrs_idx = collect($attrs)->filter(fn($value, $key) => $value['is_predefined'])->pluck('id')->all();

            // 3. Fetch ONLY attribute values for dropdown, checkbox, radio attribute types
            $predefined_attrs_values = collect(AttributeValue::whereIn('attribute_id', $relevant_attrs_idx)->select('id', 'attribute_id', 'values')->get()->toArray())->groupBy('attribute_id')->all();

            // 4. Merge predefined values to their corresponding attributes
            foreach($attrs as $key => $item) {
                if(isset($predefined_attrs_values[$item['id']])) {
                    $attrs[$key]['attribute_values'] = collect($predefined_attrs_values[$item['id']])->toArray();
                }
            }
        }

        // Map the attributes to be used in livewire forms
        $mapped = [];

        if(!empty($attrs)) {
            foreach ($attrs as $att) {
                $att_object = $return_object ? (object) $att : $att;

                if($return_object) {
                    $att_object->selected = true; // All attributes are selected by default
                    $att_object->for_variations = !empty($this->id ) ? ($att_object->for_variations ?? false) : false; // false if create, stays the same as previously defined on edit
                    $mapped[$att_object->id] = $att_object;
                } else {
                    $mapped[$att->id] = (object) array_merge($att_object, [
                        'selected' => true, // All attributes are selected by default
                        'for_variations' => !empty($this->id) ? ($att_object['for_variations'] ?? false) : false,  // false if create, stays the same as previously defined on edit
                    ]);
                }
            }
        }

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
    public function generateVariantAttributeValuesMatrix() {
        $result = [];
        $all_att_values = $this->variant_attributes()->pluck('attribute_values');

        foreach ($all_att_values as $index => $group) {
            if($index === 0) {
                $result = $group;
            } else {
                $result = $result->crossJoin($group);
            }
        }

        return $result;
    }

    function get_attribute_value_by_id($id) {
       return AttributeValue::where('attribute_id', $id)->get();
    }
}
