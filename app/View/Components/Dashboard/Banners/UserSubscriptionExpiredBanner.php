<?php

namespace App\View\Components\Dashboard\Banners;

use Illuminate\View\Component;

class UserSubscriptionExpiredBanner extends Component
{
    public $subscription;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.banners.user-subscription-expired-banner');
    }
}
