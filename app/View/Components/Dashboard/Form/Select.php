<?php

namespace App\View\Components\Dashboard\Form;

use Illuminate\View\Component;

class Select extends Component
{
    public $items; 
    public $selected;
    public $field;
    public $placeholder;
    public $nullable;
    public $search;
    public $selectorClass;
    public $multiple;
    public $hideError = false;
    public $class;
    public $xShowIf = '';
    public $xAppendToInit = '';

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($items = null, $multiple = false, $selected = null, $field = '', $placeholder = 'Please select', $nullable = true, $search = false, $selectorClass = '', $hideError = false, $class = '', $xShowIf = '', $xAppendToInit = '')
    {
        $this->items = empty($items) ? [] : $items;
        $this->multiple = $multiple;
        $this->selected = $selected;
        $this->field = $field;
        $this->placeholder = $placeholder;
        $this->nullable = $nullable;
        $this->search = $search;
        $this->selectorClass = $selectorClass;
        $this->hideError = $hideError;
        $this->class = $class;
        $this->xShowIf = $xShowIf;
        $this->xAppendToInit = $xAppendToInit;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.form.select');
    }
}
