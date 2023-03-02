<?php

namespace App\Http\Livewire\Tenant\Product;

use Session;
use Categories;
use AttributesService;
use App\Models\Product;
use Livewire\Component;
use App\Facades\CartService;
use Livewire\WithPagination;
use App\Models\ProductVariation;
use App\Support\Eloquent\Collection;

class ProductsArchive extends Component
{
    use WithPagination;
    
    public $shops;
    public $filterable_attributes;
    public $selected_attributes;
    public $query_params;
    public $category;
    public $cols;
    public $class;
    public $count_active_filters;

    protected $listeners = [''];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($category = null, $cols = 3, $class = '')
    {
        $this->class = $class;
        $this->cols = $cols;
        $this->category = $category;
        $this->filterable_attributes = AttributesService::getFilterableProductAttrbiutes();
        $this->query_params = request()->query();
        $this->count_active_filters = 0;
        
        $selected_product_attributes = AttributesService::castFilterableProductAttributesFromQueryParams($this->filterable_attributes, remove_inactive: true);
        $this->selected_attributes = $selected_product_attributes['selected_attributes'];
        $this->count_active_filters = $selected_product_attributes['count_active_filters'];

        // dd($this->selected_attributes);
    }

//    public function changeVariation(ProductVariation $variation) {
//        $this->model = $variation;
//    }

    public function render()
    {
        if(!empty($this->category)) {
            $products = $this->category
                ->products()
                ->whereCustomAttributes($this->selected_attributes)
                ->with(['shop'])
                ->withCount('activities')
                ->orderBy('activities_count', 'desc')
                ->published()
                ->where('unit_price' , '>', 0)
                ->orderBy('created_at', 'DESC')
                ->paginate(10);

            $shops = $this->category->shops()->orderBy('created_at', 'DESC')->paginate(10);
        } else {
            
            $products = Product::published()
                ->with(['shop'])
                ->whereCustomAttributes($this->selected_attributes)
                ->where('unit_price' , '>', 0)
                ->withCount('activities')
                ->orderBy('activities_count', 'desc')
                ->orderBy('created_at', 'DESC')
                ->paginate(10);
            // dd($products);
            $shops = new Collection();
        }

        return view('livewire.tenant.product.products-archive', [
            'products' => $products,
            'shops' => $shops,
        ]);
    }
}
