<?php

namespace App\View\Components\Feed\Elements;

use Illuminate\View\Component;

class UserOnboardingFlow extends Component
{

    public $steps = [];
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $step = [
            'completed' => true,
            'action' => 'Create',
            'route' => route('onboarding.step4'),
            'title' => translate('Create a shop'),
        ];
        $this->steps[] = $step;

        $step = [
            'completed' => true,
            'action' => 'Create',
            'route' => route('onboarding.verification'),
            'title' => translate('Verify your profile'),
        ];
        $this->steps[] = $step;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.feed.elements.user-onboarding-flow');
    }
}
