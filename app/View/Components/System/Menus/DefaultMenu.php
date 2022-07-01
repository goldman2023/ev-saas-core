<?php

namespace App\View\Components\System\Menus;

use Illuminate\View\Component;

class DefaultMenu extends Component
{
    public $header_menu_items;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($menu_slug = 'header')
    {
        $header_menu = nova_get_menu_by_slug($menu_slug);
        $header_menu_items = $header_menu['menuItems'] ?? null;
        //
        if($header_menu_items) {
            $this->header_menu_items = $header_menu_items;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.system.menus.default-menu');
    }
}
