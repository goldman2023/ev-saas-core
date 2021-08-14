<?php

namespace App\Http\Livewire;

use App\SubscriptionCancelation;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;

class SubscriptionPlan extends Component
{
    public $plan = '';
    public $success = '';
    public $error = '';

    protected $listeners = ['billingUpdated' => '$refresh'];

    public function mount()
    {
        $this->refreshPlan();
    }

    public function update()
    {
        $this->validate([
            'plan' => ['required', Rule::in(array_keys(config('saas.plans')))],
        ]);

        if (! tenant()->hasDefaultPaymentMethod()) {
            $this->error = 'No payment method set. Please add one below.';

            return;
        }

        if (tenant()->subscribed('default')) {
            tenant()->subscription('default')->swap($this->plan);

            $this->success = 'Plan updated.';
            $this->error = '';
        } else {
            $subscription = tenant()->newSubscription('default', $this->plan);

            /** @var Carbon $trial_end */
            $trial_end = tenant()->trial_ends_at;

            if (config('saas.trial_days') && $trial_end->isFuture()) {
                $subscription->trialUntil($trial_end);
            }

            $subscription->create(tenant()->defaultPaymentMethod()->asStripePaymentMethod());
            
            $this->success = 'Subscription created.';
            $this->error = '';
        }

        $this->emit('billingUpdated');
    }

    public function cancel($cancelationReason)
    {
        DB::transaction(function () use ($cancelationReason) {
            tenant()->subscription('default')->cancel();
    
            SubscriptionCancelation::create([
                'tenant_id' => tenant('id'),
                'reason' => $cancelationReason,
            ]);
        });

        $this->plan = '';

        $this->emit('billingUpdated');
    }

    public function resume()
    {
        tenant()->subscription('default')->resume();

        $this->refreshPlan();

        $this->emit('billingUpdated');
    }

    protected function refreshPlan()
    {
        if (tenant()->on_active_subscription) {
            $this->plan = tenant()->subscription('default')->stripe_plan;
        }
    }

    public function render()
    {
        return view('livewire.tenant.subscription-plan');
    }
}
