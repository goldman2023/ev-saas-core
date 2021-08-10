<?php

namespace App\View\Components;

use Illuminate\View\Component;

class EventCard extends Component
{
    public $event;
    public $items;
    public $new = false;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($event, $items, $new = false)
    {
        $this->event = $event;
        $this->items = $items;
        $this->new = $new;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.event-card');
    }
}
