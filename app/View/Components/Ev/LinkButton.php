<?php

namespace App\View\Components\EV;

use App\Models\Models\EVLabel;
use Illuminate\View\Component;

class LinkButton extends Component
{
    public EVLabel $label;
    public $href;
    public $target;
    public $type; // Avaialbe types are: button, link


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(EVLabel $label, $href = '#', $type = 'link', $target = '_self')
    {
        $this->label = $label;
        $this->target = $target;
        $this->href = $href;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ev.link-button');
    }
}
