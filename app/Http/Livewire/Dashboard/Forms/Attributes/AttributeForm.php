<?php

namespace App\Http\Livewire\Dashboard\Forms\Attributes;

use DB;
use FX;
use EVS;
use Purifier;
use Categories;
use Permissions;
use App\Models\Plan;
use App\Models\User;
use App\Facades\MyShop;
use App\Models\Address;
use Livewire\Component;
use App\Models\Category;
use App\Enums\StatusEnum;
use App\Models\Attribute;
use App\Models\ShopAddress;
use App\Models\AttributeValue;
use Illuminate\Validation\Rule;
use App\Enums\AttributeTypeEnum;
use App\Traits\Livewire\RulesSets;
use App\Enums\AmountPercentTypeEnum;
use App\Traits\Livewire\HasCategories;
use App\Traits\Livewire\DispatchSupport;
use Spatie\ValidationRules\Rules\ModelsExist;

class AttributeForm extends Component
{
    use RulesSets;
    use DispatchSupport;
    use HasCategories;

    public $content_type;

    public $content_type_label;

    public $attribute;

    public $attribute_values;

    public $is_update;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($attribute = null, $content_type = null)
    {
        $this->attribute = empty($attribute) ? new Attribute() : $attribute;
        $this->is_update = isset($this->attribute->id) && ! empty($this->attribute->id);

        if (! $this->is_update) {
            // If insert
            $this->content_type = $content_type;
            $this->attribute->setDefault($content_type);

            if($this->attribute->is_predefined) {
                $blank_att_value = new AttributeValue();
                $blank_att_value->id = null;
                $blank_att_value->attribute_id = null;
                $blank_att_value->values = null;
                $blank_att_value->ordering = 0;

                $this->attribute_values = new \Illuminate\Database\Eloquent\Collection([$blank_att_value]);
            }
        } else {
            $this->content_type = $this->attribute->content_type;

            if($this->attribute->is_predefined) {
                $this->attribute_values = $attribute->attribute_predefined_values;

                if ($this->attribute_values->isEmpty()) {
                    $blank_att_value = new AttributeValue();
                    $blank_att_value->id = null;
                    $blank_att_value->attribute_id = null;
                    $blank_att_value->values = null;
                    $blank_att_value->ordering = 0;
    
                    $this->attribute_values = new \Illuminate\Database\Eloquent\Collection([$blank_att_value]);
                }
            }
        }

        $this->content_type_label = collect(\App\Enums\ContentTypeEnum::labels())->get(collect(\App\Enums\ContentTypeEnum::values())->search($this->content_type));
    }

    protected function rules()
    {
        return [
            // 'selected_categories' => 'required',
            'attribute.name' => 'required|min:2',
            'attribute.content_type' => '',
            'attribute.type' => [Rule::in(AttributeTypeEnum::toValues())],
            'attribute.filterable' => 'required|boolean',
            'attribute.is_admin' => 'required|boolean',
            'attribute.is_schema' => 'required|boolean',
            'attribute.schema_key' => 'nullable',
            'attribute.schema_value' => 'nullable',
            'attribute.custom_properties' => '',
            'attribute.custom_properties.*' => '',
            'attribute_values.*.id' => '',
            'attribute_values.*.attribute_id' => '',
            'attribute_values.*.values' => '',
            'attribute_values.*.ordering' => '',
        ];
    }

    protected function messages()
    {
        return [
            'selected_categories' => translate('You must select at least one category'),

            'attribute.name.required' => translate('Title is required'),
            'attribute.name.min' => translate('Minimum title length is :min'),
            'attribute.type.in' => translate('Type must be one of the following:').' '.AttributeTypeEnum::implodedLabels(),
            'attribute.filterable.required' => translate('Filterable is required'),
            'attribute.is_admin.required' => translate('Is admin is required'),
            'attribute.is_schema.required' => translate('Is schema is required'),
        ];
    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('initPlanForm');
    }

    protected function filterCustomProperties()
    {
        $except = [];
        $custom_properties = $this->attribute->custom_properties;

        if ($this->attribute->type === 'number') {
            $except = ['min_value', 'max_value', 'unit'];
        } elseif ($this->attribute->type === 'dropdown') {
            $except = ['multiple'];
        } elseif ($this->attribute->type === 'date') {
            $except = ['with_time', 'range'];
        } elseif ($this->attribute->type === 'text_list') {
            $except = ['min_rows', 'max_rows'];
        }

        foreach ($custom_properties as $key => $value) {
            if (! in_array($key, $except)) {
                unset($custom_properties->{$key});
            }
        }

        $this->attribute->custom_properties = empty((array) $custom_properties) ? null : $custom_properties;
    }

    public function saveAttribute()
    {
        $msg = null;

        // FIXME: If $attribute->custom_properties is {} and not null, it will rise livewire checksum error on saveAttribute()

        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatchValidationErrors($e);
            $this->validate();
        }

        DB::beginTransaction();

        try {
            // Insert or Update Attribute
            // $this->attribute->shop_id = MyShop::getShopID(); // TODO: add shop_id to attributes for multi-vendor support!

            // If user has no permissions to insert/create attribute, throw exception
            if (! Permissions::canAccess(User::$non_customer_user_types, [$this->is_update ? 'update_product_attributes' : 'insert_product_attributes'], false)) {
                $msg = $this->is_update ? translate('You don\'t have sufficent permission to update product attributes') : translate('You don\'t have sufficent permission to insert product attributes');
                throw new \Exception();
            }

            if (! $this->is_update) {
                // Insert
                $this->attribute->content_type = $this->content_type;
            }

            $this->filterCustomProperties();
            $this->attribute->save();

            // Set Attribute Categories relationship
            // $this->setCategories($this->attribute);

            // TODO: Determine which package to use for Translations! Set Translations...

            DB::commit();

            if ($this->is_update) {
                $this->inform(translate('Attribute successfully updated!'), $msg, 'success');
            } else {
                $this->inform(translate('Attribute successfully created!'), $msg, 'success');

                // Redirect to update page
                return redirect()->route('attributes.edit', $this->attribute->id);
            }
        } catch (\Exception $e) {
            DB::rollBack();

            if ($this->is_update) {
                $this->dispatchGeneralError(! empty($msg) ? $msg : translate('There was an error while updating an attribute...Please try again.'));
                $this->inform(! empty($msg) ? $msg : translate('There was an error while updating an attribute...Please try again.'), '', 'danger');
            } else {
                $this->dispatchGeneralError(! empty($msg) ? $msg : translate('There was an error while creating an attribute...Please try again.'));
                $this->inform(! empty($msg) ? $msg : translate('There was an error while creating an attribute...Please try again.'), '', 'danger');
            }
        }
    }

    public function saveAttributeValues()
    {
        if (! empty($this->attribute_values)) {
            DB::beginTransaction();

            try {
                foreach ($this->attribute_values as $value) {
                    if (! empty($value['id'] ?? null) && (is_integer($value['id']) || ctype_digit($value['id']))) {
                        // Update
                        AttributeValue::where('id', $value['id'])->update([
                            'values' => $value['values'], 
                            'attribute_id' => $this->attribute->id,
                            'ordering' => $value['ordering']
                        ]);
                    } else {
                        // Insert
                        AttributeValue::create([
                            'values' => $value['values'],
                            'attribute_id' => $this->attribute->id,
                            'ordering' => 0
                        ]);
                    }
                }

                DB::commit();

                $this->inform(translate('Attribute values successfully updated!'), '', 'success');

                $this->attribute_values = $this->attribute->attribute_predefined_values()->get(); // query attribute values again - reset!
            } catch (\Exception $e) {
                DB::rollBack();

                $this->dispatchGeneralError(translate('There was an error while updating an attribute values...Please try again.'));
                $this->inform(translate('There was an error while updating an attribute values...Please try again. '), $e->getMessage(), 'danger');
            }
        }
    }

    public function removeAttribute()
    {
//        $address = app($this->currentAddress::class)->find($this->currentAddress->id)->fill($this->currentAddress->toArray());
//        $address->remove();
    }

    public function removeAttributeValue($id)
    {
        DB::beginTransaction();

        try {
            // Remove the attribute -> this will remove attribute value translations and relationships too!
            AttributeValue::destroy($id);

            DB::commit();

            $this->toastify(translate('Attribute value successfully removed!'), 'success');
        } catch (\Exception $e) {
            DB::rollBack();

            $this->dispatchGeneralError(translate('There was an error while removing an attribute value...Please try again.'));
            $this->toastify(translate('There was an error while removing an attribute value...Please try again. ').$e->getMessage(), 'danger');
        }
    }

    public function render()
    {
        return view('livewire.dashboard.forms.attributes.attributes-form');
    }
}
