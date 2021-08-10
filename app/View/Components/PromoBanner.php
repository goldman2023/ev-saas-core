<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PromoBanner extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $heading;
    public $buttonText;
    public $imageSource;
    public $body;

    public function __construct($heading, $body, $buttonText, $imageSource)
    {

        $this->heading = $heading;
        $this->buttonText = $buttonText;
        $this->imageSource = $imageSource;
        $this->body = $body;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {

        return view('components.promo-banner');
    }
}
