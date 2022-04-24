<?php

namespace App\View\Components\EV\Form;

use Illuminate\View\Component;

class Wysiwyg extends Component
{
    public $class;

    public $name;

    public $label;

    public $required;

    public $editor;

    public $placeholder;

    public $options;

    public $toolbar_items;

    public $errorBagName;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name = '', $label = '', $editor = 'toast-ui-editor', $required = false, $class = '', $placeholder = 'Type your description...', $options = [], $toolbar_items = [], $errorBagName = null)
    {
        $this->name = $name;
        $this->label = $label;
        $this->editor = $editor;
        $this->required = $required;
        $this->placeholder = $placeholder;
        $this->class = $class;
        $this->options = $options;
        $this->toolbar_items = array_merge(['bold', 'italic', 'underline', 'strike', 'link', 'blockquote', 'code', ['list'=> 'bullet']], $toolbar_items);
        $this->errorBagName = $errorBagName ?: $name;
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
