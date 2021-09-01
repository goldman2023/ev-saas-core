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
    public $params;
    public $rulesSets;

    /*protected $rules = [
        'name' => 'required|min:6',
        'category_id' => 'required|exists:App\Models\Category,id',
        'brand_id' => 'nullable|exists:App\Models\Brand,id',
        'unit' => 'nullable|required', // TODO: make Units table or something like that
        'tags' => 'nullable|array',
    ];*/

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount()
    {
        // Define rules sets
        $this->rulesSets['general'] = [
            'name' => 'required|min:6',
            'category_id' => 'required|exists:App\Models\Category,id',
            'brand_id' => 'nullable|exists:App\Models\Brand,id',
            'unit' => 'nullable|required', // TODO: make Units table or something like that
            'tags' => 'nullable|array',
        ];
    }

    public function validateSpecificSet($set, $params)
    {
        if($set) {
            $params = json_decode(base64_decode($params), true);
            $this->validate($this->rulesSets[$set]);

            // After validation, go to next step
            $this->dispatchBrowserEvent('next-step', $params);
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
