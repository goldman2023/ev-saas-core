<?php

namespace App\Http\Livewire\WeEdit;

use Livewire\Component;
use App\Enums\WeEditLayoutEnum;

class RouterOutlet extends Component
{
    public $selected_container;
    public $we_menu;

    protected $listeners = [
        'changePageEvent' => 'changePage'
    ];

    public function mount($selected_container = null, $we_menu)
    {
       $this->selected_container = $selected_container;
       $this->we_menu = $we_menu;
    }

    public function render()
    {
        return view($this->selected_container['template'] ?? '');
    }

    public function changePage($container_slug) {
        $this->selected_container = collect($this->we_menu)->firstWhere('slug', $container_slug);
    }
}