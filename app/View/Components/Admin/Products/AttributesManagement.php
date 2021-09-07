<?php

namespace App\View\Components\Admin\Products;

use App\Models\Attribute;
use App\Models\Product;
use Illuminate\View\Component;

class AttributesManagement extends Component
{
    public $product_attributes;
    public $product;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($product)
    {
        $this->product = $product;
        if($product == null) {
            $this->product = new Product();
        }
        $this->product_attributes = Attribute::where('content_type', 'App\Models\Product')
        ->orderBy('created_at', 'desc')
        ->get();
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.products.attributes-management');
    }
}
