<?php

namespace App\View\Components\System;

use Illuminate\View\Component;

class Alert extends Component
{
    public $title;
    public $text;
    public $onlyText = false;
    public $type;
    public $buttons;
    public $hasClose = false;
    public $class;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title = '', $text = '', $onlyText = false, $class = 'mt-2', $type = 'info', $buttons = [], $hasClose = false)
    {
        $this->title = $title;
        $this->text = $text;
        $this->onlyText = $onlyText;
        $this->buttons = $buttons;
        $this->hasClose = $hasClose;
        $this->class = $class;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tailwind-ui.system.alert');
    }
}
