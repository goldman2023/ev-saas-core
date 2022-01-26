<?php

namespace App\View\Components\Default\Global;

use Illuminate\View\Component;

class FlyoutPanel extends Component
{
    public $id;
    public $title;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id = 'flyout_panel', $title = 'Flyout panel')
    {
        $this->id = $id;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.default.global.flyout-panel');
    }
}
