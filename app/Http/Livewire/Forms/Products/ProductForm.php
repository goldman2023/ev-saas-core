<?php

namespace App\Http\Livewire\Forms\Products;

use App\Models\Product;
use App\Models\Upload;
use Spatie\ValidationRules\Rules\ModelsExist;
use Livewire\Component;

class ProductForm extends Component
{
    public $rulesSets;
    public $page;

    public $name;
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
    public $set_shipping_days;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($page = '')
    {
        $this->page = $page;

        // Define rules sets
        $this->rulesSets['general'] = [
            'name' => 'required|min:6',
            'category_id' => 'required|exists:App\Models\Category,id',
            'brand_id' => 'nullable|exists:App\Models\Brand,id',
            'unit' => 'nullable|required', // TODO: make Units table or something like that
            'tags' => 'nullable|array',
        ];

        // Define rules sets
        $this->rulesSets['content'] = [
            'thumbnail_img' => 'required|exists:App\Models\Upload,id',
            'photos' => ['required','array'], //  new ModelsExist(Upload::class)
            'video_provider' => 'nullable|in:youtube,vimeo,dailymotion',
            'video_link' => 'nullable|active_url',
            'pdf' => 'nullable|exists:App\Models\Upload,id',
            'description' => 'required|min:20',
        ];

        $this->rulesSets['price_stock_shipping'] = [

        ];
    }

    public function validateSpecificSet($set_name, $next_page)
    {
        if($set_name) {
            foreach($this->rulesSets as $key => $set) {
                $this->page = $key; // set page
                $this->validate($set); // validate page
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
