<?php

namespace App\View\Components\Dashboard\EmptyStates;

use Illuminate\View\Component;

class NoItemsInCollection extends Component
{
    public $icon;

    public $title;

    public $text;

    public $linkHrefRoute;

    public $linkText;

    public $onClick;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($icon = null, $title = null, $text = null, $linkHrefRoute = null, $linkText = null, $onClick = '')
    {
        $this->icon = $icon;
        $this->title = $title;
        $this->text = $text;
        $this->linkHrefRoute = $linkHrefRoute;
        $this->linkText = $linkText;
        $this->onClick = $onClick;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.empty-states.no-items-in-collection');
    }
}
