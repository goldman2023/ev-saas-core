<?php

namespace App\View\Components\Dashboard\Widgets\Business;

use Illuminate\View\Component;

class QuickActions extends Component
{
    public $type;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type = 'default')
    {
        //
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.widgets.business.quick-actions');
    }
}
