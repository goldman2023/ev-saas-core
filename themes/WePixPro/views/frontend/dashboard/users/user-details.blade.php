@extends('frontend.layouts.user_panel')

@section('page_title', translate('Manage Users'))
@section('meta_title', translate('Manage Users'))

@section('panel_content')
<section>
    <div class="grid grid-cols-12 gap-8">
        <div class="col-span-12 w-full pb-5 mb-0 border-b border-gray-200">
            <div class="flex justify-between items-center bg-white py-4 px-4 border border-gray-200 rounded-lg">
                <h4 class="text-18 text-gray-900 font-semibold">{{ translate('Customer Details') }}: {{ $user->email
                    }}</h4>
            </div>
        </div>
        @if($user->isSubscribed() ?? false)
        <div class="col-span-12">
            <x-dashboard.widgets.customer.dynamic-stats :user="$user">
                </x-dashboard.widgets.business.dynamic-stats>
        </div>
        @endif
        <div class="col-span-12 sm:col-span-8">
            @if($user->licenses()->where('license_type', 'manual')->count() > 0)
                <x-dashboard.alerts.user-details-alert></x-dashboard.alerts.user-details-alert>
            @endif
            <div x-data="{  current_tab: 'subscriptions' }" class="we-tabs">
                {{-- <x-dashboard.widgets.customers.data-tabs class="mb-3" :user="$user">
                </x-dashboard.widgets.customers.data-tabs> --}}

                <div>
                        <div class="w-full pb-5 mb-5 border-b border-gray-200">
                            <div
                                class="flex justify-between items-center bg-white py-4 px-4 border border-gray-200 rounded-lg">
                                <h4 class="text-18 text-gray-900 font-semibold">{{ translate('Subscriptions') }}</h4>
                            </div>

                            <livewire:dashboard.tables.my-subscriptions-table :user="$user" :show-search="false"
                                :show-filters="false" :show-filter-dropdown="false" :show-per-page="false"
                                :column-select="false" />

                        </div>

                        <div class="relative">
                            @include('frontend.partials.pix-pro-licenses-table', ['user' => $user])
                        </div>
                </div>

                {{-- User Invoices --}}
                <div class="w-full pb-5 mb-5 border-b border-gray-200">
                    <div class="flex justify-between items-center bg-white py-4 px-4 border border-gray-200 rounded-lg">
                        <h4 class="text-18 text-gray-900 font-semibold">{{ translate('Invoices') }}</h4>
                    </div>
                    <livewire:dashboard.tables.recent-invoices-widget-table :user="$user" :per-page="6"
                        :show-per-page="false" :show-search="false" :column-select="false" />
                </div>

                 {{-- User Orders --}}
                 <div class="w-full pb-5 mb-5 border-b border-gray-200">
                    <div class="mb-3 flex justify-between items-center bg-white py-4 px-4 border border-gray-200 rounded-lg">
                        <h4 class="text-18 text-gray-900 font-semibold">{{ translate('Orders') }}</h4>
                    </div>
                    <livewire:dashboard.tables.orders-table for="me" :per-page="6"
                        :show-per-page="false" :user="$user" :show-search="false" :column-select="false" />
                </div>
            </div>
        </div>


        <div class="col-span-12 sm:col-span-4">
            @if(\Payments::isStripeEnabled())
                <x-dashboard.widgets.customers.stripe-customer-card :user="$user">
                </x-dashboard.widgets.customers.stripe-customer-card>
            @endif

            <div class="mb-6">
            @if(\Payments::isStripeEnabled())
                <x-dashboard.widgets.invoices.next-payment :user="$user">
                </x-dashboard.widgets.invoices.next-payment>
                @endif
            </div>
            <div class="mb-6">
                <x-dashboard.widgets.customer.address-details :user="$user">
                </x-dashboard.widgets.business.address-details>
            </div>

            <div class="mb-6">
                @if(\Payments::isStripeEnabled())
                    <x-dashboard.widgets.invoices.user-balance :user="$user">
                    </x-dashboard.widgets.invoices.user-balance>
                @endif
            </div>

            @livewire('dashboard.elements.activity-log', ['causer' => $user])
        </div>
    </div>

</section>
@endsection


@push('footer_scripts')

@endpush
