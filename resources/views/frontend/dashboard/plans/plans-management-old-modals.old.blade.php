@if((auth()->user()?->isSubscribed() ?? false) &&
        auth()->user()?->subscriptions->first()->items->count() === 1 &&
        auth()->user()?->subscriptions->first()->items->first()->pivot->qty === 1)
        <x-system.form-modal id="change-plan-modal" title="{{ translate('Change plan') }}" class="!max-w-7xl" title-class="text-20 font-semibold">
            <div class="w-full py-3">
                <x-dashboard.widgets.customer.pricing-table :plans="$plans" :hide-title="true">
                </x-dashboard.widgets.customer.pricing-table>
            </div>
        </x-system.form-modal>

        @php
            $current_plan = auth()->user()?->subscriptions->first()->items->first();
        @endphp
        <x-system.form-modal id="change-plan-confirmation-modal" title="{{ translate('Are you sure you want to change plan?') }}" class="!max-w-2xl" title-class="text-20 font-semibold">
            <div class="w-full" x-data="{
                in_process: false,
                subscription_id: null,
                new_plan: null,
                interval: null,
                trial: @js(auth()->user()?->subscriptions->first()->isTrial()),
                trial_ends_at: '{{ auth()->user()?->subscriptions->first()->end_date->format('d M, Y') }}',
                current_plan: @js($current_plan->toArray()),
                total_projected_price: '',
                total_annual_projected_price: '',
                getProjectedUpcomingInvoice() {
                    let invoiceProjectionUrl =  ('{{ route('api.dashboard.subscription.upcoming.invoice.stripe', ['subscription_id' => '%subscription_id%', 'new_plan_id' => '%new_plan_id%', 'interval' => '%interval%']) }}')
                            .replace('%subscription_id%', this.subscription_id)
                            .replace('%new_plan_id%', this.new_plan.id)
                            .replace('%interval%', this.interval);

                    this.total_projected_price = '({{ translate('calculating') }}...)';
                    this.total_annual_projected_price = '({{ translate('calculating') }}...)';

                    wetch.get(invoiceProjectionUrl)
                    .then(data => {
                        if(data.status === 'success') {
                            this.total_projected_price = FX.formatPrice(data.data.total / 100, 2);
                            this.total_annual_projected_price = FX.formatPrice(data.data.total / 100, 2);