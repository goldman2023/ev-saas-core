<?php

namespace WeThemes\WeBaltic\App\View\Components\Dashboard\Elements;

use App\Models\User;
use Illuminate\View\Component;

class CustomerQuickActions extends Component
{
    public $user;
    public $class;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($user = null, $class = '')
    {
        $this->user = auth()->user();
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.elements.customer-quick-actions');

    }
}
