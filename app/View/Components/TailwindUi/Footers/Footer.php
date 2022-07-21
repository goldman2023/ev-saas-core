<?php

namespace App\View\Components\TailwindUi\Footers;

use App\View\Components\TailwindUi\WeComponent;
use Illuminate\View\Component;

class Footer extends WeComponent
{
    public $template;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($template = 'footer_01')
    {
        if(get_tenant_setting('footer_style')) {

            /* Check if view exits */
            if(view()->exists('components.tailwind-ui.footers.'.$template)) {
                $this->template = get_tenant_setting('footer_style');
            } else {
                $this->template = 'footer_01';
            }
        } else {
            $this->template = $template;

        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tailwind-ui.footers.'.$this->template);
    }
}
