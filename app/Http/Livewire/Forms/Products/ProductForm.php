<?php

namespace App\Http\Livewire\Forms\Products;

use App\Models\Attribute;
use App\Models\AttributeRelationship;
use App\Models\AttributeTranslation;
use App\Models\AttributeValue;
use App\Facades\BusinessSettings;
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
    protected array $rulesSets;
    public string $page;
    public string $action;
    public bool $insert_success = false;
    public bool $update_success = false;

    public Product $product;
    public array $attributes;
    public array $variations;


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

        $this->rulesSets['attributes'] = [
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
            $this->action = 'update';

            $this->variations = $this->product->variations()->get()->toArray();
        } else {
            $this->product = new Product();
            $this->action = 'insert';
            $this->variations = [];
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
                if(empty($this->product->id)) {
                    $this->insert();
                } else {
                    $this->update();
                }
            } else {
                $this->page = $next_page;
            }
        }
    }

    protected function insert() {
        DB::beginTransaction();

        try {
            // SET: Product Data
            $this->setProductData();

            // SET: Product Translations
            $this->setProductTranslation();

            // TODO: VAT & TAX, Flash Deals

            // SET: Attribute relationships
            $this->setAttributes();

            // SET: Main & Variations Product Stocks
            $this->setProductStocks();

            DB::commit();

            $this->insert_success = true;

            $this->dispatchBrowserEvent('goToTop');
        } catch(\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }

    protected function update() {
        DB::beginTransaction();

        try {
            // SET: Product Data
            $this->setProductData();

            // SET: Product Translations
            $this->setProductTranslation();


            // TODO: VAT & TAX, Flash Deals

            // SET: Attribute relationships
            $this->setAttributes();

            // SET: Main & Variations Product Stocks
            $this->setProductStocks();

            DB::commit();

            $this->update_success = true;

            $this->dispatchBrowserEvent('goToTop');
        } catch(\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }

    protected function setProductData() {
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
    }

    protected function setProductTranslation() {
        $product_translation = ProductTranslation::firstOrNew(['lang' => config('app.locale'), 'product_id' => $this->product->id]);
        $product_translation->name = $this->product->name;
        $product_translation->unit = $this->product->unit;
        $product_translation->description = $this->product->description;
        $product_translation->save();
    }

    protected function setProductStocks() {
        // TODO: Create proper product stocks for variations!
        $product_stock = ProductStock::firstOrNew(['product_id' => $this->product->id]);
        $product_stock->price = $this->product->unit_price;
        $product_stock->qty = $this->product->current_stock;
        $product_stock->save();
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
                $att = (object) $att;
                $att_values = $att->attribute_values;

                if($att_values) {
                    // Is-predefined attributes are dropdown/radio/checkbox and they have predefined values
                    // while other types have only one item in values array - with an ID (existing value) or without ID (not yet added value, just default template)
                    if(!$att->is_predefined) {
                        // Create the value first
                        $att_val = (!empty($att_values[0]['id'])) ? AttributeValue::find($att_values[0]['id']) : new AttributeValue();
                        $att_val->attribute_id = (!empty($att_values[0]['id'])) ? $att_val->attribute_id : $att->id;
                        $att_val->values = $att_values[0]['values'] ?? null;
                        $att_val->save();

                        if(empty($att_values[0]['id'])) {
                            $att_values[0]['id'] = $att_val->id;

                            // Set attribute value translations for non-predefined attributes
                            $attribute_value_translation = AttributeTranslation::firstOrNew(['lang' => config('app.locale'), 'attribute_value_id' => $att_val->id]);
                            $attribute_value_translation->name = $att_val->values;
                            $attribute_value_translation->save();
                        }
                    }

                    foreach($att_values as $att_value) {
                        $att_value = (object) $att_value;

                        if($att_value->selected ?? null) {
                            // Create or find product-attribute relationship, but don't yet persist anything to DB
                            $att_rel = AttributeRelationship::firstOrNew([
                                'subject_type' => 'App\Models\Product',
                                'subject_id' => $this->product->id,
                                'attribute_id' => $att->id,
                                'attribute_value_id' => $att_value->id
                            ]);
                            $att_rel->for_variations = $att->type === 'dropdown' ? $att->for_variations : false;
                            $att_rel->save();
                        } else {
                            // Remove attribute relationship if "selected" is false/null
                            AttributeRelationship::where([
                                'subject_type' => 'App\Models\Product',
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

    public function getVariationsAttributesProperty() {
        $atts_for_variations = collect($this->attributes)->filter(function($att, $key) {
            return ((object) $att)->for_variations === true;
        });

        return $atts_for_variations;
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
