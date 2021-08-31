<?php

namespace App\View\Components\Default\Modals;

use Illuminate\View\Component;

class SignUpModal extends Component
{
    public $style = 'default';
    public $id;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($style = 'default', $id = 'signupModal')
    {
        //
        $this->style = $style;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.default.modals.' . $this->style);
    }
}
