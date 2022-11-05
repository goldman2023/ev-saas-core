<?php

namespace App\View\Components\Dashboard\Widgets\Invoices;

use Illuminate\View\Component;

class UserBalance extends Component
{
    public $user;
    public $user_balance;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($user = null)
    {
        //
        if($user) {
            $this->user = $user;
        } else {
            $this->user = auth()->user();
        }
        if(\Payments::isStripeEnabled()) {
            $this->user_balance = (\StripeService::stripe()->customers->retrieve($this->user->getStripeCustomerId(), [] )->balance / 100) * -1;
        } else {
            $this->user_balance = 0;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.widgets.invoices.user-balance');
    }
}
