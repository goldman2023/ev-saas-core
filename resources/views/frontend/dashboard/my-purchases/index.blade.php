@extends('frontend.layouts.user_panel')

@section('meta_title', translate('My Purchases'))

@push('head_scripts')

@endpush

@section('panel_content')
    <x-dashboard.section-headers.section-header title="{{ translate('My purchases') }}" text="">
        <x-slot name="content">
            {{-- <a href="{{ route('order.create') }}" class="btn-primary">
                @svg('heroicon-o-plus', ['class' => 'h-4 h-4 mr-2'])
                <span>{{ translate('Add new') }}</span>
            </a> --}}
        </x-slot>
    </x-dashboard.section-headers.section-header>

    <div class="w-full grid grid-cols-12 gap-8">
        <div class="col-span-12 md:col-span-12">
            @if($ownerships_count_all > 0)
                @livewire('dashboard.my-purchases-list', [
                    'per_page' => 10
                ])
            @else
                <x-dashboard.empty-states.no-items-in-collection
                    icon="heroicon-o-shopping-bag"
                    title="{{ translate('Nothing to show') }}"
                    text="{{ translate('You have not made any purchases yet!') }}"
                    link-href-route="home"
                    link-text="{{ translate('Start Shopping') }}">
                </x-dashboard.empty-states.no-items-in-collection>
            @endif
        </div>
        {{-- <div class="col-span-12 md:col-span-4"> --}}
            {{-- Create Activity Log livewire component but only for Ownerships! --}}
            {{-- @livewire('dashboard.elements.activity-log', ['causer' => auth()->user(), 'per_page' => 5]) --}}
        {{-- </div> --}}

    </div>

@endsection

@push('footer_scripts')

@endpush
