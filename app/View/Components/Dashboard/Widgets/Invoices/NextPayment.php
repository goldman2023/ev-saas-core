<?php

namespace App\View\Components\Dashboard\Widgets\Invoices;

use Illuminate\View\Component;

class NextPayment extends Component
{
    public $plan_subscriptions;
    public $class;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($class = '')
    {
        $this->plan_subscriptions = auth()->user()->subscriptions;
        $this->class = $class;
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.widgets.invoices.next-payment');
    }
}
