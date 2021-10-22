<?php

namespace App\View\Components\Default\Merchant;

use Illuminate\View\Component;

class Footer extends Component
{
    public $shop;
    public $logo;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($shop = null)
    {
        //
        $this->shop = $shop;
        $this->logo = $shop->get_company_logo();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.default.merchant.footer');
    }
}
