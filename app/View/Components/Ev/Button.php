<?php

namespace App\View\Components\EV;

use App\Models\Models\EVLabel;
use Illuminate\View\Component;

class Button extends Component
{
    public $class;
    public $onclick;
    public $wireclick;
    public $type;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($class = 'btn btn-primary', $onclick = null, $wireclick = null, $type = 'button')
    {
        $this->class = $class;
        $this->onclick = $onclick;
        $this->wireclick = $wireclick;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ev.button');
    }
}
