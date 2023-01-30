@extends('frontend.layouts.user_panel')

@section('meta_title', translate('My Orders'))

@push('head_scripts')

@endpush

@section('panel_content')
<x-dashboard.section-headers.section-header title="{{ translate('My Orders') }}"
    text="{{ translate('You can view, manage and download your orders here.') }}">
    <x-slot name="content">
    </x-slot>
</x-dashboard.section-headers.section-header>

<div class="w-full">
    <div class="grid grid-cols-12 gap-6">

        <div class="col-span-12 sm:col-span-8 pb-5 mb-5 border-b border-gray-200 ">
            <x-dashboard.orders.customer-orders-table> </x-dashboard.orders.customer-orders-table>
        </div>

        <div class="col-span-12 sm:col-span-4 flex flex-col space-y-3">
            <x-dashboard.elements.support-card class="card bg-white p-4 mb-3">
            </x-dashboard.elements.support-card>

            <x-theme::dashboard.elements.customer-quick-actions />
        </div>
        
    </div>

</div>

@endsection

@push('footer_scripts')

@endpush
