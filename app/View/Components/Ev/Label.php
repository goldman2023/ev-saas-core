<?php

namespace App\View\Components\Ev;

use Illuminate\View\Component;
// TODO: Check wtf is wrong with extending WeEditableComponent in resolving he component with app()!

// class Label extends WeEditableComponent
class Label extends Component
{
    public $tag = 'div';
    public $label;
    public $class;
    public $id;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label = '', $class = '', $tag = 'span', $id = '')
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
        return view('components.ev.label');
    }

    // WeEdit Builder
    public function getEditableData() {
        return [
            'label' => $this->label,
            'class' => $this->class,
            'tag' => $this->tag,
            'id' => $this->id,
        ];
    }

    public function setEditableData($data) {
        $this->label = $data['label'] ?? '';
        $this->class = $data['class'] ?? '';
        $this->tag = $data['tag'] ?? 'span';
        $this->id = $data['id'] ?? '';
    }

    public function renderFieldComponent($slot_name, $component_name) {
        return view('components.we-edit.field-components.label', ['slot_name' => $slot_name, 'component_name' => $component_name, 'component_data' => $this->getEditableData()]);
    }
}
