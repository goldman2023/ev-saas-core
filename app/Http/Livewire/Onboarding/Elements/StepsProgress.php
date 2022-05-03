<?php

namespace App\Http\Livewire\Onboarding\Elements;

use Livewire\Component;

class StepsProgress extends Component
{
    public $current_step = 1;

    public $progress_percentage = 0;

    public $total_steps = 3;

    public $include_work_and_education = false;

    public function mount($current_step = 1)
    {
        $user_meta_fields_in_use = collect(get_tenant_setting('user_meta_fields_in_use'))->where('onboarding', true);

        if($user_meta_fields_in_use->has('education') || $user_meta_fields_in_use->has('work_experience')) {
            $this->include_work_and_education = true;
            $this->total_steps = 3;
        } else {
            $this->total_steps = 2;
        }

        $this->current_step = $current_step;
        $this->progress_percentage = $current_step / $this->total_steps * 100;
    }

    public function render()
    {
        return view('livewire.onboarding.elements.steps-progress');
    }
}
