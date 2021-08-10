<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CompanyCategoriesManagement extends Component
{

    public $categories;
    public $user;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($categories, $user)
    {
        //
        $this->categories = $categories;
        $this->user = $user;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.company-categories-management');
    }
}
