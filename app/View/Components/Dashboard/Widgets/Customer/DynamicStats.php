<?php

namespace App\View\Components\Dashboard\Widgets\Customer;

use Illuminate\View\Component;

class DynamicStats extends Component
{
    public $user_subscription = null;
    public $order = null;
    public $invoices = null;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->user_subscription = auth()->user()->plan_subscriptions->load(['order', 'order.invoices' => function($query) {
            $query->withoutGlobalScopes();
        }])->first(); // TODO: For now we are using just first subscrption, but what i there are more subs????
        $this->order = $this->user_subscription->order;
        $this->invoices = $this->order->invoices;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.widgets.customer.dynamic-stats');
    }
}
