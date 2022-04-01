<?php

namespace App\View\Components\System;

use Illuminate\View\Component;

class SocialLoginButtons extends Component
{
    public $enabled;
    public $fb_enabled;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->enabled = get_setting('enable_social_logins');
        $this->fb_enabled = get_setting('facebook_login');
        $this->google_enabled = get_setting('google_login');
        $this->linkedin_enabled = get_setting('linkedin_login');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tailwind-ui.system.invalid-icon');
    }
}
