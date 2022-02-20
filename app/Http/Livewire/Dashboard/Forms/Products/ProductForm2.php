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
use App\Rules\AttributeValuesSelected;
use App\Rules\EVModelsExist;
use App\Enums\StatusEnum;
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
use Str;

class ProductForm2 extends Component
{
    use DispatchSupport;
    use RulesSets;
    use HasCategories;

    public $product;
    public $is_update;
    public $attributes;
    public $selected_predefined_attribute_values;

    protected $listeners = [
        // TODO Do we need this?
        // 'variationsUpdated' => 'updateAttributeValuesForVariations'
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
                'product.status' => [Rule::in(StatusEnum::toValues())],
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
                'product.thumbnail' => ['required', 'if_id_exists:App\Models\Upload,id'],
                'product.gallery' => ['if_id_exists:App\Models\Upload,id,true'],
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
                'product.unit' => 'required',
                'product.sku' => ['required', Rule::unique('product_stocks', 'sku')->ignore($this->product->stock->id ?? null)],
                'product.barcode' => ['nullable'],
                'product.min_qty' => 'required|numeric|min:1',
                'product.current_stock' => 'required|numeric|min:1',
                'product.low_stock_qty' => 'required|numeric|min:0',
                'product.use_serial' => 'required|boolean',
                'product.allow_out_of_stock_purchases' => 'required|boolean'
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
        return [];
    }

    // protected function rules()
    // {

    //     // Define rules sets
    //     $this->rulesSets['content'] = [
    //         'product.thumbnail' => 'required|exists:App\Models\Upload,id',
    //         'product.gallery' => ['required', new EVModelsExist(Upload::class)],
    //         'product.video_provider' => 'nullable|in:youtube,vimeo,dailymotion',
    //         'product.video_link' => 'nullable|active_url',
    //         'product.pdf' => 'nullable|exists:App\Models\Upload,id',
            
    //     ];

    //     $this->rulesSets['price_stock_shipping'] = [
    //         'product.sku' => ['required', Rule::unique('product_stocks', 'sku')->ignore($this->product->stock->id ?? null)],
    //         'product.min_qty' => 'required|numeric|min:1',
    //         'product.current_stock' => 'required|numeric|min:1',
    //         'product.low_stock_qty' => 'required|numeric|min:0',
    //         'product.unit_price' => 'required|numeric',
    //         'product.purchase_price' => 'nullable|numeric',
    //         'product.discount' => 'required|numeric',
    //         'product.discount_type' => 'required|in:amount,percent',
    //         'product.stock_visibility_state' => 'required|in:quantity,text,hide',
    //         'product.shipping_type' => 'required|in:flat_rate,product_wise,free',
    //         'product.shipping_cost' => 'required_if:product.shipping_type,flat_rate',
    //         'product.is_quantity_multiplied' => 'required|boolean',
    //         'product.est_shipping_days' => 'nullable|numeric'
    //     ];

    //     $this->rulesSets['attributes'] = [
    //         'attributes.*' => 'required', //[ new AttributeValuesSelected() ]
    //     ];

    //     $this->rulesSets['seo'] = [
    //         'product.meta_title' => 'nullable',
    //         'product.meta_description' => 'nullable',
    //         'product.meta_img' => 'nullable',
    //     ];

    //     $rules = [];
    //     foreach($this->rulesSets as $key => $items) {
    //         $rules = array_merge($rules, $items);
    //     }

    //     return $rules;
    // }

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
            $this->product = $product;
            $this->is_update = true;
        } else {
            $this->is_update = false;

            $this->product = new Product();

            $this->product->slug = '';
            $this->product->status = StatusEnum::draft()->value;
            $this->product->user_id = auth()->user()->id;
            $this->product->shop_id = MyShop::getShop()->id;
            $this->product->is_quantity_multiplied = 1;
            $this->product->shipping_type = 'product_wise';
            $this->product->stock_visibility_state = 'quantity';
            $this->product->discount_type = 'amount';
            $this->product->discount = 0;
            $this->product->low_stock_qty = 0;
            $this->product->min_qty = 1;
            $this->product->unit_price = 0;
            $this->product->brand_id = null;

            // If insert
            $this->product->base_currency = FX::getCurrency()->code;
            $this->product->discount_type = AmountPercentTypeEnum::amount()->value;
            $this->product->tax_type = AmountPercentTypeEnum::amount()->value;
        }

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

        $this->setPredefinedAttributeValues($product);

        $this->initCategories($this->product);
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
            $this->validate($this->getRuleSet($set));
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatchValidationErrors($e);
            $this->validate($this->getRuleSet($set));
        }
    }

    public function saveMinimumRequired() {
        // TODO: Check if editor is trying to change status to published if not enough data is present
        
        if(!$this->is_update) {
            // Insert
            $new_product = Product::create([
                'shop_id' => MyShop::getShopID(),
                'user_id' => auth()->user()->id,
                'name' => $this->product->name,
                'unit_price' => $this->product->unit_price
            ]);

            $new_product->fill($this->product->attributesToArray()); // forceFill new product with $this->product attributes (without core properties of course)!
            $this->product = $new_product; // Swap $this->product with $new_product cuz $new_product is linked to the DB 

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
        $product_stock->sku = empty($this->product->sku) ? Str::slug($this->product->name) : $this->product->sku ;
        $product_stock->barcode = empty($this->product->barcode) ? null : $this->product->barcode ;
        $product_stock->qty = empty($this->product->current_stock) ? 0 : $this->product->current_stock;
        $product_stock->low_stock_qty = empty($this->product->low_stock_qty) ? 0 : $this->product->low_stock_qty;
        $product_stock->use_serial = ($this->product->use_serial ?? false) === true;
        $product_stock->allow_out_of_stock_purchases = ($this->product->allow_out_of_stock_purchases ?? false) === true;
        $product_stock->save();
    }

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

            $this->product->syncUploads();

            // Save Basic Info
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
            $this->saveMinimumRequired();

            $this->setAttributes();
            
            DB::commit();

            $this->toastify(translate('Product successfully saved!'), 'success');
        } catch(\Exception $e) {
            DB::rollBack();

            $this->dispatchGeneralError(translate('There was an error while saving a product.'));
            $this->toastify(translate('There was an error while saving a product. ').$e->getMessage(), 'danger');
        }
    }




    protected function insert(): void
    {
        DB::beginTransaction();
        $this->insert_success = false;

        try {
            // SET: Product Data
            $this->setProductData($partial ? 0 : 1);

            // SET: Product Categories
            $this->setProductCategories();

            // SET: Product Translations
            $this->setProductTranslation();

            // SET: Main Product Stocks
            $this->setProductStocks();

            // TODO: VAT & TAX, Flash Deals

            if(!$partial) {
                // SET: Attribute relationships
                $this->setAttributes();
            }

            DB::commit();

            $this->insert_success = true;

            //$this->emit('setProduct', $this->product);
            $this->dispatchBrowserEvent('goToTop');
        } catch(\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }

    protected function update() {
        $this->update_success = false;

        DB::beginTransaction();

        try {
            // SET: Product Data
            $this->setProductData();

            // SET: Product Categories
            $this->setProductCategories();

            // SET: Product Translations
            $this->setProductTranslation();

            // SET: Main & Variations Product Stocks
            $this->setProductStocks();

            // TODO: VAT & TAX, Flash Deals

            // SET: Attribute relationships
            $this->setAttributes();

            DB::commit();

            $this->update_success = true;

            $this->dispatchBrowserEvent('toastit', ['id' => '#product-updated-toast']);
            $this->dispatchBrowserEvent('goToTop');
        } catch(\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

    protected function setProductData($published = 1) {
        if(empty($this->product->brand_id)) {
            $this->product->brand_id = null;
        }

        if($this->action === 'insert') {
            if (auth()->user()->isSeller()) {
                $this->product->user_id = auth()->user()->id;
                $this->product->added_by = 'seller';
            } else {
                $this->product->user_id = \App\Models\User::where('user_type', 'admin')->first()->id;
                $this->product->added_by = 'admin';
            }
        }

        $this->product->tags = implode(',', $this->product->tags);

        if ($this->product->shipping_type === 'free') {
            $this->product->shipping_cost = 0;
        } elseif ($this->product->shipping_type === 'product_wise') {
            $this->product->shipping_cost = json_encode([]);
        }

        // Purify WYSIWYG before saving
        $this->product->description = Purifier::clean($this->product->description);

        if(empty($this->product->excerpt)) {
            $this->product->excerpt = strip_tags(Str::limit($this->product->description, 320, '...'));
        } else {
            $this->product->excerpt = strip_tags(Str::limit($this->product->excerpt, 320, '...'));
        }

        // SEO
        if (empty($this->product->meta_title)) {
            $this->product->meta_img = $this->product->name;
        }

        if (empty($this->product->meta_description)) {
            $this->product->meta_description = trim(strip_tags($this->product->description ?? ''));
        }

        // TODO: Add Featured, Cash on delivery, Today's deal to the form
        $this->product->cash_on_delivery = 0;
        $this->product->featured = 0;
        $this->product->todays_deal = 0;

        // TODO: Add Product status option to the form - published, draft
        $this->product->published = 1;

        // TODO: Remove following columns from the products table: variant_product, choice_options, colors, variations, current_stock, min_qty, low_stock_quantity
        // TODO: Move current_stock, min_qty and low_stock_quantity to Product Stocks table!

        // Save product
        $this->product->save();

        // DONE: Sync thumbnail, gallery, meta_img and other dynamic uploads
        $this->product->syncUploads();
    }

    protected function setProductCategories() {
        if(!empty($this->selected_categories)) {
            $categories_idx = collect([]);

            foreach($this->selected_categories as $selected) {
                // $selected is a slug_path of the category
                $cat = Categories::getBySlugPath($selected);

                if($cat) {
                    $categories_idx->push($cat['id']);
                }
            }

            $this->product->categories()->sync($categories_idx->toArray());
        }
    }

    protected function setProductTranslation() {
        $product_translation = ProductTranslation::firstOrNew(['lang' => config('app.locale'), 'product_id' => $this->product->id]);
        $product_translation->name = $this->product->name;
        $product_translation->unit = $this->product->unit;
        $product_translation->description = $this->product->description;
        // $product_translation->excerpt = $this->product->excerpt;
        // $product_translation->meta_title = $this->product->meta_title;
        // $product_translation->meta_description = $this->product->meta_description;
        $product_translation->save();
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

                        foreach($att_values as $att_value) {
                            // Create the value first
                            $att_val = (!empty($att_value['id'])) ? AttributeValue::find($att_value['id']) : new AttributeValue();
                            $att_val->attribute_id = (!empty($att_value['id'])) ? $att_val->attribute_id : $att->id;
                            $att_val->values = $att_value['values'] ?? null;
                            $att_val->selected = true;
                            $att_val->save();

                            if(empty($att_value['id'])) {
                                $att_value['id'] = $att_val->id;
    
                                // Set attribute value translations for non-predefined attributes
                                $attribute_value_translation = AttributeValueTranslation::firstOrNew(['lang' => config('app.locale'), 'attribute_value_id' => $att_val->id]);
                                $attribute_value_translation->name = $att_val->values;
                                $attribute_value_translation->save();
                            }
                        }
                    } else {
                        $selected_attribute_values = $this->selected_predefined_attribute_values['attribute.'.$att->id] ?? [];
                        
                        foreach($att_values as $key => $att_value) {
                            if(is_array($selected_attribute_values) && in_array($att_value['id'], $selected_attribute_values)) {
                                $att_values[$key]['selected'] = true;
                            } else if(is_numeric($selected_attribute_values) && ((int) $selected_attribute_values) == $att_value['id']) {
                                $att_values[$key]['selected'] = true;
                            } else {
                                $att_values[$key]['selected'] = false;
                            }
                        }
                    }
                    
                    foreach($att_values as $att_value) {
                        $att_value = (object) $att_value;

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
                }
            }
        }
    }

    public function updateAttributeValuesForVariations() {
        $atts = collect($this->attributes)->filter(function($att, $key) {
            $att = (object) $att;
            return $att->selected === true && $att->for_variations === true;
        });

        if($atts) {
            foreach ($atts as $att) {
                $att = (object)$att;
                $att_values = $att->attribute_values;

                if ($att_values) {
                    // ????
                    // TODO: What happens when attribute values (used for variations) are changed AND product is saved without touching the variations modal?
                    // FIX: It should SOFT DELETE product variations related to attribute value! IMPORTANT thing is to use SOFT DELETES, because if vendor wants to
                    // revive the attribute value for some reason and generate variations related to it, we need to bring back the old variations in the DB from the dead.
                    // This way we can always generate proper sales reports and never miss data!
                    // SOFT DELETES FOR PRODUCT VARIATIONS ARE VERY IMPORTANT!!!!
                    // NOTE: There can always be ONE product variation combination for certain product in the DB! We should never remove it fully, cuz we'll lose the data associated with it (number of variation sales, etc.)
                }
            }
        }
    }

    public function getVariationsAttributesProperty() {
        $atts_for_variations = collect($this->attributes)->filter(function($att, $key) {
            return ((object) $att)->for_variations === true;
        });

        return $atts_for_variations;
    }
}
