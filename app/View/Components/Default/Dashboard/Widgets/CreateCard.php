<?php

namespace App\View\Components\Default\Dashboard\Widgets;

use Illuminate\View\Component;

class CreateCard extends Component
{
    public $title;

    public $description;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    /* TODO: Find a better way to set a defaults, maybe we need to use slots of whatever */
    public function __construct($title = 'Create a product', $description = 'Create a standart physical product')
    {
        //
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.default.dashboard.widgets.create-card');
    }
}
