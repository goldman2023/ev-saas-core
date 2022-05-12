<?php

namespace App\View\Components\Feed\Elements\Users;

use Illuminate\View\Component;

class WorkExperience extends Component
{
    public $user;
    public $class;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($user, $class = '')
    {
        $this->user = $user;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.feed.elements.users.work-experience');
    }
}
