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
    public function __construct(EVLabel $label, $href = '#')
    {
        $this->label = $label;
        $this->href = $href;
        // $this->attributes->merge(['href' => $this->href]);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.e-v.link-button');
    }
}
