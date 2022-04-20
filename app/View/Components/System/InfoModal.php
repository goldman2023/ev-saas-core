<?php

namespace App\View\Components\System;

use Illuminate\View\Component;

class InfoModal extends Component
{
    public $class;

    public $title;

    public $text;

    public $type; // success, warning, info, fail

    public $timeout;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($class = '', $title = '', $text = '', $type = 'success', $timeout = 3000)
    {
        $this->class = $class;
        $this->title = $title;
        $this->text = $text;
        $this->type = $type;
        $this->timeout = $timeout;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tailwind-ui.system.info-modal');
    }
}
