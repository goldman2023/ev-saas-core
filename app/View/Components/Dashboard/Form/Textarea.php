<?php

namespace App\View\Components\Dashboard\Form;

use Illuminate\View\Component;

class Textarea extends Component
{
    public $textareaId;
    public $field;
    public $text;
    public $placeholder;
    public $required;
    public $rows;
    public $class;
    public $textareaClass;
    public $disabled;
    public $errorField;
    public $x;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $textareaId = null,
        $field = '', 
        $errorField = '', 
        $required = false, 
        $rows = 0, 
        $x = false, 
        $class = '', 
        $textareaClass = '', 
        $disabled = false, 
        $text = null,
        $placeholder = ''
    )
    {
        $this->textareaId = $textareaId;
        $this->field = $field;
        $this->textareaClass = 'form-standard '.$textareaClass;
        $this->text = $text;
        $this->placeholder = $placeholder;
        $this->disabled = $disabled;
        $this->required = $required;
        $this->rows = $rows;
        $this->x = $x;
        $this->class = $class;
        $this->errorField = $errorField !== $this->field ? $errorField : $this->field;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.form.textarea');
    }
}
