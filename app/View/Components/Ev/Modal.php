<?php

namespace App\View\Components\EV;

use Illuminate\View\Component;

class Modal extends Component
{
    public $class;
    public $btnClass;
    public $id;
    public $color;
    public $headerTitle;
    public $btnText;
    public $dialogClass;
    public $bodyClass;
    public $wireTarget;
    public $hasTrigger;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($class = '', $btnClass = '', $btnText = '', $id = '', $color = 'primary', $headerTitle = '',  $dialogClass = '', $bodyClass = '', $wireTarget = null, $hasTrigger = true)
    {
        $this->class = $class;
        $this->btnClass = $btnClass;
        $this->id = $id;
        $this->color = $color;
        $this->headerTitle = $headerTitle;
        $this->btnText = $btnText;
        $this->dialogClass = $dialogClass;
        $this->bodyClass = $bodyClass;
        $this->wireTarget = $wireTarget;
        $this->hasTrigger = $hasTrigger;
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
