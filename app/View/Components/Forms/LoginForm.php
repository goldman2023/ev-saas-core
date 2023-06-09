<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class LoginForm extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        if (session('style_framework') === 'tailwind') {
            return view('components.tailwind-ui.forms.login-form');
        }

        return view('components.bootstrap.forms.login-form');
    }
}
