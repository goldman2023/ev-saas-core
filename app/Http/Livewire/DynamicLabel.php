<?php

namespace App\Http\Livewire;

use App\Models\Models\EVLabel;
use Livewire\Component;
use Illuminate\Support\Facades\Route;


class DynamicLabel extends Component
{
    public $my_data;

    public function mount($my_data = '')
    {
        $this->my_data = $my_data;
    }

    public function render()
    {

        return view('livewire.dynamic-label');
    }
}
