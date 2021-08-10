<?php

namespace App\View\Components;

use Illuminate\View\Component;

class EmptyStateCard extends Component
{
    public $title;
    public $text;
    public $routeOwner;
    public $route;
    public $ctaText;
    public $ctaTextOwner;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $text, $routeOwner, $route, $ctaText = 'Update Info', $ctaTextOwner = 'Update Info')
    {
        //
        $this->title = $title;
        $this->text = $text;
        $this->routeOwner = $routeOwner;
        $this->route = $route;
        $this->ctaText = $ctaText;
        $this->ctaTextOwner = $ctaTextOwner;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.empty-state-card');
    }
}
