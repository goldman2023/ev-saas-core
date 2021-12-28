<?php

namespace App\Http\Livewire\Tenant\Product;

use App\Models\Product;
use App\Models\ProductVariation;
use Livewire\Component;
use App\Facades\CartService;
use Session;

class Price extends Component {

    public mixed $model;
    public $totalPriceClass = '';
    public $originalPriceClass = '';
    public $withLabel = false;
    public $wrapperClass = '';
    public $withDiscountLabel = false;

    protected $listeners = ['changeVariation'];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($model = null, $wrapperClass = '', $withDiscountLabel = false, $totalPriceClass = 'h2 fw-700 text-primary', $originalPriceClass = 'h3 fw-600 opacity-50 mr-1', $withLabel = false)
    {
        $this->model = $model;
        $this->wrapperClass = $wrapperClass;
        $this->withLabel = $withLabel;
        $this->totalPriceClass = $totalPriceClass;
        $this->originalPriceClass = $originalPriceClass;
        $this->withDiscountLabel = $withDiscountLabel;
    }

//    public function changeVariation(ProductVariation $variation) {
//        $this->model = $variation;
//    }

    public function render() {
        return view('livewire.tenant.product.price');
    }
}
