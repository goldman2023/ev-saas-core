<?php

namespace App\View\Components\Dashboard\Form\Blocks;

use App\Models\Shop;
use Illuminate\View\Component;

class MultipleItemsSubscriptionForm extends Component
{
    public $plans;
    public $previous_subscription;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($shop = null)
    {
        if(empty($shop) || !($shop instanceof Shop)) {
            $shop = Shop::find(1); // App subscription plans
        }

        $this->plans = $shop->plans->where('non_standard', false);
        $this->previous_subscription = auth()->user()->subscriptions()->active()->whereHas('order', function ($query) use ($shop) {
            $query->where('shop_id', $shop->id);
        })->first();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.form.blocks.multiple-items-subscription-form');
    }
}
