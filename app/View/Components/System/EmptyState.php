<?php

namespace App\View\Components\System;

use Illuminate\View\Component;

class EmptyState extends Component
{
    public $url;
    public $title;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($url = '/we/admin/menus', $title = 'Create new')
    {
        //
        $this->url = $url;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.system.empty-state');
    }
}
