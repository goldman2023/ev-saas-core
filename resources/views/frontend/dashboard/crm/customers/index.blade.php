@extends('frontend.layouts.user_panel')

@section('page_title', translate('Browse Customers'))
@section('meta_title', translate('Browse Customers'))

@section('panel_content')
    <section>
        <x-dashboard.section-headers.section-header title="{{ translate('Customers') }}" text="{{ translate('Browse all the customers of your shop.') }}">
            <x-slot name="content">

            </x-slot>
        </x-dashboard.section-headers.section-header>
<div class="mb-6">
    <x-dashboard.widgets.business.dynamic-k-p-i></x-dashboard.widgets.business.dynamic-k-p-i>

</div>


        <div class="w-full">
            <livewire:dashboard.tables.users-table for="customer"></livewire:dashboard.tables.users-table>
        </div>
    </section>
@endsection

@push('footer_scripts')

@endpush
