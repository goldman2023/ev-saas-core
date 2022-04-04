<?php

namespace App\View\Components;

use App\Models\Category;
use Illuminate\View\Component;

/**
 * @param Category[] $categories
 */
class CategoryList extends Component
{

    public $categories;
    public $options = [
        'type' => 'featured/latest/popular',
        'show_count' => false,
        'show_parent' => 0,
        'show_children' => 4,
        'show_description' => false,
        'show_image' => false,
    ]; // Options Featured / Latest / Popular


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($categories)
    {
        $this->categories = $categories;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.category-list');
    }
}
