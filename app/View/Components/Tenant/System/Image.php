<?php

namespace App\View\Components\Tenant\System;

use Illuminate\View\Component;

class Image extends Component
{
    public $image;

    public $dataSrcSet;

    public $fit;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($image, $fit = '', $dataSrcSet = null)
    {
        $this->image = is_numeric($image) ? uploaded_asset($image) : $image;
        $this->dataSrcSet = $dataSrcSet;
        $this->fit = $fit;
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
