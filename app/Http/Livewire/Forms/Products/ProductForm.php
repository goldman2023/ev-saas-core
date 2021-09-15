<?php

namespace App\Http\Livewire\Forms\Products;

use App\Models\Attribute;
use App\Models\AttributeRelationship;
use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\ProductTranslation;
use App\Models\Upload;
use App\Rules\AttributeValuesSelected;
use App\Rules\EVModelsExist;
use DB;
use EV;
use Spatie\ValidationRules\Rules\ModelsExist;
use Livewire\Component;

class ProductForm extends Component
{
    protected $rulesSets;
    public $page;
    public $insert_success = false;

    public Product $product;
    public array $attributes;

    /*public $name;
    public $category_id;
    public $brand_id;
    public $unit;
    public $tags;

    public $thumbnail_img;
    public $photos;
    public $video_provider = '';
    public $video_link;
    public $pdf;
    public $description;

    public $min_qty;
    public $current_stock;
    public $low_stock_quantity;
    public $unit_price;
    public $purchase_price;
    public $discount = 0;
    public $discount_type = 'amount';
    public $stock_visibility_state;
    public $shipping_type;
    public $is_quantity_multiplied;
    public $set_shipping_days;*/

    protected function rules()
    {
        // Define rules sets
        $this->rulesSets['general'] = [
            'product.name' => 'required|min:6',
            'product.category_id' => 'required|exists:App\Models\Category,id',
            'product.brand_id' => 'nullable|exists:App\Models\Brand,id',
            'product.unit' => 'nullable|required', // TODO: make Units table or something like that
            'product.tags' => 'nullable|array',
        ];

        // Define rules sets
        $this->rulesSets['content'] = [
            'product.thumbnail_img' => 'required|exists:App\Models\Upload,id',
            'product.photos' => ['required', new EVModelsExist(Upload::class)],
            'product.video_provider' => 'nullable|in:youtube,vimeo,dailymotion',
            'product.video_link' => 'nullable|active_url',
            'product.pdf' => 'nullable|exists:App\Models\Upload,id',
            'product.description' => 'required|min:20',
        ];

        $this->rulesSets['price_stock_shipping'] = [
            'product.min_qty' => 'required|numeric|min:1',
            'product.current_stock' => 'required|numeric|min:1', //  new ModelsExist(Upload::class)
            'product.low_stock_quantity' => 'required|numeric|min:1',
            'product.unit_price' => 'required|numeric',
            'product.purchase_price' => 'nullable|numeric',
            'product.discount' => 'required|numeric',
            'product.discount_type' => 'required|in:amount,percent',
            'product.stock_visibility_state' => 'required|in:quantity,text,hide',
            'product.shipping_type' => 'required|in:flat_rate,product_wise,free',
            'product.flat_shipping_cost' => 'required_if:product.shipping_type,flat_rate',
            'product.is_quantity_multiplied' => 'required|boolean',
            'product.est_shipping_days' => 'nullable|numeric'
        ];

        $this->rulesSets['attributes_variations'] = [
            'attributes.*' => 'required', //[ new AttributeValuesSelected() ]
        ];

        $this->rulesSets['seo'] = [
            'product.meta_title' => 'nullable',
            'product.meta_description' => 'nullable',
            'product.meta_img' => 'nullable',
        ];

        $rules = [];
        foreach($this->rulesSets as $key => $items) {
            $rules = array_merge($rules, $items);
        }

        return $rules;
    }

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($page = '', $product = null)
    {
        $this->page = $page;
        $this->attributes = EV::getMappedAttributes('App\Models\Product', $product);

        // Set default params
        if($product) {
            $this->product = $product;
        } else {
            $this->product = new Product();
        }
        $this->product->slug = '';
        $this->product->is_quantity_multiplied = 1;
        $this->product->shipping_type = 'product_wise';
        $this->product->stock_visibility_state = 'quantity';
        $this->product->discount_type = 'amount';
        $this->product->discount = 0;
        $this->product->low_stock_quantity = 1;
        $this->product->min_qty = 1;
        $this->product->brand_id = null;

        // Set default attributes
        foreach($this->attributes as $key => $attribute) {
            if($attribute->type === 'dropdown' || $attribute->type === 'radio' || $attribute->type === 'checkbox') {
                $attribute->selcted_values = '';
            }

            if(empty($this->attributes[$key]->attribute_values)) {
                if($attribute->type !== 'dropdown' && $attribute->type !== 'radio' && $attribute->type !== 'checkbox') {
                    $this->attributes[$key]->attribute_values[] = [
                        "id" => null,
                        "attribute_id" => $attribute->id,
                        "values" => '',
                        "selected" => true,
                    ];
                }
            }
        }
        //dd($this->attributes);
    }

    public function validateSpecificSet($set_name, $next_page, $is_last = false)
    {
        if($set_name) {
            foreach($this->rulesSets as $key => $set) {
                $this->page = $key; // set page
                $this->validate($set); // validate page

                if($set_name == $key) {
                    break;
                }
            }

            if($is_last) {
                $this->insert();
            } else {
                $this->page = $next_page;
            }
        }
    }

    protected function insert() {
        DB::beginTransaction();

        try {
            if(empty($this->product->brand_id)) {
                $this->product->brand_id = null;
            }

            // Create new product!
            if (auth()->user()->isSeller()) {
                $this->product->user_id = auth()->user()->id;
                $this->product->added_by = 'seller';
            } else {
                $this->product->user_id = \App\Models\User::where('user_type', 'admin')->first()->id;
                $this->product->added_by = 'admin';
            }

            $this->product->tags = implode(',', $this->product->tags);

            if ($this->product->shipping_type === 'free') {
                $this->product->shipping_cost = 0;
            } elseif ($this->product->shipping_type === 'flat_rate') {
                $this->product->shipping_cost = $this->product->flat_shipping_cost;
            } elseif ($this->product->shipping_type === 'product_wise') {
                $this->product->shipping_cost = json_encode([]);
            }

            unset($this->product->flat_shipping_cost);

            if (empty($this->product->meta_img)) {
                $this->product->meta_img = $this->product->thumbnail_img;
            }

            if (empty($this->product->meta_title)) {
                $this->product->meta_img = $this->product->name;
            }

            if (empty(trim($this->product->meta_description))) {
                $this->product->meta_description = trim(strip_tags($this->product->description));
            }

            // TODO: Add Featured, Cash on delivery, Todays deal to the form
            $this->product->cash_on_delivery = 0;
            $this->product->featured = 0;
            $this->product->todays_deal = 0;

            // TODO: Add Product status option to the form - published, draft
            $this->product->published = 1;

            // TODO: Remove following columns from the products table: variant_product, choice_options, colors, variations, current_stock, min_qty, low_stock_quantity
            // TODO: Move current_stock, min_qty and low_stock_quantity to Product Stocks table!

            // Save product
            $this->product->save();

            // CREATE: Product Translations
            $product_translation = ProductTranslation::firstOrNew(['lang' => config('app.locale'), 'product_id' => $this->product->id]);
            $product_translation->name = $this->product->name;
            $product_translation->unit = $this->product->unit;
            $product_translation->description = $this->product->description;
            $product_translation->save();

            // TODO: VAT & TAX, Flash Deals

            // CREATE: Attribute relationships
            $selected_attributes = collect($this->attributes)->filter(function($att, $key) {
                $att = (object) $att;
                return $att->selected === true;
            });

            if($selected_attributes) {
                foreach($selected_attributes as $att) {
                    $att = (object) $att;
                    $att_values = $att->attribute_values;

                    if($att_values) {
                        if(isset($att_values['values'])) {
                            // Create the value first
                            $att_val = new AttributeValue();
                            $att_val->attribute_id = $att->id;
                            $att_val->values = $att_values['values'];
                            $att_val->save();

                            $att_values['id'] = $att_val->id;

                            $att_values = [$att_values];
                        }

                        foreach($att_values as $att_value) {
                            $att_value = (object) $att_value;
                            if($att_value->selected ?? null) {
                                // Create product-attribute relationship
                                $att_rel = new AttributeRelationship();
                                $att_rel->subject_type = 'App\Models\Product';
                                $att_rel->subject_id = $this->product->id;
                                $att_rel->attribute_id = $att->id;
                                $att_rel->attribute_value_id = $att_value->id;
                                $att_rel->for_variations = $att->for_variations;
                                $att_rel->save();
                            }
                        }
                    }
                }
            }

            // CREATE: Main & Variations Product Stocks
            // TODO: Create proper product stocks for variations!
            $product_stock = new ProductStock();
            $product_stock->product_id = $this->product->id;
            $product_stock->price = $this->product->unit_price;
            $product_stock->qty = $this->product->current_stock;
            $product_stock->save();

            DB::commit();

            $this->insert_success = true;

            $this->dispatchBrowserEvent('goToTop');
        } catch(\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('initProductForm');
        //$this->dispatchBrowserEvent('goToTop');
    }

    public function render()
    {
        return view('livewire.forms.product-form');
    }
}
