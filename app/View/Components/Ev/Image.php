<?php

namespace App\View\Components\Ev;

use Illuminate\View\Component;
use IMG;
// TODO: Check wtf is wrong with extending WeEditableComponent in resolving he component with app()!

// class Label extends WeEditableComponent
class Image extends Component
{
    public $src;
    public $href;
    public $target;
    public $altText;
    public $class;
    public $id;
    public $options;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($src = '', $class = '', $href = null, $target = '_self', $altText = '', $id = '', $options = [])
    {
        $this->src = $src;
        $this->class = $class;
        $this->href = $href;
        $this->target = $target;
        $this->altText = $altText;
        $this->options = $options;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ev.image');
    }

    // WeEdit Builder
    public function getEditableData() {
        return [
            'src' => $this->src,
            'class' => $this->class,
            'href' => $this->href,
            'target' => $this->target,
            'alt_text' => $this->altText,
            'options' => $this->options,
            'id' => $this->id,
        ];
    }

    public function setEditableData($data) {
        $this->src = $data['src'] ?? '';
        $this->class = $data['class'] ?? '';
        $this->href = $data['href'] ?? null;
        $this->target = $data['target'] ?? '_self';
        $this->altText = $data['alt_text'] ?? '';
        $this->options = !isset($data['options']) || empty($data['options'] ?? null) ? IMG::mergeWithDefaultOptions([], 'original') : $data['options'];
        $this->id = $data['id'] ?? '';
    }

    public function renderFieldComponent($slot_name, $component_name) {
        return view('components.we-edit.field-components.image', ['slot_name' => $slot_name, 'component_name' => $component_name, 'component_data' => $this->getEditableData()]);
    }
}
