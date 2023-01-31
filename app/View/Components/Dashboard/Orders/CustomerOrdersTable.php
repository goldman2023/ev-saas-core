<?php

namespace App\View\Components\Dashboard\Orders;

use Illuminate\View\Component;
use App\Models\User;

class CustomerOrdersTable extends Component
{
    public $user;
    public $orders;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($user = null)
    {
        $this->orders = collect();
        
        if($user == null) {
            $this->user = auth()->user();
        } else {
            $this->user = $user;
        }

        if($this->user instanceof User) {
            $this->orders = $this->user->orders()->orderBy('created_at', 'DESC')->get();
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
