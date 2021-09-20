<?php

namespace App\View\Components\EV;

use Illuminate\View\Component;

class Toast extends Component
{
    public $class;
    public $contentClass;
    public $id;
    public $type;
    public $title;
    public $icon;
    public $content;
    public $close;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($class = '', $contentClass = '', $id = '', $type = 'primary', $icon = '', $title = '', $content = '', $close = false)
    {
        $this->class = $class;
        $this->contentClass = $contentClass;
        $this->id = $id;
        $this->type = $type;
        $this->icon = $icon;
        $this->title = $title;
        $this->content = $content;
        $this->close = $close;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ev.toast');
    }
}
