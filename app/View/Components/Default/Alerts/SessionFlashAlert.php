<?php

namespace App\View\Components\Default\Alerts;

use Illuminate\View\Component;

class SessionFlashAlert extends Component
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
        return view('components.default.alerts.session-flash-alert');
    }
}
