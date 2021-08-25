<?php

namespace App\View\Components\EV;

use Illuminate\View\Component;

class DynamicImage extends Component
{
    public $src;
    public $show_input_field = false;
    public $href;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($src, $href= "#")
    {
        //
        $this->src = $src;
        $this->href = $href;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.e-v.dynamic-image');
    }
}
