@extends('frontend.layouts.user_panel')

@section('page_title', translate('Plans management'))

@push('head_scripts')

@endpush

@section('panel_content')
<section>
    <x-dashboard.section-headers.section-header title="{{ translate('Plans Management') }}"
        text="{{ translate('Manage your subscriptions, licenses and billing') }}">
        <x-slot name="content">
            @if(auth()->user()?->isSubscribed() ?? false)
                <a href="{{ route('stripe.portal_session') }}" class="btn-primary">
                    {{ translate('Billing Portal') }}
                </a>
            @endif
        </x-slot>
    </x-dashboard.section-headers.section-header>

    @if(auth()->user()?->hasLicenses())
    <div class="col-span-12">
        @include('frontend.partials.pix-pro-licenses-table', ['user' => auth()->user()])
    </div>
    @endif


    @if(auth()->user()?->isSubscribed() ?? false)
        <div class="w-full pb-5 mb-5 border-b border-gray-200">
            <div class="flex justify-between items-center bg-white py-4 px-4 border border-gray-200 rounded-lg">
                <h4 class="text-18 text-gray-900 font-semibold">{{ translate('Subscriptions') }}</h4>
            </div>

            <livewire:dashboard.tables.my-subscriptions-table :user="auth()->user()" :show-search="false"
                :show-filters="false" :show-filter-dropdown="false" :show-per-page="false" :column-select="false" />
        </div>
    @endif

    <x-dashboard.widgets.customer.pricing-table :plans="$plans">
    </x-dashboard.widgets.customer.pricing-table>
</section>
@endsection

@push('modal')

@endpush

@push('footer_scripts')
@endpush
