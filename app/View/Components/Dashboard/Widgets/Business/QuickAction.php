<?php

namespace App\View\Components\Dashboard\Widgets\Business;

use Illuminate\View\Component;

class QuickAction extends Component
{
    public $title, $route, $icon, $description;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title = 'Orders', $route = 'orders.index', $icon = 'home', $description = 'Manage all')
    {
        //
        $this->title = $title;
        $this->route = $route;
        $this->icon = $icon;
        $this->description = $description;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.widgets.business.quick-action');
    }
}
