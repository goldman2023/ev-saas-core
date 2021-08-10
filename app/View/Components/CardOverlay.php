<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CardOverlay extends Component
{
    public $text = 'Information about this company is incomplete';
    public $extraButtonsEnabled = true;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($text = 'Information about this company is incomplete', $extraButtonsEnabled = true)
    {
        //
        $this->text = $text;
        $this->extraButtonsEnabled = $extraButtonsEnabled;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.card-overlay');
    }
}
