<?php

namespace App\View\Components\Dashboard\Orders;

use Illuminate\View\Component;

class CustomerOrdersTable extends Component
{
    public $user;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($user = null)
    {
        //

        if($user == null) {
            $this->user = auth()->user();
        } else {
            $this->user = $user;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.orders.customer-orders-table');
    }
}
