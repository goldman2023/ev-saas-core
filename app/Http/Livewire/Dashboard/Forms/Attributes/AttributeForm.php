<?php

namespace App\Http\Livewire\Dashboard\Forms\Attributes;

use App\Enums\StatusEnum;
use App\Enums\AmountPercentTypeEnum;
use App\Facades\MyShop;
use App\Models\Address;
use App\Models\Category;
use App\Models\Plan;
use App\Models\ShopAddress;
use App\Models\User;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Traits\Livewire\DispatchSupport;
use DB;
use EVS;
use Categories;
use FX;
use Illuminate\Validation\Rule;
use Purifier;
use Permissions;
use Spatie\ValidationRules\Rules\ModelsExist;
use Livewire\Component;
use App\Traits\Livewire\RulesSets;
use App\Traits\Livewire\HasCategories;
use App\Enums\AttributeTypeEnum;

class AttributeForm extends Component
{
    use RulesSets;
    use DispatchSupport;
    use HasCategories;

    public $attribute;
    public $attribute_values;
    public $is_update;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($attribute = null)
    {
        $this->attribute = empty($attribute) ? new Attribute() : $attribute;
        $this->attribute_values = $attribute->attribute_values;
        $this->is_update = isset($this->attribute->id) && !empty($this->attribute->id);

        if(!$this->is_update) {
            // If insert
        }

        // $this->initCategories($this->plan);
    }

    protected function rules()
    {
        return [
            // 'selected_categories' => 'required',
            'attribute.name' => 'required|min:2',
            'attribute.type' => [Rule::in(AttributeTypeEnum::toValues())],
            'attribute.filterable' => 'required|boolean',
            'attribute.is_admin' => 'required|boolean',
            'attribute.is_schema' => 'required|boolean',
            'attribute.schema_key' => 'nullable',
            'attribute.schema_value' => 'nullable',
            'attribute.custom_properties' => '',
            'attribute_values.*.values' => ''
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

    protected function filterCustomProperties() {
        $except = [];
        $custom_properties = $this->attribute->custom_properties;
        
        if($this->attribute->type === 'number') {
            $except = ['min_value', 'max_value', 'unit'];
        } else if($this->attribute->type === 'dropdown') {
            $except = ['multiple'];
        }
        
        foreach($custom_properties as $key => $value) {
            if(!in_array($key, $except)) {
                unset($custom_properties->{$key});
            }
        }

        $this->attribute->custom_properties = $custom_properties;
    }

    public function saveAttribute() {
        $msg = null;
        
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatchValidationErrors($e);
            $this->validate();
        }

        $this->filterCustomProperties();
        
        DB::beginTransaction();
        
        try {
            // Insert or Update plan
            // $this->attribute->shop_id = MyShop::getShopID(); // TODO: add shop_id to attributes for multi-vendor support!

            // If user has no permissions to insert/create attribute, throw exception
            if(!Permissions::canAccess(User::$non_customer_user_types, [$this->is_update ? 'update_product_attributes' : 'insert_product_attributes'], false)) {
                $msg = $this->is_update ? translate('You don\'t have sufficent permission to update product attributes') : translate('You don\'t have sufficent permission to insert product attributes');
                throw new \Exception();
            }
            
            $this->attribute->save();

            // Set Attribute Categories relationship
            // $this->setCategories($this->plan);

            // TODO: Determine which package to use for Translations! Set Translations...

            DB::commit();

            if($this->is_update) {
                $this->toastify(translate('Attribute successfully updated!').' '.$msg, 'success');
            } else {
                $this->toastify(translate('Attribute successfully created!').' '.$msg, 'success');
            }
        } catch(\Exception $e) {
            DB::rollBack();

            if($this->is_update) {
                $this->dispatchGeneralError(!empty($msg) ? $msg : translate('There was an error while updating an attribute...Please try again.'));
                $this->toastify(!empty($msg) ? $msg : translate('There was an error while updating an attribute...Please try again.'), 'danger');
            } else {
                $this->dispatchGeneralError(!empty($msg) ? $msg : translate('There was an error while creating an attribute...Please try again.'));
                $this->toastify(!empty($msg) ? $msg : translate('There was an error while creating an attribute...Please try again.'), 'danger');
            }
        }
    }

    public function saveAttributeValues() {
        if(!empty($this->attribute_values)) {
            DB::beginTransaction();

            try {
                foreach($this->attribute_values as $value) {
                    if(!empty($value['id']??null)) {
                        // Update
                        AttributeValue::where('id', $value['id'])->update(['values' => $value['values'], 'attribute_id' => $this->attribute->id]);
                    } else {
                        // Insert
                        AttributeValue::create([
                            'values' => $value['values'],
                            'attribute_id' => $this->attribute->id
                        ]);
                    }
                }

                DB::commit();

                $this->toastify(translate('Attribute values successfully updated!'), 'success');

                $this->attribute_values = $this->attribute->attribute_values()->get(); // query attribute values again - reset!
            } catch(\Exception $e) {
                DB::rollBack();

                $this->dispatchGeneralError(translate('There was an error while updating an attribute values...Please try again.'));
                $this->toastify(translate('There was an error while updating an attribute values...Please try again. ').$e->getMessage(), 'danger');
            }
            
        }
    }

    public function removeAttribute() {
//        $address = app($this->currentAddress::class)->find($this->currentAddress->id)->fill($this->currentAddress->toArray());
//        $address->remove();
    }

    public function removeAttributeValue($id) {
        DB::beginTransaction();

        try {
            // remove the attribute -> this will remove attribute value translations and relationships too!
            AttributeValue::destroy($id);

            DB::commit();

            $this->toastify(translate('Attribute value successfully removed!'), 'success');

        } catch(\Exception $e) {
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
