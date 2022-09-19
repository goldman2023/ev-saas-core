<?php

namespace App\View\Components\Default\System;

use Illuminate\View\Component;

class LanguageSwitcher extends Component
{
    /* TODO: Make this an app setting + Domains by language management */
    public $multiLanguageEnabled = true;
    public $languages = [
        "en" => ['domain' => 'domain.com'],
        "lt" => ['domain' => 'domain.lt'],
    ];

    /* TODO: Default language setting */
    /* TODO: Take current language based on domain/session */
    public $currentLanguage = 'en';
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
        return view('components.default.system.language-switcher');
    }
}
