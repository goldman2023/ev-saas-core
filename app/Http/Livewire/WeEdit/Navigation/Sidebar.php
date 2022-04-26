<?php

namespace App\Http\Livewire\WeEdit\Navigation;

use App\Enums\WeEditLayoutEnum;
use Livewire\Component;

class Sidebar extends Component
{
    public $menu;

    public function mount($menu)
    {
        $this->menu = $menu;
    }

    public function render()
    {
        return view('livewire.we-edit.navigation.sidebar');
    }

    public function changePage($container_slug)
    {
        $this->emit('changePageEvent', $container_slug);
    }
}
