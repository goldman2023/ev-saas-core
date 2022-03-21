<?php

namespace App\View\Components\Dashboard\Form;

use Illuminate\View\Component;

class ImageSelector extends Component
{
    public $field;
    public $id;
    public ?Upload $selectedImage;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($field = '', $id = '', $selectedImage = null)
    {
        $this->field = $field;
        $this->id = $id;
        $this->selectedImage = $selectedImage;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.form.image-selector');
    }
}
