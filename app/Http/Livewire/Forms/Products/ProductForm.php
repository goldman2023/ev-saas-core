<?php

namespace App\Http\Livewire\Forms\Products;

use App\Models\Product;
use Livewire\Component;

class ProductForm extends Component
{
    public $name;
    public $category_id;
    public $brand_id;
    public $unit;
    public $tags;

    protected $rules = [
        'name' => 'required|min:6',
        'category_id' => 'required|exists:App\Models\Category,id',
        'brand_id' => 'nullable|exists:App\Models\Brand,id',
        'unit' => 'nullable|required', // TODO: make Units table or something like that
        'tags' => 'nullable|array',
    ];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount()
    {

    }

    public function validateSpecific($properties)
    {
        if($properties) {
            foreach($properties as $prop) {
                $this->validateOnly($prop);
            }
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
