<?php

namespace App\View\Components\Dashboard\Widgets\Customers;

use Illuminate\View\Component;

class StripeCustomerCard extends Component
{
    public $user;
    public $user_balance;
    public $stripe_customer_endpoint;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
        if ($user->getStripeCustomerId()) {
            $this->user_balance = abs(\StripeService::stripe()->customers->retrieve($user->getStripeCustomerId(), [])->balance / 100);
            $this->stripe_customer_endpoint = "https://dashboard.stripe.com/customers/" . $user->getStripeCustomerId() . "/";
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.widgets.customers.stripe-customer-card');
    }
}
