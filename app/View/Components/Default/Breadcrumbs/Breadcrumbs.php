<?php

namespace App\View\Components\Default\Breadcrumbs;

use Illuminate\View\Component;
use Route;

class Breadcrumbs extends Component
{
    public $style = 'default';

    public $breadcrumbs;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($style = 'default')
    {
        //
        $this->style = $style;
        $this->breadcrumbs = \Diglactic\Breadcrumbs\Breadcrumbs::generate(Route::currentRouteName());
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.default.breadcrumbs.'.$this->style);
    }
}
