<?php

namespace App\View\Components;

use Illuminate\View\Component;

class EVSearch extends Component
{
    public $header;
    public $title;
    public $description;
    public $footer;
    public $image;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($header, $title, $description, $footer, $image)
    {
        $this->header = $header;
        $this->title = $title;
        $this->description = $description;
        $this->footer = $footer;
        $this->image = $image;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.e-v-search');
    }
}
