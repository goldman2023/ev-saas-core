<?php

namespace App\View\Components\Tenant\System;

use Illuminate\View\Component;

class Image extends Component
{

    public $image;
    public $dataSrcSet;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($image, $dataSrcSet= null)
    {
        //

        $this->image = $image;
        $this->dataSrcSet = $dataSrcSet;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tenant.system.image');
    }
}
