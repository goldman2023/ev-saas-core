<?php

namespace App\Http\Livewire\Onboarding\Elements;

use Livewire\Component;

class Steps extends Component
{
    public $current_step = 1;

    public $steps = [
        'step1' => [
            'title' => 'Step 1',
            'description' => 'Select your interests',
            'icon' => '',
            'route' => 'onboarding.step1',
        ],
        'step2' => [
            'title' => 'Step 2',
            'description' => 'Profile setup',
            'icon' => '',
            'route' => 'onboarding.step2',
        ],
        'step3' => [
            'title' => 'Step 3',
            'description' => 'Shop setup',
            'icon' => '',
            'route' => 'onboarding.step3',
        ],
        'step4' => [
            'title' => 'Step 4',
            'description' => 'Thank you',
            'icon' => 'f',
            'route' => 'onboarding.step4',
        ],
    ];

    public function mount($current_step = 1)
    {
        $this->current_step = $current_step;
    }

    public function render()
    {
        return view('livewire.onboarding.elements.steps');
    }
}
