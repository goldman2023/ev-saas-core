<?php

namespace App\View\Components\Dashboard\Form;

use Illuminate\View\Component;

class TextRepeater extends Component
{
    public $placeholder;

    public $field;

    public $limit;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($placeholder = null, $field = '', $limit = 999)
    {
        $this->items = empty($items) ? [] : $items;
        $this->placeholder = $placeholder;
        $this->field = $field;
        $this->limit = empty($limit) || $limit < 1 ? 999 : ceil($limit);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.form.text-repeater');
    }
}
