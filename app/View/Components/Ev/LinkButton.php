<?php

namespace App\View\Components\Ev;

use App\Models\Models\EVLabel;
use Illuminate\View\Component;

// class LinkButton extends WeEditableComponent
class LinkButton extends Component
{
    public mixed $label;
    public $href;
    public $target;
    public $type; // Avaialbe types are: button, link
    public $class;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(mixed $label, $href = '#', $type = 'link', $target = '_self', $class = '')
    {
        $this->label = $label;
        $this->target = $target;
        $this->href = $href;
        $this->type = $type;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ev.link-button');
    }

    // WeEdit Builder
    public static function getDefaultData() {
        return [
            'label' => 'Link',
            'class' => '',
            'type' => 'link',
            'href' => '#',
            'target' => '_self',
        ];
    }

    public function getEditableData() {
        return [
            'label' => $this->label,
            'class' => $this->class,
            'type' => $this->type,
            'href' => $this->href,
            'target' => $this->target,
        ];
    }

    public function setEditableData($data) {
        $this->label = $data['label'] ?? '';
        $this->class = $data['class'] ?? '';
        $this->type = $data['type'] ?? 'link';
        $this->href = $data['href'] ?? '#';
        $this->target = $data['target'] ?? '_self';
    }

    public function renderFieldComponent($slot_name, $component_name) {
        return view('components.we-edit.field-components.link-button', ['slot_name' => $slot_name, 'component_name' => $component_name, 'component_data' => $this->getEditableData()]);
    }
}
