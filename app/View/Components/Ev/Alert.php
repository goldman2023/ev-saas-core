<?php

namespace App\View\Components\EV;

use Illuminate\View\Component;

class Alert extends Component
{
    public $class;
    public $id;
    public $type;
    public $title;
    public $content;
    public $footer;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($class = '', $id = '', $type = 'primary', $title = '', $content = '', $footer = '')
    {
        $this->class = $class;
        $this->id = $id;
        $this->type = $type;
        $this->title = $title;
        $this->content = $content;
        $this->footer = $footer;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ev.alert');
    }
}
