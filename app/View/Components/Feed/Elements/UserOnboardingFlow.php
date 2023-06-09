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
            'completed' => false,
            'action' => 'Explore',
            'route' => route('feed.shops'),
            'title' => translate('Follow 5 users'),
        ];
        if (auth()->user()->follows_users()->count() > 5) {
            $step['completed'] = true;
        }

        $this->steps[] = $step;

        $step = [
            'completed' => false,
            'action' => 'Start sharing',
            'route' => route('onboarding.verification'),
            'title' => translate('Add your first post'),
        ];

        if (auth()->user()->blog_posts()->count() > 1) {
            $step['completed'] = true;
        }

        $this->steps[] = $step;

        $step = [
            'completed' => true,
            'action' => 'Create',
            'route' => route('onboarding.step4'),
            'title' => translate('Create a shop'),
        ];
        if (auth()->user()->shop()->count() > 1) {
            $step['completed'] = true;
        }

        $this->steps[] = $step;

        $step = [
            'completed' => false,
            'action' => 'Get verified',
            'route' => route('onboarding.verification'),
            'title' => translate('Verify your profile'),
        ];

        if (auth()->user()->verified) {
            $step['completed'] = true;
        }

        $this->steps[] = $step;

        $step = [
            'completed' => false,
            'action' => 'Start selling',
            'route' => route('product.create'),
            'title' => translate('Add your first product'),
        ];

        if (auth()->user()->products()->count() > 1) {
            $step['completed'] = true;
        }

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
