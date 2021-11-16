<?php

namespace App\View\Components\Default\Products\Single;

use App\Models\Attribute;
use App\Models\AttributeGroup;
use App\Models\Product;
use Illuminate\View\Component;

class ProductSpecificationTable extends Component
{
    public Product $product;
    public $product_grouped_attributes;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Product $product)
    {

        $this->product = $product;
        $this->product_grouped_attributes = $this->product->custom_attributes_grouped();

//        $attribute_groups = AttributeGroup::where('content_type', Product::class)->orderBy('id')->pluck('id')->toArray();
//        $group_ids[] = NULL;
//        $group_ids = array_merge($attribute_groups, $group_ids);
//        foreach($group_ids as $id) {
//            $sub_attributes = Attribute::where('group', $id)->where('content_type', Product::class)->get();
//            if ($id == NULL) {
//                $product_attributes[$id] = $sub_attributes;
//            }else {
//                $product_attributes[AttributeGroup::findOrFail($id)->name] = $sub_attributes;
//            }
//        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.default.products.single.product-specification-table');
    }
}
