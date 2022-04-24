<?php

namespace App\View\Components\Ev;

use Illuminate\View\Component;
// TODO: Check wtf is wrong with extending WeEditableComponent in resolving he component with app()!

// class Label extends WeEditableComponent
class Wysiwyg extends Component
{
    public $class;
    public $id;
    public $content;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($class = '', $id = '', $content = '')
    {
        $this->class = $class;
        $this->id = $id;
        $this->content = $content;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ev.wysiwyg');
    }

    // WeEdit Builder
    public function getEditableData() {
        return [
            'class' => $this->class,
            'id' => $this->id,
            'content' => $this->content
        ];
    }

    public function setEditableData($data) {
        $this->class = $data['class'] ?? '';
        $this->id = $data['id'] ?? '';
        $this->content = $data['content'] ?? '';
    }

    public function renderFieldComponent($slot_name, $component_name) {
        return view('components.we-edit.field-components.wysiwyg', ['slot_name' => $slot_name, 'component_name' => $component_name, 'component_data' => $this->getEditableData()]);
    }
}
