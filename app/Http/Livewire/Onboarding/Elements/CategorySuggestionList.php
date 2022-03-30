<?php

namespace App\Http\Livewire\Onboarding\Elements;

use App\Models\Category;
use Livewire\Component;

class CategorySuggestionList extends Component
{
    public $categories;
    public function mount()
    {
        $this->categories = Category::whereHas('products')->get();
    }
    public function render()
    {
        return view('livewire.onboarding.elements.category-suggestion-list');
    }

    public function saveCategories()
    {

        return redirect()->route('onboarding.step2');
    }
}
