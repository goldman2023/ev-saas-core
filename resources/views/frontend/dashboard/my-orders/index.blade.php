@extends('frontend.layouts.user_panel')

@section('meta_title', translate('Invoices'))

@push('head_scripts')

@endpush

@section('panel_content')
<x-dashboard.section-headers.section-header title="{{ translate('Invoices') }}"
    text="{{ translate('You can view, manage and download your orders and invoices here.') }}">
    <x-slot name="content">
        {{-- <a href="{{ route('order.create') }}" class="btn-primary">
            @svg('heroicon-o-plus', ['class' => 'h-4 h-4 mr-2'])
            <span>{{ translate('Add new') }}</span>
        </a> --}}
    </x-slot>
</x-dashboard.section-headers.section-header>

<div class="w-full">
    <div class="mb-6">

    </div>

    <div class="grid grid-cols-12 gap-6">

        <div class="w-full pb-5 mb-5 border-b border-gray-200 col-span-12 sm:col-span-9">
            <div class="flex justify-between items-center bg-white py-4 px-4 border border-gray-200 rounded-lg">
                <h4 class="text-18 text-gray-900 font-semibold">{{ translate('All Invoices') }}</h4>
            </div>

            <livewire:dashboard.tables.recent-invoices-widget-table :user="auth()->user()" :per-page="10"
                :show-per-page="false" :show-search="false" :column-select="false" />
        </div>

        <div class="col-span-12 sm:col-span-3">

            <div class="mb-6">
                <x-dashboard.widgets.invoices.next-payment>
                </x-dashboard.widgets.invoices.next-payment>
            </div>


            <div class="mb-6">
                <x-dashboard.widgets.invoices.user-balance>
                </x-dashboard.widgets.invoices.user-balance>
            </div>




        </div>
    </div>


    {{-- <div class="w-full">
        <div class="flex justify-between items-center bg-white py-4 px-4 border border-gray-200 rounded-lg mb-4">
            <h4 class="text-18 text-gray-900 font-semibold">{{ translate('All Orders') }}</h4>
        </div>

        <livewire:dashboard.tables.my-orders-table :show-filters="auth()->user()->isCustomer() ? false : true"
            :show-filter-dropdown="auth()->user()->isCustomer() ? false : true">
        </livewire:dashboard.tables.my-orders-table>
    </div> --}}
</div>
@endsection

@push('footer_scripts')

@endpush
