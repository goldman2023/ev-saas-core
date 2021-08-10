<?php

namespace App\View\Components;

use Illuminate\View\Component;

class EventTabs extends Component
{
    public $event, $type;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($event, $type)
    {
        //
        $this->event = $event;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.event-tabs');
    }
}
