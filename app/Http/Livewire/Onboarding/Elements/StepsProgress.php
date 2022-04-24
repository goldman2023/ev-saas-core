<?php

namespace App\Http\Livewire\Onboarding\Elements;

use Livewire\Component;

class StepsProgress extends Component
{
    public $current_step = 1;

    public $progress_percentage = 0;

    public $total_steps = 4;

    public function mount($current_step = 1)
    {
        $this->current_step = $current_step;
        $this->progress_percentage = $current_step / $this->total_steps * 100;
    }

    public function render()
    {
        return view('livewire.onboarding.elements.steps-progress');
    }
}
