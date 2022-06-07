@extends('frontend.layouts.user_panel')

@section('meta_title', translate('My Orders and Invoices'))

@push('head_scripts')
    
@endpush

@section('panel_content')
    <x-dashboard.section-headers.section-header title="{{ translate('My Orders and Invoices') }}" text="{{ translate('You can view, manage and download your orders and invoices here.') }}">
        <x-slot name="content">
            {{-- <a href="{{ route('order.create') }}" class="btn-primary">
                @svg('heroicon-o-plus', ['class' => 'h-4 h-4 mr-2'])
                <span>{{ translate('Add new') }}</span>
            </a> --}}
        </x-slot>
    </x-dashboard.section-headers.section-header>

    <div class="w-full">
        @if($orders_count > 0)
            <div class="text-18 text-gray-900 font-semibold">
                {{ translate('All Orders') }}
            </div>

            <livewire:dashboard.tables.my-orders-table></livewire:dashboard.tables.my-orders-table>
        @else
            <x-dashboard.empty-states.no-items-in-collection 
                icon="heroicon-o-document" 
                title="{{ translate('No orders and invoices yet') }}"
                {{-- text="{{ translate('You haven\'t made any purchases yet!') }}" --}}
                link-href-route="feed.products"
                link-text="{{ translate('Start Shopping') }}">

            </x-dashboard.empty-states.no-items-in-collection>
        @endif

        <div class="w-full mt-5">
            <div class="text-18 text-gray-900 font-semibold">
                {{ translate('All Invoices') }}
            </div>
            <livewire:dashboard.tables.recent-invoices-widget-table for="me" :per-page="10" :show-per-page="false" :show-search="false" :column-select="false" />
        </div>
    </div>

@endsection

@push('footer_scripts')

@endpush
