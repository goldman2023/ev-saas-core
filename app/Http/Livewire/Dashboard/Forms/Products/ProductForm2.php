<?php

namespace App\Http\Livewire\Dashboard\Forms\Products;

use DB;
use FX;
use EVS;
use Str;
use MyShop;
use Purifier;
use Categories;
use App\Models\Upload;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use App\Models\CoreMeta;
use App\Enums\StatusEnum;
use App\Models\Attribute;
use App\Models\ProductStock;
use App\Rules\EVModelsExist;
use App\Enums\ProductTypeEnum;
use App\Models\AttributeValue;
use App\Facades\TenantSettings;
use Illuminate\Validation\Rule;
use App\Models\ProductTranslation;
use App\Traits\Livewire\CanDelete;
use App\Traits\Livewire\RulesSets;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use App\Enums\AmountPercentTypeEnum;
use App\Models\AttributeTranslation;
use App\Traits\Livewire\HasCoreMeta;
use App\Models\AttributeRelationship;
use App\Rules\AttributeValuesSelected;
use App\Traits\Livewire\HasAttributes;
use App\Traits\Livewire\HasCategories;
use App\Traits\Livewire\DispatchSupport;
use App\Models\AttributeValueTranslation;
use Illuminate\Contracts\Support\Arrayable;
use Spatie\ValidationRules\Rules\ModelsExist;
use Spatie\Activitylog\Facades\CauserResolver;

class ProductForm2 extends Component
{
    use DispatchSupport;
    use RulesSets;
    use HasCategories;
    use CanDelete;
    use HasCoreMeta;
    use HasAttributes;

    public $product;

    public $is_update;

    protected $listeners = [
        'refreshProductForm' => '$refresh'
    ];

    protected function getRuleSet($set = null)
    {
        $rulesSets = collect([
            'minimum_required' => [
                'product.name' => 'required|min:6',
                'product.unit_price' => 'required|numeric',
                // 'product.sku' => ['required', Rule::unique('product_stocks', 'sku')->ignore($this->product->stock->id ?? null)],
            ],
            'basic' => [
                'product.name' => 'required|min:6',
                'product.description' => 'nullable',
                'product.excerpt' => 'nullable',
                // 'product.status' => [Rule::in(StatusEnum::toValues())],
                'product.type' => [Rule::in(ProductTypeEnum::toValues())],
            ],
            'status' => [
                'product.status' => [Rule::in(StatusEnum::toValues())],
            ],
            'categories_and_tags' => [
                'selected_categories' => 'nullable',
                'product.tags' => 'nullable|array',
            ],
            'brand' => [
                'product.brand_id' => 'nullable|exists:App\Models\Brand,id',
            ],
            'media' => [
                'product.thumbnail' => ['if_id_exists:App\Models\Upload,id,true'],
                'product.cover' => ['if_id_exists:App\Models\Upload,id,true'],
                'product.gallery' => ['nullable'], // 'if_id_exists:App\Models\Upload,id,true'
                'product.video_provider' => 'nullable|in:youtube,vimeo,dailymotion',
                'product.video_link' => 'nullable|active_url',
                'product.pdf' => ['nullable', 'if_id_exists:App\Models\Upload,id,true'],
            ],
            'pricing' => [
                'product.unit_price' => 'required|numeric',
                'product.base_currency' => [Rule::in(FX::getAllCurrencies()->map(fn ($item) => $item->code)->toArray())],
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
                'custom_attributes.*' => 'required',
                'selected_predefined_attribute_values.*' => '',
            ],
            'seo' => [
                'product.meta_title' => 'nullable',
                'product.meta_description' => 'nullable',
                'product.meta_img' => 'nullable',
            ],
            'core_meta' => [
                'core_meta' => '',
            ]
        ]);

        return empty($set) || $set === 'all' ? $rulesSets : $rulesSets->get($set);
    }

    protected function rules()
    {
        $rules = [];
        foreach ($this->getRuleSet('all') as $key => $items) {
            $rules = array_merge($rules, $items);
        }

        return $rules;
    }

    protected function messages()
    {
        return [
            'product.thumbnail.if_id_exists' => translate('Please select a valid thumbnail image from the media library'),
            'product.cover.if_id_exists' => translate('Please select a valid cover image from the media library'),
            'product.pdf.if_id_exists' => translate('Please select a valid specification document from the media library'),
            'selected_categories.required' => translate('You must select at least 1 category'),
        ];
    }

    public function getWEFRules() {
        return [
            'wef.content_structure' => 'required',
            'wef.date_type' => ['exclude_unless:product.type,event', Rule::in(['range', 'specific'])], // range, specific
            'wef.start_date' => ['exclude_unless:product.type,event', 'required_if:product.type,event'], //'required_if:product.type,event|date',
            'wef.end_date' => 'nullable',
            'wef.location_type' => ['exclude_unless:product.type,event', Rule::in(['remote', 'offline'])], // remote, location
            'wef.location_address' => 'nullable',
            'wef.location_address_map_link' => 'nullable',
            'wef.location_link' => 'nullable',
            'wef.unlockables' => 'nullable',
            'wef.unlockables_structure' => 'nullable',
            'wef.calendly_link' => ['exclude_unless:product.type,bookable_service', 'required_if:product.type,bookable_service', 'url'], // should be required if product type is bookable_service or bookable_subscription_service
            'wef.thank_you_cta_custom_title' => 'nullable',
            'wef.thank_you_cta_custom_text' => 'nullable',
            'wef.thank_you_cta_custom_url' => 'nullable',
            'wef.thank_you_cta_custom_button_title' => 'nullable',
    
            // Course
            'wef.course_what_you_will_learn' => ['exclude_unless:product.type,course', 'nullable', 'array'],
            'wef.course_requirements' => ['exclude_unless:product.type,course', 'nullable', 'array'],
            'wef.course_target_audience' => ['exclude_unless:product.type,course', 'nullable', 'array'],
            'wef.course_includes' => ['exclude_unless:product.type,course', 'nullable', 'array'],
        ];
    }

    public function getWEFMessages() {
        return [];
    }

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount(&$product = null)
    {
        // Set default params
        if ($product) {
            // Update
            $this->product = $product;
            $this->is_update = true;
        } else {
            // Insert
            $this->is_update = false;

            /* Check if user has shop */
            if (! MyShop::getShop()) {
                return redirect()->route('onboarding.step4');
            }

            $this->product = (new Product())->load(['uploads']);

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

        $this->refreshAttributes($this->product);

        $this->initCategories($this->product);

        $this->initCoreMeta($this->product);
    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('init-form');
    }

    public function render()
    {
        return view('livewire.dashboard.forms.products.product-form2');
    }

    public function refreshVariationsDatatable()
    {
        // TODO: Refresh variations datatable
        // $this->emit('refreshDatatable');
        //$this->emit('updatedAttributeValues', $this->variations_attributes);
    }

    public function removeAttributeValue($id)
    {
        DB::beginTransaction();

        try {
            // remove the attribute -> this will remove attribute value translations and relationships too!
            AttributeValue::destroy($id);

            DB::commit();

            $this->toastify(translate('Attribute value successfully removed!'), 'success');
        } catch (\Exception $e) {
            DB::rollBack();

            $this->dispatchGeneralError(translate('There was an error while removing an attribute value...Please try again.'));
            $this->toastify(translate('There was an error while removing an attribute value...Please try again. ').$e->getMessage(), 'danger');
        }
    }

    public function validateData($set = 'minimum_required')
    {
        try {
            $this->validate($set === 'all' ? $this->rules() : $this->getRuleSet($set));
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatchValidationErrors($e);

            // Reset status to Draft!
            $this->product->status = StatusEnum::draft()->value;
            $this->validate($set === 'all' ? $this->rules() : $this->getRuleSet($set));
        }
    }

    public function saveMinimumRequired()
    {
        // TODO: Check if editor is trying to change status to published if not enough data is present

        if (! $this->is_update) {
            // Insert
            $this->product->shop_id = MyShop::getShopID();
            $this->product->user_id = auth()->user()->id;
            $this->product->name = $this->product->name;
            $this->product->unit_price = $this->product->unit_price;
            $this->product->save();

            // $this->is_update = true; // Change is_update flag to true! From now on, product is being only updated!
        } else {
            // Update
            $this->product->update([
                'shop_id' => MyShop::getShopID(),
                'user_id' => auth()->user()->id,
                'name' => $this->product->name,
                'unit_price' => $this->product->unit_price,
            ]); // update only minimum required fields
        }

        // Set Product Stock
        $this->setProductStocks();
    }

    /* TODO: Update this to check if stock is not created on a global scope, not only in product form */
    protected function setProductStocks()
    {
        $product_stock = ProductStock::firstOrNew(['subject_id' => $this->product->id, 'subject_type' => Product::class]);
        $product_stock->track_inventory = ($this->product->track_inventory ?? false) === true;
        $product_stock->sku = empty($this->product->sku) ? \UUID::generate(4)->string : $this->product->sku;
        $product_stock->barcode = empty($this->product->barcode) ? null : $this->product->barcode;
        $product_stock->qty = empty($this->product->current_stock) ? 0 : $this->product->current_stock;
        $product_stock->low_stock_qty = empty($this->product->low_stock_qty) ? 0 : $this->product->low_stock_qty;
        $product_stock->use_serial = ($this->product->use_serial ?? false) === true;
        $product_stock->allow_out_of_stock_purchases = ($this->product->allow_out_of_stock_purchases ?? false) === true;
        $product_stock->save();
    }

    public function saveProduct()
    {
        $this->validateData('all');

        DB::beginTransaction();

        try {
            // Causer is Shop, not user
            CauserResolver::setCauser(MyShop::getShop());

            $this->saveMinimumRequired();

            // Save product data
            // $this->product->tags = [];
            $this->product->save();

            // Sync Uploads
            $this->product->syncUploads();

            // Save Categories
            $this->setCategories($this->product);

            // Set Attributes
            $this->setAttributes($this->product);

            // Save core meta and WEFs
            $this->saveAllCoreMeta($this->product);

            DB::commit();

            // Refresh Attributes
            $this->refreshAttributes($this->product);

            $this->inform(translate('Product successfully saved!'), '', 'success');

            if (! $this->is_update) {
                return redirect()->route('product.edit', $this->product->id);
            }

            // $this->dispatchBrowserEvent('init-product-form', []);
        } catch (\Exception $e) {
            DB::rollBack();

            $this->dispatchGeneralError(translate('There was an error while saving a product.'));
            $this->inform(translate('There was an error while saving a product.'), $e->getMessage(), 'fail');
        }
    }

    // END

    // DEPRECATED!!!
    public function saveBasic()
    {
        // Validate minimum required fields and insert/update row
        $this->validateData('minimum_required');

        DB::beginTransaction();

        try {
            $this->saveMinimumRequired();

            // Save Basic Info
            $this->product->update([
                'excerpt' => $this->product->excerpt,
                'description' => $this->product->description,
                'status' => $this->product->status,
            ]);

            DB::commit();

            $this->toastify(translate('Product successfully saved!'), 'success');
        } catch (\Exception $e) {
            DB::rollBack();

            $this->dispatchGeneralError(translate('There was an error while saving a product.'));
            $this->toastify(translate('There was an error while saving a product. ').$e->getMessage(), 'danger');
        }
    }

    public function saveMedia()
    {
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
                'video_link' => $this->product->video_link,
            ]);

            DB::commit();

            $this->toastify(translate('Product successfully saved!'), 'success');
        } catch (\Exception $e) {
            DB::rollBack();

            $this->dispatchGeneralError(translate('There was an error while saving a product.'));
            $this->toastify(translate('There was an error while saving a product. ').$e->getMessage(), 'danger');
        }
    }

    public function savePricing()
    {
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
        } catch (\Exception $e) {
            DB::rollBack();

            $this->dispatchGeneralError(translate('There was an error while saving a product.'));
            $this->toastify(translate('There was an error while saving a product. ').$e->getMessage(), 'danger');
        }
    }

    public function saveInventory()
    {
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
        } catch (\Exception $e) {
            DB::rollBack();

            $this->dispatchGeneralError(translate('There was an error while saving a product.'));
            $this->toastify(translate('There was an error while saving a product. ').$e->getMessage(), 'danger');
        }
    }

    public function saveShipping()
    {
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
        } catch (\Exception $e) {
            DB::rollBack();

            $this->dispatchGeneralError(translate('There was an error while saving a product.'));
            $this->toastify(translate('There was an error while saving a product. ').$e->getMessage(), 'danger');
        }
    }

    public function saveSEO()
    {
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
                'meta_description' => $this->product->meta_description,
            ]);

            DB::commit();

            $this->toastify(translate('Product successfully saved!'), 'success');
        } catch (\Exception $e) {
            DB::rollBack();

            $this->dispatchGeneralError(translate('There was an error while saving a product.'));
            $this->toastify(translate('There was an error while saving a product. ').$e->getMessage(), 'danger');
        }
    }

    public function saveCategoriesAndTags()
    {
        // Validate minimum required fields and insert/update row
        $this->validateData('minimum_required');

        $this->validateData('categories_and_tags');

        DB::beginTransaction();

        try {
            $this->saveMinimumRequired();

            // Save Tags
            $this->product->update([
                'product.tags' => $this->product->tags,
            ]);

            // Save Categories
            $this->setCategories($this->product);

            DB::commit();

            $this->toastify(translate('Product successfully saved!'), 'success');
        } catch (\Exception $e) {
            DB::rollBack();

            $this->dispatchGeneralError(translate('There was an error while saving a product.'));
            $this->toastify(translate('There was an error while saving a product. ').$e->getMessage(), 'danger');
        }
    }

    public function saveBrand()
    {
        // Validate minimum required fields and insert/update row
        $this->validateData('minimum_required');

        $this->validateData('brand');

        DB::beginTransaction();

        try {
            $this->saveMinimumRequired();

            // Save Brand
            $this->product->update([
                'product.brand_id' => $this->product->brand_id,
            ]);

            DB::commit();

            $this->toastify(translate('Product successfully saved!'), 'success');
        } catch (\Exception $e) {
            DB::rollBack();

            $this->dispatchGeneralError(translate('There was an error while saving a product.'));
            $this->toastify(translate('There was an error while saving a product. ').$e->getMessage(), 'danger');
        }
    }

    public function updateStatus()
    {
        // Validate minimum required fields and insert/update row
        $this->validateData('minimum_required');

        $this->validateData('status');

        DB::beginTransaction();

        try {
            $this->saveMinimumRequired();

            // Update status
            $this->product->update([
                'product.status' => $this->product->status,
            ]);

            DB::commit();

            $this->toastify(translate('Status successfully updated to').': '.$this->product->status, 'success');
        } catch (\Exception $e) {
            DB::rollBack();

            $this->dispatchGeneralError(translate('There was an error while updating the status.'));
            $this->toastify(translate('There was an error while updating the status. ').$e->getMessage(), 'danger');
        }
    }



    // public function updateAttributeValuesForVariations() {
    //     $atts = collect($this->product_attributes)->filter(function($att, $key) {
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
    //     $atts_for_variations = collect($this->product_attributes)->filter(function($att, $key) {
    //         return ((object) $att)->for_variations === true;
    //     });

    //     return $atts_for_variations;
    // }
}
