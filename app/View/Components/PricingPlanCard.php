<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PricingPlanCard extends Component
{
    public $plan;
    public $key;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($plan, $key)
    {
        //
        $this->key = $key;
        $this->plan = $plan;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.pricing-plan-card');
    }
}
