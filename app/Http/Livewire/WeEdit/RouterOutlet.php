<?php

namespace App\Http\Livewire\WeEdit;

use Livewire\Component;
use App\Enums\WeEditLayoutEnum;

class RouterOutlet extends Component
{
    public $selected_page;

    protected $listeners = [
        'changePageEvent' => 'changePage'
    ];

    public function mount($selected_page = null)
    {
       $this->selected_page = $selected_page;
    }

    public function render()
    {
        return view($this->selected_page);
    }

    public function changePage($template) {
        $this->selected_page = $template;
    }
}