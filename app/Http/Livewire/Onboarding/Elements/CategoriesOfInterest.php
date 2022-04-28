<?php

namespace App\Http\Livewire\Onboarding\Elements;

use App\Models\Category;
use Livewire\Component;

class CategoriesOfInterest extends Component
{
    public $followed_categories_ids;

    public function mount()
    {
        $this->refreshFollowedCategories();
    }

    public function render()
    {
        return view('livewire.onboarding.elements.categories-of-interest');
    }

    public function followCategory($category_id)
    {
        if(in_array($category_id, $this->followed_categories_ids)) {
            // Unfollow
            auth()->user()->follows_categories()->detach($category_id);
        } else {
            // Follow
            auth()->user()->follows_categories()->syncWithoutDetaching([
                $category_id => [
                    'created_at' => time()
                ]
            ]);
        }

        $this->refreshFollowedCategories();
    }

    protected function refreshFollowedCategories() {
        $this->followed_categories_ids = auth()->user()->follows_categories()->select('categories.id')->get()->pluck('id')->toArray();
    }
}
