<?php

namespace App\View\Components\dashboard\Widgets\Customer;

use App\Models\Plan;
use Illuminate\View\Component;

class PricingTable extends Component
{
    public $plans;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($plans = null)
    {
        if($plans) {
            $this->plans = $plans;
        } else {

            $this->plans = Plan::published()->withoutGlobalScopes()->get();
        }


    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.widgets.customer.pricing-table');
    }
}
