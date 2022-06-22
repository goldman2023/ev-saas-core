@extends('frontend.layouts.user_panel')

@section('page_title', translate('Manage Users'))
@section('meta_title', translate('Manage Users'))

@section('panel_content')
<section>
    <div class="grid grid-cols-12 gap-8">

        <div class="col-span-8">
            <div class="w-full pb-5 mb-5 border-b border-gray-200">
                <div class="flex justify-between items-center bg-white py-4 px-4 border border-gray-200 rounded-lg">
                    <h4 class="text-18 text-gray-900 font-semibold">{{ translate('Customer Details') }}: {{ $user->email }}</h4>
                </div>
            </div>
            @if($user->isSubscribed() ?? false)
                <div class="w-full pb-5 mb-5 border-b border-gray-200">
                    <div class="flex justify-between items-center bg-white py-4 px-4 border border-gray-200 rounded-lg">
                        <h4 class="text-18 text-gray-900 font-semibold">{{ translate('Subscriptions') }}</h4>
                    </div>

                    <livewire:dashboard.tables.my-subscriptions-table :user="$user" :show-search="false"
                        :show-filters="false" :show-filter-dropdown="false" :show-per-page="false" :column-select="false" />
                </div>

                @do_action('view.dashboard.plans-management.plans-table.end', $user)
            @endif
            
            {{-- User Invoices --}}
            <div class="w-full pb-5 mb-5 border-b border-gray-200">
                <div class="flex justify-between items-center bg-white py-4 px-4 border border-gray-200 rounded-lg">
                    <h4 class="text-18 text-gray-900 font-semibold">{{ translate('Invoices') }}</h4>
                </div>
                <livewire:dashboard.tables.recent-invoices-widget-table :user="$user" :per-page="6" :show-per-page="false" :show-search="false" :column-select="false" />
            </div>
        </div>
        <div class="col-span-4">
            @livewire('dashboard.elements.activity-log', ['causer' => $user])
        </div>
    </div>

</section>
@endsection


@push('footer_scripts')

@endpush
