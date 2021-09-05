<?php

namespace App\View\Components\EV\Form;

use Illuminate\View\Component;

class Wysiwyg extends Component
{
    public $class;
    public $name;
    public $label;
    public $required;
    public $placeholder;
    public $toolbar_items;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name = '', $label = '', $required = false,  $class = '', $placeholder = 'Type your description...', $toolbar_items = [])
    {
        $this->name = $name;
        $this->label = $label;
        $this->required = $required;
        $this->placeholder = $placeholder;
        $this->class = $class;
        $this->toolbar_items = array_merge(["bold", "italic", "underline", "strike", "link", "blockquote", "code", ["list"=> "bullet"]], $toolbar_items);
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ev.form.wysiwyg');
    }
}
