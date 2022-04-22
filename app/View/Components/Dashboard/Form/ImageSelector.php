<?php

namespace App\View\Components\Dashboard\Form;

use App\Models\Upload;
use Illuminate\View\Component;

class ImageSelector extends Component
{
    public $field;

    public $errorField;

    public $id;

    public mixed $selectedImage;

    public $template;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($field = '', $id = '', $template = 'image', $selectedImage = null, $errorField = '')
    {
        $this->field = $field;
        $this->errorField = $errorField;
        $this->id = $id;
        $this->template = $template;

        if ($selectedImage instanceof Upload) { // Upload class
            $this->selectedImage = $selectedImage;
        } elseif (is_numeric($selectedImage)) { // id of Upload
            $this->selectedImage = Upload::find($selectedImage);
        } elseif (is_array($selectedImage) && isset($selectedImage['id'])) { // array with id property
            $this->selectedImage = Upload::find($selectedImage['id']);
        } elseif (is_object($selectedImage) && isset($selectedImage->id)) { // object with id property
            $this->selectedImage = Upload::find($selectedImage->id);
        } else {
            $this->selectedImage = $selectedImage;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        if ($this->template === 'cover') {
            return view('components.dashboard.form.cover-selector');
        } elseif ($this->template === 'avatar') {
            return view('components.dashboard.form.avatar-selector');
        }

        return view('components.dashboard.form.image-selector');
    }
}
