<?php

namespace App\View\Components\Tenant\Product\Reviews;

use Illuminate\View\Component;

class WithSummaryChart extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tenant.product.reviews.with-summary-chart');
    }
}
