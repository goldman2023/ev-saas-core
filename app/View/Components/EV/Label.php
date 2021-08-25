<?php

namespace App\View\Components\EV;

use Illuminate\View\Component;

class Label extends Component
{
    public $tag;
    public $label;
    public $some;
    public $class;
    public $id;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label = '', $class = '', $tag = 'div', $id = '')
    {
        $this->label = $label;
        $this->class = $class;
        $this->tag = $tag;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.e-v.label');
    }
}
