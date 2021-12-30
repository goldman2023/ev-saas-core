<?php

namespace App\View\Components\EV;

use Illuminate\View\Component;

class Toast extends Component
{
    public $class;
    public $titleClass;
    public $contentClass;
    public $id;
    public $type;
    public $title;
    public $icon;
    public $content;
    public $close;
    public $position;
    public $isX;
    public $timeout;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($isX = false, $timeout = 4000, $class = '', $titleClass = '', $contentClass = '', $id = '', $type = 'primary', $icon = '', $title = '', $content = '', $close = false, $position = 'bottom-center')
    {
        $this->isX = $isX;
        $this->timeout = (int) $timeout;
        $this->class = $class;
        $this->titleClass = $titleClass;
        $this->contentClass = $contentClass;
        $this->id = $id;
        $this->type = $type;
        $this->icon = $icon;
        $this->title = $title;
        $this->content = $content;
        $this->close = $close;
        $this->position = $position;
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
