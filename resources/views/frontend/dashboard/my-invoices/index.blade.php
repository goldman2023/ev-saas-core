@extends('frontend.layouts.user_panel')

@section('meta_title', translate('Invoices'))

@push('head_scripts')

@endpush

@section('panel_content')
<x-dashboard.section-headers.section-header title="{{ translate('Invoices') }}"
    text="{{ translate('You can view, manage and download your invoices here.') }}">
    <x-slot name="content">
    </x-slot>
</x-dashboard.section-headers.section-header>

<div class="w-full">
    <div class="grid grid-cols-12 gap-6">

        <div class="col-span-12 sm:col-span-9 pb-5 mb-5 border-b border-gray-200 ">
            <livewire:dashboard.tables.recent-invoices-widget-table :user="auth()->user()" :per-page="25"
                :show-per-page="true" :show-search="false" :column-select="false" />
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

</div>
@endsection

@push('footer_scripts')

@endpush
