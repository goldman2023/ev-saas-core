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

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($items = null, $selected = null, $field = '', $placeholder = 'Please select', $nullable = true)
    {
        $this->items = empty($items) ? [] : $items;
        $this->selected = $selected;
        $this->field = $field;
        $this->placeholder = $placeholder;
        $this->nullable = $nullable;
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
