@extends('frontend.layouts.user_panel')

@section('page_title', translate('Create New Order'))

@push('head_scripts')

@endpush

@section('panel_content')
    <section>
        <x-dashboard.section-headers.section-header title="{{ translate('New Order') }}" text="">
            <x-slot name="content">
                <a href="{{ route('orders.index') }}" class="btn-standard">
                    @svg('heroicon-o-chevron-left', ['class' => 'h-4 h-4 mr-2'])
                    <span>{{ translate('All orders') }}</span>
                </a>
            </x-slot>
        </x-dashboard.section-headers.section-header>

        <livewire:dashboard.forms.orders.order-form :order="$order" />
    </section>
@endsection

@push('footer_scripts')

@endpush

