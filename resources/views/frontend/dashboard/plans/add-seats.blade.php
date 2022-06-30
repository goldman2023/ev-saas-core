@extends('frontend.layouts.user_panel')

@section('page_title', translate('Plans management'))

@push('head_scripts')

@endpush

@section('panel_content')
<section>

    <div class="w-full pb-5 mb-5 border-b border-gray-200">
        <div class="flex justify-between items-center bg-white py-4 px-4 border border-gray-200 rounded-lg">
            <h4 class="text-18 text-gray-900 font-semibold">{{ translate('Add More Seats') }}</h4>
        </div>

    </div>

    <x-dashboard.widgets.customer.pricing-table :isTrial="false" :hideTitle="false" :subscribed="false" :plans="$plans">
    </x-dashboard.widgets.customer.pricing-table>

    </div>
</section>
@endsection

@push('modal')
@if((auth()->user()?->isSubscribed() ?? false) && auth()->user()?->plan_subscriptions->first()->isTrial())
<x-system.form-modal id="change-trial-plan-modal" title="{{ translate('Change trial plan') }}" class="!max-w-7xl"
    title-class="text-20 font-semibold">
    <div class="w-full py-3">
        <x-dashboard.widgets.customer.pricing-table :plans="$plans" :hide-title="true">
        </x-dashboard.widgets.customer.pricing-table>
    </div>
</x-system.form-modal>

@php
$current_plan = auth()->user()?->plan_subscriptions->first()->plan;
@endphp
<x-system.form-modal id="change-trial-plan-confirmation-modal"
    title="{{ translate('Are you sure you want to change trial plan?') }}" class="!max-w-2xl"
    title-class="text-20 font-semibold">
    <div class="w-full" x-data="{
                subscription_id: null,
                new_plan: null,
                interval: null,
                trial: true,
                trial_ends_at: '{{ auth()->user()?->plan_subscriptions->first()->end_date->format('d M, Y') }}',
                current_plan: @js($current_plan->toArray()),
                getUrl(){
                    return ('{{ route('api.dashboard.subscription.change-free-trial-plan', ['subscription_id' => '%subscription_id%', 'new_plan_id' => '%new_plan_id%']) }}?interval='+this.interval)
                            .replace('%subscription_id%', this.subscription_id).replace('%new_plan_id%', this.new_plan.id);
                },
                changePlan() {
                    wetch.get(this.getUrl())
                    .then(data => {
                        if(data.status === 'success') {
                            alert('You have successfully changed the trial plan. Please refresh the page.');
                        } else {
                            alert('wtf?');
                        }
                    })
                    .catch(error => alert(error.error.msg));
                }
            }" @display-modal.window="
                if($event.detail.id === id) {
                    subscription_id = $event.detail.subscription_id;
                    new_plan = $event.detail.new_plan;
                    interval = $event.detail.interval;
                }
            ">
        <div class="pt-2 pb-4">
            {{-- TODO: Add php FX service equivalent to JS (same as IMGProxy) --}}
            <p class="w-full text-16 text-gray-500" x-show="interval === 'month'"
                x-html="'{{ translate('By changing the subscription plan, you will be billed ') }}<strong>'+new_plan.total_price+'{{ get_tenant_setting('system_default_currency')?->symbol ?? '' }}</strong>{{ translate(' per month, after the trial ends on ') }}<strong>'+trial_ends_at+'</strong>'">
            </p>

            <p class="w-full text-16 text-gray-500" x-show="interval === 'year'"
                x-html="'{{ translate('By changing the subscription plan, you will be billed ') }}<strong>'+new_plan.total_annual_price+'{{ get_tenant_setting('system_default_currency')?->symbol ?? '' }}</strong>{{ translate(' per year, after the trial ends on ') }}<strong>'+trial_ends_at+'</strong>'">
            </p>
        </div>
        <button type="button" class="btn btn-primary flex items-center mr-2 cursor-pointer" @click="changePlan()">
            {{ translate('Change plan') }}
        </button>
    </div>
</x-system.form-modal>
@endif

@endpush

@push('footer_scripts')
{{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
--}}
{{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
--}}
{{-- <script type="text/javascript"
    src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-colvis-2.1.1/b-html5-2.1.1/b-print-2.1.1/date-1.1.1/fh-3.2.0/r-2.2.9/sl-1.3.4/datatables.min.js">
</script>--}}
@endpush
