<?php

namespace App\View\Components\EV\Form;

use Illuminate\View\Component;

class Toggle extends Component
{
    public $class;

    public $classLabel;

    public $id;

    public $name;

    public $prependText;

    public $appendText;

    public $options;

    public $selected;

    public $errorBagName;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name = '', $id = null, $prependText = null, $appendText = null, $options = [], $selected = false, $class = '', $classLabel = '', $errorBagName = null)
    {
        $this->name = $name;
        $this->class = $class;
        $this->classLabel = $classLabel;
        $this->id = $id;
        $this->selected = $selected;
        $this->prependText = $prependText;
        $this->appendText = $appendText;
        $this->options = $options;
        $this->errorBagName = $errorBagName;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ev.form.toggle');
    }
}
