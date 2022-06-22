@extends('frontend.layouts.user_panel')

@section('meta_title', translate('Invoices and Orders'))

@push('head_scripts')

@endpush

@section('panel_content')
    <x-dashboard.section-headers.section-header title="{{ translate('Invoices and Orders') }}" text="{{ translate('You can view, manage and download your orders and invoices here.') }}">
        <x-slot name="content">
            {{-- <a href="{{ route('order.create') }}" class="btn-primary">
                @svg('heroicon-o-plus', ['class' => 'h-4 h-4 mr-2'])
                <span>{{ translate('Add new') }}</span>
            </a> --}}
        </x-slot>
    </x-dashboard.section-headers.section-header>

    <div class="w-full">
        <div class="w-full pb-5 mb-5 border-b border-gray-200">
            <div class="flex justify-between items-center bg-white py-4 px-4 border border-gray-200 rounded-lg">
                <h4 class="text-18 text-gray-900 font-semibold">{{ translate('All Invoices') }}</h4>
             </div>

            <livewire:dashboard.tables.recent-invoices-widget-table :user="auth()->user()" :per-page="10" :show-per-page="false" :show-search="false" :column-select="false" />
        </div>

        <div class="w-full">
            @if($orders_count > 0)
            <div class="flex justify-between items-center bg-white py-4 px-4 border border-gray-200 rounded-lg mb-4">
                <h4 class="text-18 text-gray-900 font-semibold">{{ translate('All Orders') }}</h4>
             </div>

                {{-- TODO: Showing filters and tweaking anything regarding the tables should be managed per tenant from app-settings or something like that --}}
                <livewire:dashboard.tables.my-orders-table :show-filters="auth()->user()->isCustomer() ? false : true" :show-filter-dropdown="auth()->user()->isCustomer() ? false : true"></livewire:dashboard.tables.my-orders-table>
            @else
                <x-dashboard.empty-states.no-items-in-collection
                    icon="heroicon-o-shopping-cart"
                    title="{{ translate('No orders and invoices yet') }}"
                    {{-- text="{{ translate('You haven\'t made any purchases yet!') }}" --}}
                    link-href-route="feed.products"
                    link-text="{{ translate('Start Shopping') }}">

                </x-dashboard.empty-states.no-items-in-collection>
            @endif
        </div>


    </div>

@endsection

@push('footer_scripts')

@endpush
