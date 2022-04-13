@extends('frontend.layouts.user_panel')

@section('meta_title', translate('My Purchases'))

@push('head_scripts')
    
@endpush

@section('panel_content')
    <x-dashboard.section-headers.section-header title="{{ translate('All orders') }}" text="">
        <x-slot name="content">
            <a href="{{ route('order.create') }}" class="btn-primary">
                @svg('heroicon-o-plus', ['class' => 'h-4 h-4 mr-2'])
                <span>{{ translate('Add new') }}</span>
            </a>
        </x-slot>
    </x-dashboard.section-headers.section-header>

    <div class="w-full">
        @if($orders_count > 0)
            <livewire:dashboard.tables.my-purchases-table></livewire:dashboard.tables.my-purchases-table>
        @else
            <x-dashboard.empty-states.no-items-in-collection 
                icon="heroicon-o-document" 
                title="{{ translate('No purchases yet') }}"
                text="{{ translate('You haven\'t made any purchases yet!') }}"
                link-href-route="feed.products"
                link-text="{{ translate('Start Shopping') }}">

            </x-dashboard.empty-states.no-items-in-collection>
        @endif
    </div>

@endsection

@push('footer_scripts')

@endpush
