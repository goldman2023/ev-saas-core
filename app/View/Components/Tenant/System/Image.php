<?php

namespace App\View\Components\Tenant\System;

use Illuminate\View\Component;

class Image extends Component
{

    public int $image;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(int $image)
    {
        //
        $this->image = $image;
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
