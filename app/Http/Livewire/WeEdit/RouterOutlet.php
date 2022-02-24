<?php

namespace App\Http\Livewire\WeEdit;

use Livewire\Component;
use App\Enums\WeEditLayoutEnum;

class RouterOutlet extends Component
{
    public $selected_container;

    protected $listeners = [
        'changePageEvent' => 'changePage'
    ];

    public function mount($selected_container = null)
    {
       $this->selected_container = $selected_container;
    }

    public function render()
    {
        return view($this->selected_container['template'] ?? '');
    }

    public function changePage($selected_container) {
        $this->selected_container = $selected_container;
    }
}