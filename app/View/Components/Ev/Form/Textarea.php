<?php

namespace App\View\Components\EV\Form;

use Illuminate\View\Component;

class Textarea extends Component
{
    public $class;
    public $id;
    public $name;
    public $label;
    public $required;
    public $placeholder;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name = '', $label = '', $required = false,  $class = '', $id = null, $placeholder = 'Type your description...')
    {
        $this->name = $name;
        $this->label = $label;
        $this->required = $required;
        $this->placeholder = $placeholder;
        $this->class = $class;
        $this->id = $id;
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ev.form.textarea');
    }
}
