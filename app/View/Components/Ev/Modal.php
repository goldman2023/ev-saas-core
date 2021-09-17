<?php

namespace App\View\Components\EV;

use Illuminate\View\Component;

class Modal extends Component
{
    public $class;
    public $btnclass;
    public $id;
    public $color;
    public $headerTitle;
    public $btntext;
    public $dialogclass;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($class = '', $btnclass = '', $id = '', $color = 'primary', $headerTitle = '', $btntext = '', $dialogclass = '')
    {
        $this->class = $class;
        $this->btnclass = $btnclass;
        $this->id = $id;
        $this->color = $color;
        $this->headerTitle = $headerTitle;
        $this->btntext = $btntext;
        $this->dialogclass = $dialogclass;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ev.modal');
    }
}
