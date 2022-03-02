<?php

namespace App\View\Components\WeEdit\Flyout;

use Illuminate\View\Component;

class FlyoutEditSection extends FlyoutPanel
{
    public $currentPreview;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($currentPreview)
    {
        $this->currentPreview = $currentPreview;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.we-edit.flyout.flyout-edit-section');
    }
}
