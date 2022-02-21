<?php

namespace App\View\Components\Default\System;

use Illuminate\View\Component;

class ThemeSelectForm extends Component
{
    public $themes = [
        'ev-saas-default',
        'ev-boostrap-gun',
        'ev-saas-fox',
        'ev-saas-demo',
        'we-saas-boostrap-software',
        'we-commerce-boostrap'
    ];
    public $currentTheme;
    public $domain;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        $this->domain = tenant()->domains()->first();

        $this->currentTheme = $this->domain->theme;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.default.system.theme-select-form');
    }
}
