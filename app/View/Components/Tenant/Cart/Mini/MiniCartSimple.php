<?php

namespace App\View\Components\Tenant\Cart\Mini;

use Illuminate\View\Component;

class MiniCartSimple extends Component
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
        return view('components.tenant.cart.mini.mini-cart-simple');
    }
}
