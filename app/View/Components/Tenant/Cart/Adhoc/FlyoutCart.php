<?php

namespace App\View\Components\Tenant\Cart\Adhoc;

use Illuminate\View\Component;

class FlyoutCart extends Component
{
    public string $class;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($class = '')
    {
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tenant.cart.adhoc.flyout-cart');
    }
}
