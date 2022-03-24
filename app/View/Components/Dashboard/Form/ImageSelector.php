<?php

namespace App\View\Components\Dashboard\Form;

use Illuminate\View\Component;
use App\Models\Upload;

class ImageSelector extends Component
{
    public $field;
    public $errorField;
    public $id;
    public mixed $selectedImage;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($field = '', $id = '', $selectedImage = null, $errorField = '')
    {
        $this->field = $field;
        $this->errorField = $errorField;
        $this->id = $id;

        if($selectedImage instanceof Upload) { // Upload class
            $this->selectedImage = $selectedImage;
        } else if(is_numeric($selectedImage)) { // id of Upload
            $this->selectedImage = Upload::find($selectedImage);
        } else if(is_array($selectedImage) && isset($selectedImage['id'])) { // array with id property
            $this->selectedImage = Upload::find($selectedImage['id']);
        } else if(is_object($selectedImage) && isset($selectedImage->id)) { // object with id property
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
        return view('components.dashboard.form.image-selector');
    }
}
