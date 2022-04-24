<?php

namespace App\View\Components\Ev;

use App\Models\Models\EVLabel;
use Illuminate\View\Component;

// class ImageTitleText extends WeEditableComponent
class ImageTitleText extends Component
{
    public $image;

    public $imageAltText;

    public $title;

    public $titleTag;

    public $text;

    public $href;

    public $target;

    public $class;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($image = '', $imageAltText = '', $title = '', $titleTag = 'h4', $text = '', $href = '', $target = '_self', $class = '')
    {
        $this->image = $image;
        $this->imageAltText = $imageAltText;
        $this->title = $title;
        $this->titleTag = $titleTag;
        $this->text = $text;
        $this->target = $target;
        $this->href = $href;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ev.image-title-text');
    }

    // WeEdit Builder
    public static function getDefaultData()
    {
        return [
            'image' => '',
            'image_alt_text' => '',
            'title' => '',
            'title_tag' => 'h4',
            'text' => '',
            'href' => '',
            'target' => '_self',
            'class' => '',
        ];
    }

    public function getEditableData()
    {
        return [
            'image' => $this->image,
            'image_alt_text' => $this->imageAltText,
            'title' => $this->title,
            'title_tag' => $this->titleTag,
            'text' => $this->text,
            'href' => $this->href,
            'target' => $this->target,
            'class' => $this->class,
        ];
    }

    public function setEditableData($data)
    {
        $this->image = $data['image'] ?? '';
        $this->imageAltText = $data['image_alt_text'] ?? '';
        $this->title = $data['title'] ?? '';
        $this->titleTag = $data['title_tag'] ?? 'h4';
        $this->text = $data['text'] ?? '';
        $this->href = $data['href'] ?? '';
        $this->target = $data['target'] ?? '_self';
        $this->class = $data['class'] ?? '';
    }

    public function renderFieldComponent($slot_name, $component_name)
    {
        return view('components.we-edit.field-components.image-title-text', ['slot_name' => $slot_name, 'component_name' => $component_name, 'component_data' => $this->getEditableData()]);
    }
}
