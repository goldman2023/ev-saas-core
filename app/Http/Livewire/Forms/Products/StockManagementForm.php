<?php

namespace App\Http\Livewire\Forms\Products;

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
use DB;
use EVS;
use Categories;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Purifier;
use Spatie\ValidationRules\Rules\ModelsExist;
use Livewire\Component;
use Str;

class StockManagementForm extends Component
{
    protected array $rulesSets;
    public bool $update_success = false;

    public ?Product $product;
    public $attributes;
    public $serial_numbers;
    public $serial_status;
    public $serial_search;

    protected $listeners = [

    ];

    protected function rules()
    {
        // Define rules sets
        $this->rulesSets['main_stock'] = [
            'product.temp_sku' => ['required', Rule::unique('product_stocks', 'sku')->ignore($this->product->stock->id ?? null)],
            'product.current_stock' => 'required|numeric|min:0',
            'product.low_stock_qty' => 'required|numeric|min:0',
            'product.use_serial' => 'required|bool',
            'product.stock_visibility_state' => 'required|in:quantity,text,hide',
        ];

        // Define rules sets
        /*$this->rulesSets['content'] = [
            'product.thumbnail' => 'required|exists:App\Models\Upload,id',
            'product.gallery' => ['required', new EVModelsExist(Upload::class)],
            'product.video_provider' => 'nullable|in:youtube,vimeo,dailymotion',
            'product.video_link' => 'nullable|active_url',
            'product.pdf' => 'nullable|exists:App\Models\Upload,id',
            'product.description' => 'required|min:20',
            'product.excerpt' => 'nullable',
        ];

        $this->rulesSets['price_stock_shipping'] = [
            'product.temp_sku' => ['required', Rule::unique('product_stocks', 'sku')->ignore($this->product->stock->id ?? null)],
            'product.min_qty' => 'required|numeric|min:1',
            'product.current_stock' => 'required|numeric|min:1',
            'product.low_stock_qty' => 'required|numeric|min:0',
            'product.unit_price' => 'required|numeric',
            'product.purchase_price' => 'nullable|numeric',
            'product.discount' => 'required|numeric',
            'product.discount_type' => 'required|in:amount,percent',
            'product.stock_visibility_state' => 'required|in:quantity,text,hide',
            'product.shipping_type' => 'required|in:flat_rate,product_wise,free',
            'product.shipping_cost' => 'required_if:product.shipping_type,flat_rate',
            'product.is_quantity_multiplied' => 'required|boolean',
            'product.est_shipping_days' => 'nullable|numeric'
        ];

        $this->rulesSets['attributes'] = [
            'attributes.*' => 'required', //[ new AttributeValuesSelected() ]
        ];

        $this->rulesSets['seo'] = [
            'product.meta_title' => 'nullable',
            'product.meta_description' => 'nullable',
            'product.meta_img' => 'nullable',
        ];*/

        $rules = [];
        foreach($this->rulesSets as $key => $items) {
            $rules = array_merge($rules, $items);
        }

        return $rules;
    }

    /**
     * Create a new component instance.
     *
     * @param ?Product $product Passed Product model as a pointer
     * @return void
     */
    public function mount(Product &$product = null)
    {
        // Set default params
        if($product) {
            $this->product = $product;
            $this->serial_numbers = $this->product->serial_numbers;
            $this->attributes = $this->product->variant_attributes();
            $this->status = '';
        }

        // Set default attributes
        /*foreach($this->attributes as $key => $attribute) {
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
                    if(empty($this->attributes[$key]->attribute_values)) {
                        $this->attributes[$key]->attribute_values = [];
                    }
                }
            }
        }*/

    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('initStockManagementForm');
        //$this->dispatchBrowserEvent('goToTop');
    }

    public function render()
    {
        return view('livewire.forms.products.product-stock-management-form');
    }

    public function updatedSerialStatus() {
        // TODO: get with status among searched items
        if(empty($this->serial_status)) {
            $this->serial_numbers = $this->product->serial_numbers;
        } else {
            $this->serial_numbers = $this->product->serial_numbers->where('status', $this->serial_status);
        }
    }

    public function updatedSerialSearch() {
        //$this->updatedSerialStatus();
        //TODO: Search among selected statuses
        $this->serial_numbers = $this->product->serial_numbers->filter(function ($item) {
            return str_contains($item->serial_number, $this->serial_search) !== false;
        });
    }

    public function validateSpecificSet($set_name, $next_page, $is_last = false, $insert_on_step = null)
    {
        if($set_name) {
            foreach($this->rulesSets as $key => $set) {
                $this->validate($set); // validate page

                if($set_name == $key) {
                    break;
                }
            }

            if($set_name === 'main_stock') {
                // Update Main Product Stock
                $this->updateMainStock();
            } else if($set_name === 'variations_stock') {
                // Update Variations Stocks
                $this->updateVariationsStocks();
            }
        }
    }

    protected function updateMainStock() {
        $this->update_success = false;

        DB::beginTransaction();

        try {


            DB::commit();

            $this->update_success = true;

            //$this->dispatchBrowserEvent('toastIt', ['id' => '#product-updated-toast']);
            $this->dispatchBrowserEvent('goToTop');
        } catch(\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

    protected function updateVariationsStocks() {
        $this->update_success = false;

        DB::beginTransaction();

        try {


            DB::commit();

            $this->update_success = true;

            //$this->dispatchBrowserEvent('toastIt', ['id' => '#product-updated-toast']);
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

        // DONE: Sync thumbnail, gallery, meta_img and other dynamic uploads
        $this->product->syncUploads();

        // SEO
        if (empty($this->product->meta_img)) {
            $this->product->meta_img = $this->product->thumbnail_img;
        }

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
        $product_translation->save();
    }

    protected function setProductStocks() {
        $product_stock = ProductStock::firstOrNew(['subject_id' => $this->product->id, 'subject_type' => Product::class]);
        $product_stock->sku = $this->product->temp_sku;
        $product_stock->qty = $this->product->current_stock;
        $product_stock->low_stock_qty = $this->product->low_stock_qty;
        $product_stock->save();
    }
}
