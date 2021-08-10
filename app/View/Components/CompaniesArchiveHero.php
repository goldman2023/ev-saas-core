<?php

namespace App\View\Components;

use App\Models\Category;
use Illuminate\View\Component;

class CompaniesArchiveHero extends Component
{

    public $categoryTitle;
    public $country;
    public $categoryId;
    public $category;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($categoryId = false, $categoryTitle = false, $country = false)
    {
        //
        $this->categoryId = $categoryId;
        $this->country = $country;
        $this->category = Category::find($categoryId);

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.companies-archive-hero');
    }
}
