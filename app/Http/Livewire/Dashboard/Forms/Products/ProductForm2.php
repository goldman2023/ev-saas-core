<?php

namespace App\Http\Livewire\Dashboard\Forms\Products;

use App\Models\Attribute;
use App\Models\AttributeRelationship;
use App\Models\AttributeTranslation;
use App\Models\AttributeValue;
use App\Facades\TenantSettings;
use App\Models\AttributeValueTranslation;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\ProductTranslation;
use App\Models\Upload;
use App\Models\CoreMeta;
use App\Rules\AttributeValuesSelected;
use App\Rules\EVModelsExist;
use App\Enums\StatusEnum;
use App\Enums\ProductTypeEnum;
use App\Enums\AmountPercentTypeEnum;
use DB;
use EVS;
use Categories;
use MyShop;
use FX;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Purifier;
use Spatie\ValidationRules\Rules\ModelsExist;
use Livewire\Component;
use App\Traits\Livewire\RulesSets;
use App\Traits\Livewire\HasCategories;
use App\Traits\Livewire\DispatchSupport;
use App\Traits\Livewire\CanDelete;
use Str;

class ProductForm2 extends Component
{
    use DispatchSupport;
    use RulesSets;
    use HasCategories;
    use CanDelete;

    public $product;
    public $core_meta;
    public $is_update;
    public $attributes;
    public $selected_predefined_attribute_values;

    protected $listeners = [
        
    ];

    protected function getRuleSet($set = null) {
        $rulesSets = collect([
            'minimum_required' => [
                'product.name' => 'required|min:6',
                'product.unit_price' => 'required|numeric',
                // 'product.sku' => ['required', Rule::unique('product_stocks', 'sku')->ignore($this->product->stock->id ?? null)],
            ],
            'basic' => [
                'product.name' => 'required|min:6',
                'product.description' => 'required|min:20',
                'product.excerpt' => 'nullable',
                // 'product.status' => [Rule::in(StatusEnum::toValues())],
                'product.type' => [Rule::in(ProductTypeEnum::toValues())],
            ],
            'status' => [
                'product.status' => [Rule::in(StatusEnum::toValues())],
            ],
            'categories_and_tags' => [
                'selected_categories' => 'required',
                'product.tags' => 'nullable|array',
            ],
            'brand' => [
                'product.brand_id' => 'nullable|exists:App\Models\Brand,id',
            ],
            'media' => [
                'product.thumbnail' => ['if_id_exists:App\Models\Upload,id,true'],
                'product.cover' => ['if_id_exists:App\Models\Upload,id,true'],
                'product.gallery' => [], // 'if_id_exists:App\Models\Upload,id,true'
                'product.video_provider' => 'nullable|in:youtube,vimeo,dailymotion',
                'product.video_link' => 'nullable|active_url',
                'product.pdf' => ['nullable', 'if_id_exists:App\Models\Upload,id,true'],
            ],
            'pricing' => [
                'product.unit_price' => 'required|numeric',
                'product.base_currency' => [Rule::in(FX::getAllCurrencies()->map(fn($item) => $item->code)->toArray())],
                'product.purchase_price' => 'nullable|numeric',
                'product.discount' => 'nullable|numeric',
                'product.discount_type' => 'nullable|in:amount,percent',
                'product.tax' => 'nullable|numeric',
                'product.tax_type' => 'nullable|in:amount,percent',
            ],
            'inventory' => [
                'product.unit' => 'nullable',
                'product.sku' => ['nullable', Rule::unique('product_stocks', 'sku')->ignore($this->product->stock->id ?? null)],
                'product.barcode' => ['nullable'],
                'product.min_qty' => 'nullable|numeric|min:1',
                'product.current_stock' => 'required|numeric|min:0',
                'product.low_stock_qty' => 'required|numeric|min:0',
                'product.use_serial' => 'required|boolean',
                'product.allow_out_of_stock_purchases' => 'required|boolean',
                'product.track_inventory' => 'required|boolean',
            ],
            'shipping' => [
                'product.digital' => 'required|boolean',
                // 'product.shipping_cost' => 'required_if:product.shipping_type,flat_rate',
                // 'product.est_shipping_days' => 'nullable|numeric'
            ],
            'attributes' => [
                'attributes.*' => 'required',
                'selected_predefined_attribute_values.*' => ''
            ],
            'seo' => [
                'product.meta_title' => 'nullable',
                'product.meta_description' => 'nullable',
                'product.meta_img' => 'nullable',
            ],
            'meta' => [
                // TODO: Add proper conditional validation!
                'core_meta.date_type.value' => [Rule::in(['range', 'specific'])], // range, specific
                'core_meta.start_date.value' => 'required|date', 
                'core_meta.end_date.value' => 'nullable|date',
                'core_meta.location_type.value' => [Rule::in(['remote', 'offline'])], // remote, location
                'core_meta.location_address.value' => 'nullable',
                'core_meta.location_address_coordinates.value' => 'nullable',
                'core_meta.location_link.value' => 'nullable',
                'core_meta.unlockables.value' => 'nullable',
                'core_meta.calendly_link.value' => 'nullable' // should be required if product type is bookable_service or bookable_subscription_service

            ]
        ]);

        return empty($set) || $set === 'all' ? $rulesSets : $rulesSets->get($set);
    }

    protected function rules()
    {
        $rules = [];
        foreach($this->getRuleSet('all') as $key => $items) {
            $rules = array_merge($rules, $items);
        }

        return $rules;
    }

    protected function messages() {
        return [
            'product.thumbnail.if_id_exists' => translate('Please select a valid thumbnail image from the media library'),
            'product.cover.if_id_exists' => translate('Please select a valid cover image from the media library'),
            'product.pdf.if_id_exists' => translate('Please select a valid specification document from the media library'),
            'selected_categories.required' => translate('You must select at least 1 category'),
        ];
    }

    protected function setPredefinedAttributeValues($model) {
        // Set predefined attribute values AND select specific values if it's necessary
        foreach($this->attributes as $attribute) {
            if($attribute->is_predefined) {
                if(isset($model->id) && !empty($model->id)) {
                    // edit product
                    $product_attribute = $model->custom_attributes->firstWhere('id', $attribute->id);

                    if($product_attribute instanceof \App\Models\Attribute) {
                        $this->selected_predefined_attribute_values['attribute.'.$attribute->id] = $product_attribute->attribute_values->pluck('id');
                    } else {
                        $this->selected_predefined_attribute_values['attribute.'.$attribute->id] = [];
                    }
                } else {
                    // insert product
                    $this->selected_predefined_attribute_values['attribute.'.$attribute->id] = [];
                }
            }
        }
    }

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount(&$product = null)
    {   
        // Set default params
        if($product) {
            // Update
            $this->product = $product;
            $this->is_update = true;
        } else {
            // Insert
            $this->is_update = false;

            $this->product = new Product();

            $this->product->slug = '';
            $this->product->status = StatusEnum::draft()->value;
            $this->product->type = ProductTypeEnum::standard()->value;
            $this->product->track_inventory = false;
            $this->product->user_id = auth()->user()->id;
            $this->product->shop_id = MyShop::getShop()->id;
            $this->product->is_quantity_multiplied = 1;
            $this->product->shipping_type = 'product_wise';
            $this->product->stock_visibility_state = 'quantity';
            $this->product->discount_type = 'amount';
            $this->product->discount = 0;
            $this->product->tags = [];
            $this->product->low_stock_qty = 0;
            $this->product->min_qty = 1;
            $this->product->unit_price = 0;
            $this->product->brand_id = null;

            $this->product->base_currency = FX::getCurrency()->code;
            $this->product->discount_type = AmountPercentTypeEnum::amount()->value;
            $this->product->tax_type = AmountPercentTypeEnum::amount()->value;
        }

        $this->refreshAttributes();

        $this->initCategories($this->product);

        $this->core_meta = CoreMeta::getMeta($product->core_meta);
    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('initProductForm');
    }

    public function render()
    {
        return view('livewire.dashboard.forms.products.product-form2');
    }

    public function refreshVariationsDatatable() {
        // TODO: Refresh variations datatable
        // $this->emit('refreshDatatable');
        //$this->emit('updatedAttributeValues', $this->variations_attributes);
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

    public function validateData($set = 'minimum_required') {
        try {
            $this->validate($set === 'all' ? $this->rules() : $this->getRuleSet($set));
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatchValidationErrors($e);

            // Reset status to Draft!
            $this->product->status = StatusEnum::draft()->value;
            $this->validate($set === 'all' ? $this->rules() : $this->getRuleSet($set));
        }
    }

    public function saveMinimumRequired() {
        // TODO: Check if editor is trying to change status to published if not enough data is present
        
        if(!$this->is_update) {
            // Insert
            $this->product->shop_id = MyShop::getShopID();
            $this->product->user_id = auth()->user()->id;
            $this->product->name = $this->product->name;
            $this->product->unit_price = $this->product->unit_price;
            $this->product->save();

            $this->is_update = true; // Change is_update flag to true! From now on, product is being only updated!
        } else {
            // Update 
            $this->product->update([
                'shop_id' => MyShop::getShopID(),
                'user_id' => auth()->user()->id,
                'name' => $this->product->name,
                'unit_price' => $this->product->unit_price
            ]); // update only minimum required fields
        }
        
        // Set Product Stock
        $this->setProductStocks();
    }

    /* TODO: Update this to check if stock is not created on a global scope, not only in product form */
    protected function setProductStocks() {
        $product_stock = ProductStock::firstOrNew(['subject_id' => $this->product->id, 'subject_type' => Product::class]);
        $product_stock->track_inventory = ($this->product->track_inventory ?? false) === true;
        $product_stock->sku = empty($this->product->sku) ? \UUID::generate(4)->string : $this->product->sku;
        $product_stock->barcode = empty($this->product->barcode) ? null : $this->product->barcode ;
        $product_stock->qty = empty($this->product->current_stock) ? 0 : $this->product->current_stock;
        $product_stock->low_stock_qty = empty($this->product->low_stock_qty) ? 0 : $this->product->low_stock_qty;
        $product_stock->use_serial = ($this->product->use_serial ?? false) === true;
        $product_stock->allow_out_of_stock_purchases = ($this->product->allow_out_of_stock_purchases ?? false) === true;
        $product_stock->save();
    }

    public function saveProduct() {
        $this->validateData('all');
        
        DB::beginTransaction();

        try {
            $this->saveMinimumRequired();

            // Save product data
            // $this->product->tags = [];
            $this->product->save();

            // Sync Uploads
            $this->product->syncUploads();

            // Save Categories
            $this->setCategories($this->product);

            // Set Attributes
            $this->setAttributes();

            // Save CoreMeta
            $this->saveCoreMeta();
            
            DB::commit();

            // Refresh Attributes
            $this->refreshAttributes();

            $this->inform(translate('Product successfully saved!'), '', 'success');

            // $this->dispatchBrowserEvent('init-product-form', []);
        } catch(\Exception $e) {
            DB::rollBack();

            $this->dispatchGeneralError(translate('There was an error while saving a product.'));
            $this->inform(translate('There was an error while saving a product.'), $e->getMessage(), 'fail');
        }
    }

    public function refreshAttributes() {
        $this->attributes = $this->product->getMappedAttributes();

        // Set default attributes
        foreach($this->attributes as $key => $attribute) {
            if($attribute->is_predefined) {
                $attribute->selcted_values = '';
            }

            if(empty($this->attributes[$key]->attribute_values)) {
                if(!$attribute->is_predefined) {
                    $this->attributes[$key]->attribute_values[] = [
                        "id" => null,
                        "attribute_id" => $attribute->id,
                        "values" => '',
                        "selected" => true,
                    ];
                } else {
                    $this->attributes[$key]->attribute_values = [];
                }
            }
        }

        $this->setPredefinedAttributeValues($this->product);
    }

    /**
     * @throws \Exception
     */
    protected function setAttributes() {
        $selected_attributes = collect($this->attributes)->filter(function($att, $key) {
            $att = (object) $att;
            return $att->selected === true;
        });
 
        if($selected_attributes) {
            foreach($selected_attributes as $att) {
                $attribute = new Attribute();
                
                $att = (object) $att;
                $att_values = $att->attribute_values;

                if(!empty($att_values)) {

                    // Is-predefined attributes are dropdown/radio/checkbox and they have predefined values
                    // while other types have only one item in values array - with an ID (existing value) or without ID (not yet added value, just default template)
                    if(!$att->is_predefined) {
                        
                        foreach($att_values as $key => $att_value) {
                            if(empty($att_value['values'] ?? null)) {
                                // If value is empty, unset it and later on reset array_values
                                unset($att_values[$key]);
                                continue;
                            }

                            $attribute_value_row = (!empty($att_value['id'])) ? AttributeValue::find($att_value['id']) : new AttributeValue();

                            // Create the value first
                            $attribute_value_row->attribute_id = (!empty($att_value['id'])) ? $attribute_value_row->attribute_id : $att->id;
                            $attribute_value_row->values = $att_value['values'] ?? null;
                            $attribute_value_row->selected = true;
                            $attribute_value_row->save();

                            // Set attribute value translations for non-predefined attributes
                            $attribute_value_translation = AttributeValueTranslation::firstOrNew(['lang' => config('app.locale'), 'attribute_value_id' => $attribute_value_row->id]);
                            $attribute_value_translation->name = $att_value['values'] ?? null;
                            $attribute_value_translation->save();

                            $att_values[$key] = $attribute_value_row;
                        }

                        
                    } else {
                        $selected_attribute_values = $this->selected_predefined_attribute_values['attribute.'.$att->id] ?? [];
                        
                        foreach($att_values as $key => $att_value) {
                            $attribute_value_row = AttributeValue::find($att_value['id']);

                            if(is_array($selected_attribute_values) && in_array($attribute_value_row->id, $selected_attribute_values)) {
                                $attribute_value_row->selected = true;
                            } else if(is_numeric($selected_attribute_values) && ((int) $selected_attribute_values) == $att_value['id']) {
                                $attribute_value_row->selected = true;
                            } else {
                                $attribute_value_row->selected = false;
                            }

                            $att_values[$key] = $attribute_value_row;
                        }
                    }

                    $att_values = array_values($att_values);

                    if($att->id === 27) {
                        // dd($att_values);
                    }
                    
                    foreach($att_values as $key => $att_value) {
                        if($att_value->id ?? null) {
                            if($att_value->selected ?? null) {
                                // Create or find product-attribute relationship, but don't yet persist anything to DB
                                $att_rel = AttributeRelationship::firstOrNew([
                                    'subject_type' => Product::class,
                                    'subject_id' => $this->product->id,
                                    'attribute_id' => $att->id,
                                    'attribute_value_id' => $att_value->id
                                ]);
                                $att_rel->for_variations = $att->type === 'dropdown' ? $att->for_variations : false;

                                if($att->type === 'text_list') {
                                    $att_rel->order = $key; // respect order for the text_list
                                }

                                $att_rel->save();
                            } else {
                                // Remove attribute relationship if "selected" is false/null
                                AttributeRelationship::where([
                                    'subject_type' => Product::class,
                                    'subject_id' => $this->product->id,
                                    'attribute_id' => $att->id,
                                    'attribute_value_id' => $att_value->id
                                ])->delete();
                            }
                        }
                    }

                    // if($att->type === 'text_list') {
                    //     $vals = AttributeValue::where('attribute_id', $att->id)->get();
                    //     dd($vals);
                    //     foreach($att_values as $key => $att_value) {
                    //         if(empty($vals->firstWhere('id', $att_value->id))) {
                    //             dd($att_value);
                    //         }
                    //     }
                        
                    //     // remove missing attribute relationships and values 
                    //     $rels = AttributeRelationship::where([
                    //         'subject_type' => Product::class,
                    //         'subject_id' => $this->product->id,
                    //         'attribute_id' => $att->id,
                    //         '' 
                    //     ]);
                    // }
                }
            }
        }
    }

    protected function saveCoreMeta() {
        foreach(collect($this->getRuleSet('meta'))->filter(fn($item, $key) => str_starts_with($key, 'core_meta')) as $key => $value) {
            $core_meta_key = explode('.', $key)[1]; // get the part after `core_meta.`
            
            if(!empty($core_meta_key) && $core_meta_key !== '*') {
                $new_value = castValueForSave($core_meta_key, $this->core_meta[$core_meta_key], CoreMeta::metaDataTypes());

                CoreMeta::updateOrCreate(
                    ['subject_id' => $this->product->id, 'subject_type' => $this->product::class, 'key' => $core_meta_key],
                    ['value' => $new_value]
                );
            }
        }
    }

    // END

    // DEPRECATED!!!
    public function saveBasic() {
        // Validate minimum required fields and insert/update row
        $this->validateData('minimum_required');

        DB::beginTransaction();

        try {
            $this->saveMinimumRequired();

            // Save Basic Info
            $this->product->update([
                'excerpt' => $this->product->excerpt,
                'description' => $this->product->description,
                'status' => $this->product->status
            ]);
            
            DB::commit();

            $this->toastify(translate('Product successfully saved!'), 'success');
        } catch(\Exception $e) {
            DB::rollBack();

            $this->dispatchGeneralError(translate('There was an error while saving a product.'));
            $this->toastify(translate('There was an error while saving a product. ').$e->getMessage(), 'danger');
        }
    }

    public function saveMedia() {
        // Validate minimum required fields and insert/update row
        $this->validateData('minimum_required');

        $this->validateData('media');

        DB::beginTransaction();

        try {
            $this->saveMinimumRequired();

            $this->product->syncUploads();

            // Save Media data
            $this->product->update([
                'video_provider' => $this->product->video_provider,
                'video_link' => $this->product->video_link
            ]);
            
            DB::commit();

            $this->toastify(translate('Product successfully saved!'), 'success');
        } catch(\Exception $e) {
            DB::rollBack();

            $this->dispatchGeneralError(translate('There was an error while saving a product.'));
            $this->toastify(translate('There was an error while saving a product. ').$e->getMessage(), 'danger');
        }
    }

    public function savePricing() {
        // Validate minimum required fields and insert/update row
        $this->validateData('minimum_required');

        $this->validateData('pricing');

        DB::beginTransaction();

        try {
            $this->saveMinimumRequired();

            $this->product->update([
                'unit_price' => $this->product->unit_price,
                'discount' => $this->product->discount,
                'tax' => $this->product->tax,
                'purchase_price' => $this->product->purchase_price,
            ]);
            
            DB::commit();

            $this->toastify(translate('Product successfully saved!'), 'success');
        } catch(\Exception $e) {
            DB::rollBack();

            $this->dispatchGeneralError(translate('There was an error while saving a product.'));
            $this->toastify(translate('There was an error while saving a product. ').$e->getMessage(), 'danger');
        }
    }


    public function saveInventory() {
        // Validate minimum required fields and insert/update row
        $this->validateData('minimum_required');

        $this->validateData('inventory');

        DB::beginTransaction();

        try {
            $this->saveMinimumRequired();

            // Save Inventory data
            $this->product->update([
                'unit' => $this->product->unit,
            ]);
            
            DB::commit();

            $this->toastify(translate('Product successfully saved!'), 'success');
        } catch(\Exception $e) {
            DB::rollBack();

            $this->dispatchGeneralError(translate('There was an error while saving a product.'));
            $this->toastify(translate('There was an error while saving a product. ').$e->getMessage(), 'danger');
        }
    }

    public function saveShipping() {
        // Validate minimum required fields and insert/update row
        $this->validateData('minimum_required');

        $this->validateData('shipping');

        DB::beginTransaction();

        try {
            $this->saveMinimumRequired();

            // TODO: Needs Shipping Methods and Shipping Logic overall for it to be finished!

            // Save Shipping data
            $this->product->update([
                'digital' => $this->product->digital,
            ]);
            
            DB::commit();

            $this->toastify(translate('Product successfully saved!'), 'success');
        } catch(\Exception $e) {
            DB::rollBack();

            $this->dispatchGeneralError(translate('There was an error while saving a product.'));
            $this->toastify(translate('There was an error while saving a product. ').$e->getMessage(), 'danger');
        }
    }

    public function saveSEO() {
        // Validate minimum required fields and insert/update row
        $this->validateData('minimum_required');

        $this->validateData('seo');

        DB::beginTransaction();

        try {
            $this->saveMinimumRequired();

            // Update Meta Image
            $this->product->syncUploads('meta_img');

            // Save Shipping data
            $this->product->update([
                'meta_title' => $this->product->meta_title,
                'meta_description' => $this->product->meta_description
            ]);
            
            DB::commit();

            $this->toastify(translate('Product successfully saved!'), 'success');
        } catch(\Exception $e) {
            DB::rollBack();

            $this->dispatchGeneralError(translate('There was an error while saving a product.'));
            $this->toastify(translate('There was an error while saving a product. ').$e->getMessage(), 'danger');
        }
    }

    public function saveCategoriesAndTags() {
        // Validate minimum required fields and insert/update row
        $this->validateData('minimum_required');

        $this->validateData('categories_and_tags');

        DB::beginTransaction();

        try {
            $this->saveMinimumRequired();

            // Save Tags
            $this->product->update([
                'product.tags' => $this->product->tags
            ]);
            
            // Save Categories
            $this->setCategories($this->product);

            DB::commit();

            $this->toastify(translate('Product successfully saved!'), 'success');
        } catch(\Exception $e) {
            DB::rollBack();

            $this->dispatchGeneralError(translate('There was an error while saving a product.'));
            $this->toastify(translate('There was an error while saving a product. ').$e->getMessage(), 'danger');
        }
    }

    public function saveBrand() {
        // Validate minimum required fields and insert/update row
        $this->validateData('minimum_required');

        $this->validateData('brand');

        DB::beginTransaction();

        try {
            $this->saveMinimumRequired();

            // Save Brand
            $this->product->update([
                'product.brand_id' => $this->product->brand_id
            ]);

            DB::commit();

            $this->toastify(translate('Product successfully saved!'), 'success');
        } catch(\Exception $e) {
            DB::rollBack();

            $this->dispatchGeneralError(translate('There was an error while saving a product.'));
            $this->toastify(translate('There was an error while saving a product. ').$e->getMessage(), 'danger');
        }
    }

    public function updateStatus() {
        // Validate minimum required fields and insert/update row
        $this->validateData('minimum_required');

        $this->validateData('status');

        DB::beginTransaction();

        try {
            $this->saveMinimumRequired();

            // Update status
            $this->product->update([
                'product.status' => $this->product->status
            ]);

            DB::commit();

            $this->toastify(translate('Status successfully updated to').': '.$this->product->status, 'success');
        } catch(\Exception $e) {
            DB::rollBack();

            $this->dispatchGeneralError(translate('There was an error while updating the status.'));
            $this->toastify(translate('There was an error while updating the status. ').$e->getMessage(), 'danger');
        }
    }

    public function saveAttributes() {
        // Validate minimum required fields and insert/update row
        $this->validateData('minimum_required');

        $this->validateData('attributes');

        DB::beginTransaction();

        try {
            $this->setAttributes();


            $this->toastify(translate('Product successfully saved!'), 'success');
        } catch(\Exception $e) {
            DB::rollBack();

            $this->dispatchGeneralError(translate('There was an error while saving a product.'));
            $this->toastify(translate('There was an error while saving a product. ').$e->getMessage(), 'danger');
        }
    }

    // public function updateAttributeValuesForVariations() {
    //     $atts = collect($this->attributes)->filter(function($att, $key) {
    //         $att = (object) $att;
    //         return $att->selected === true && $att->for_variations === true;
    //     });

    //     if($atts) {
    //         foreach ($atts as $att) {
    //             $att = (object)$att;
    //             $att_values = $att->attribute_values;

    //             if ($att_values) {
    //                 // ????
    //                 // TODO: What happens when attribute values (used for variations) are changed AND product is saved without touching the variations modal?
    //                 // FIX: It should SOFT DELETE product variations related to attribute value! IMPORTANT thing is to use SOFT DELETES, because if vendor wants to
    //                 // revive the attribute value for some reason and generate variations related to it, we need to bring back the old variations in the DB from the dead.
    //                 // This way we can always generate proper sales reports and never miss data!
    //                 // SOFT DELETES FOR PRODUCT VARIATIONS ARE VERY IMPORTANT!!!!
    //                 // NOTE: There can always be ONE product variation combination for certain product in the DB! We should never remove it fully, cuz we'll lose the data associated with it (number of variation sales, etc.)
    //             }
    //         }
    //     }
    // }

    // public function getVariationsAttributesProperty() {
    //     $atts_for_variations = collect($this->attributes)->filter(function($att, $key) {
    //         return ((object) $att)->for_variations === true;
    //     });

    //     return $atts_for_variations;
    // }
}
