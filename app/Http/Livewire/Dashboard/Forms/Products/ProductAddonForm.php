<?php

namespace App\Http\Livewire\Dashboard\Forms\Products;

use DB;
use FX;
use WE;
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
use App\Models\ProductAddon;
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
use App\Enums\ProductAddonTypeEnum;
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

class ProductAddonForm extends Component
{
    use DispatchSupport;
    use RulesSets;
    use HasCategories;
    use CanDelete;
    use HasCoreMeta;
    use HasAttributes;

    public $productAddon;
    public $is_update;

    protected $listeners = [
        'refreshProductAddonForm' => '$refresh'
    ];

    protected function rulesSets()
    {
        return [
            'main' => [
                'productAddon.name' => 'required|min:6',
                'productAddon.description' => 'nullable',
                'productAddon.excerpt' => 'nullable',
                'productAddon.status' => [Rule::in(StatusEnum::toValues())],
                'productAddon.type' => [Rule::in(ProductAddonTypeEnum::toValues())],
            ],
            'categories' => [
                'selected_categories' => 'nullable',
            ],
            'media' => [
                'productAddon.thumbnail' => ['if_id_exists:App\Models\Upload,id,true'],
                'productAddon.cover' => ['if_id_exists:App\Models\Upload,id,true'],
                'productAddon.gallery' => ['nullable'],
            ],
            'pricing' => [
                'productAddon.unit_price' => 'required|numeric',
                'productAddon.base_currency' => [Rule::in(FX::getAllCurrencies()->map(fn ($item) => $item->code)->toArray())],
                'productAddon.discount' => 'nullable|numeric',
                'productAddon.discount_type' => 'nullable|in:amount,percent',
            ],
            'inventory' => [
                'productAddon.unit' => 'nullable',
                'productAddon.sku' => ['nullable', Rule::unique('product_stocks', 'sku')->ignore($this->productAddon->stock->id ?? null)],
                'productAddon.barcode' => ['nullable'],
                'productAddon.current_stock' => 'required|numeric|min:0',
                'productAddon.low_stock_qty' => 'required|numeric|min:0',
                'productAddon.use_serial' => 'required|boolean',
                'productAddon.allow_out_of_stock_purchases' => 'required|boolean',
                'productAddon.track_inventory' => 'required|boolean',
            ],
            'attributes' => [
                'custom_attributes.*' => 'required',
                'selected_predefined_attribute_values.*' => '',
            ],
            'seo' => [
                'productAddon.meta_title' => 'nullable',
                'productAddon.meta_description' => 'nullable',
                'productAddon.meta_img' => 'nullable',
            ],
            'core_meta' => [
                'core_meta' => [],
            ],
            'wef' => $this->getWEFRules(),
        ];
    }

    protected function rules()
    {
        return $this->getRuleSetsCombined([
            'main',
            'media',
            'categories',
            'pricing',
            'inventory',
            'attributes',
            'seo',
            'core_meta',
            'wef',
        ]);
    }

    protected function messages()
    {
        return [
            'productAddon.name.required' => translate('Name is required'),
            'productAddon.thumbnail.if_id_exists' => translate('Please select a valid thumbnail image from the media library'),
            'productAddon.cover.if_id_exists' => translate('Please select a valid cover image from the media library'),
            'productAddon.pdf.if_id_exists' => translate('Please select a valid specification document from the media library'),
        ];
    }

    public function getWEFRules() {
        return [

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
    public function mount(&$productAddon = null)
    {
        // dd(collect(\Categories::getAllFormatted(for_js: true, flat: true))->keyBy('id')->map(fn($item) => $item['name']));
        // Set default params
        if ($productAddon) {
            // Update
            $this->productAddon = $productAddon;
            $this->is_update = true;
        } else {
            // Insert
            $this->is_update = false;

            /* Check if user has shop */
            if (! MyShop::getShop()) {
                return redirect()->route('onboarding.step4');
            }
            $this->productAddon = (new ProductAddon())->load(['uploads']);
            
            $this->productAddon->slug = '';
            $this->productAddon->status = StatusEnum::draft()->value;
            $this->productAddon->type = ProductAddonTypeEnum::standard()->value;
            $this->productAddon->track_inventory = false;
            $this->productAddon->user_id = auth()->user()->id;
            $this->productAddon->shop_id = MyShop::getShop()->id;
            $this->productAddon->discount = 0;
            $this->productAddon->low_stock_qty = 0;
            $this->productAddon->use_serial = false;
            $this->productAddon->allow_out_of_stock_purchases = false;
            // $this->productAddon->min_qty = 1; // TODO: Move to product_stocks table
            $this->productAddon->unit_price = 0;
            $this->productAddon->base_currency = FX::getCurrency()->code;
            $this->productAddon->discount_type = AmountPercentTypeEnum::amount()->value;
        }

        $this->refreshAttributes($this->productAddon);

        $this->initCategories($this->productAddon);

        $this->initCoreMeta($this->productAddon);
    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('init-form');
    }

    public function render()
    {
        return view('livewire.dashboard.forms.products.product-addon-form');
    }

    protected function setProductAddonStocks()
    {
        $product_stock = ProductStock::firstOrNew(['subject_id' => $this->productAddon->id, 'subject_type' => $this->productAddon::class]);
        $product_stock->track_inventory = ($this->productAddon->track_inventory ?? false) === true;
        $product_stock->sku = empty($this->productAddon->sku) ? \UUID::generate(4)->string : $this->productAddon->sku;
        $product_stock->barcode = empty($this->productAddon->barcode) ? null : $this->productAddon->barcode;
        $product_stock->qty = empty($this->productAddon->current_stock) ? 0 : $this->productAddon->current_stock;
        $product_stock->low_stock_qty = empty($this->productAddon->low_stock_qty) ? 0 : $this->productAddon->low_stock_qty;
        $product_stock->use_serial = ($this->productAddon->use_serial ?? false) === true;
        $product_stock->allow_out_of_stock_purchases = ($this->productAddon->allow_out_of_stock_purchases ?? false) === true;
        $product_stock->save();
    }

    public function saveProductAddon()
    {
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatchValidationErrors($e);

            // Reset status to Draft!
            $this->productAddon->status = StatusEnum::draft()->value;
            $this->validate();
        }

        DB::beginTransaction();

        try {
            // Causer is Shop, not user
            CauserResolver::setCauser(MyShop::getShop());
            
            // Save product data
            $this->productAddon->user_id = auth()->user()->id; // these are not set in rules, so must be set again here!
            $this->productAddon->shop_id = MyShop::getShop()->id; // these are not set in rules, so must be set again here!
            $this->productAddon->save();

            // Sync Uploads
            $this->productAddon->syncUploads();

            // Save Stocks
            $this->setProductAddonStocks();

            // Save Categories
            $this->setCategories($this->productAddon);

            // Set Attributes
            $this->setAttributes($this->productAddon);

            // Save core meta and WEFs
            $this->saveAllCoreMeta($this->productAddon);

            DB::commit();

            // Refresh Attributes
            $this->refreshAttributes($this->productAddon);

            $this->inform(translate('Product Addon successfully saved!'), '', 'success');

            if (! $this->is_update) {
                return redirect()->route('product-addon.edit', $this->productAddon->id);
            }

            // $this->dispatchBrowserEvent('init-product-form', []);
        } catch (\Exception $e) {
            DB::rollBack();

            $this->dispatchGeneralError(translate('There was an error while saving a product addon.'));
            $this->inform(translate('There was an error while saving a product addon.'), $e->getMessage(), 'fail');
        }
    }
}
