<?php

namespace App\Http\Livewire\WeEdit\Navigation;

use Livewire\Component;

class Sidebar extends Component
{
    public $we_menu;

    public function mount()
    {
        $this->we_menu = [
            [
                'title' => translate('Pages'),
                'icon' => 'heroicon-o-document'
            ],
            [
                'title' => translate('Menus'),
                'icon' => 'heroicon-o-menu'
            ],
            [
                'title' => translate('Templates'),
                'icon' => 'heroicon-o-archive'
            ],
            [
                'title' => translate('Site structure'),
                'icon' => 'heroicon-o-globe-alt'
            ]
        ];
    }

    public function render()
    {
        return view('livewire.we-edit.navigation.sidebar');
    }
}