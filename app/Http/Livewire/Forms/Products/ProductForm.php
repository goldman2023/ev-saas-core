<?php

namespace App\Http\Livewire\Forms\Products;

use App\Models\Attribute;
use App\Models\AttributeRelationship;
use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\Upload;
use App\Rules\AttributeValuesSelected;
use App\Rules\EVModelsExist;
use EV;
use Spatie\ValidationRules\Rules\ModelsExist;
use Livewire\Component;

class ProductForm extends Component
{
    protected $rulesSets;
    public $page;

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
            'product.purchase_price' => 'required|numeric',
            'product.discount' => 'required|numeric',
            'product.discount_type' => 'required|in:amount,percent',
            'product.stock_visibility_state' => 'required|in:quantity,text,hide',
            'product.shipping_type' => 'required|in:flat,product_wise,free',
            'product.flat_shipping_cost' => 'required_if:product.shipping_type,flat',
            'product.is_quantity_multiplied' => 'required|boolean',
            'product.set_shipping_days' => 'nullable|numeric'
        ];

        $this->rulesSets['attributes_variations'] = [
            'attributes.*' => [ new AttributeValuesSelected() ]
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
    public function mount($page = '')
    {
        $this->page = $page;
        $this->attributes = EV::getMappedAttributes('App\Models\Product');

        // Set default params
        $this->product = new Product();
        $this->product->slug = '';
        $this->product->is_quantity_multiplied = 1;
        $this->product->shipping_type = 'product_wise';
        $this->product->stock_visibility_state = 'quantity';
        $this->product->discount_type = 'amount';
        $this->product->discount = 0;
        $this->product->low_stock_quantity = 1;
        $this->product->min_qty = 1;
    }

    public function validateSpecificSet($set_name, $next_page)
    {
        if($set_name) {
            foreach($this->rulesSets as $key => $set) {
                $this->page = $key; // set page
                $this->validate($this->rulesSets[$set_name]); // validate page

                if($set_name == $key) {
                    break;
                }
            }

            $this->page = $next_page;
            // After validation, go to next step
            //$this->dispatchBrowserEvent('next-step', $params);
        }
    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('initProductForm');
    }

    public function render()
    {
        return view('livewire.forms.product-form');
    }
}
