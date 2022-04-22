<?php

namespace App\View\Components\Default\Dashboard\Widgets;

use Illuminate\View\Component;

class IntegrationsWidget extends Component
{
    public $integrations = [];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        $this->integrations = [
            'facebook',
            'woocommerce',
            'google',
        ];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.default.dashboard.widgets.integrations-widget');
    }
}
