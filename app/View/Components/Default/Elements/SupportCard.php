<?php

namespace App\View\Components\Default\Elements;

use App\Models\User;
use Illuminate\View\Component;

class SupportCard extends Component
{
    public $user;
    public $class;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($user = null, $class = '')
    {
        $this->class = $class;
        
        if ($user) {
            $this->user = $user;
        } else {
            $this->user = User::find(1);
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        if ($this->user->id === 1) {
            return view('components.default.elements.support-card');
        } else {
            return view('components.default.elements.user-card');
        }
    }
}
