<?php

namespace App\View\Components\System;

use Illuminate\View\Component;

class FormModal extends Component
{
    public $class;
    public $title;
    public $id;
    public $preventClose;
    public $titleClass;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id= '', $class = '', $title = '', $preventClose = false, $titleClass = '')
    {
        $this->class = $class;
        $this->title = $title;
        $this->id = $id;
        $this->preventClose = $preventClose;
        $this->titleClass = $titleClass;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tailwind-ui.system.form-modal');
    }
}
