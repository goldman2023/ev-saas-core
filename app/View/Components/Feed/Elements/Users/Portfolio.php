<?php

namespace App\View\Components\Feed\Elements\Users;

use Illuminate\View\Component;

class Portfolio extends Component
{
    public $user;
    public $class;
    public $portfolio;
    public $perPage = 4;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($user, $class = '')
    {
        $this->user = $user;
        $this->class = $class;
        $this->portfolio = $user->portfolio()->published()->latest()->take($this->perPage)->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.feed.elements.users.portfolio');
    }
}
