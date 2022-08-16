@extends('frontend.layouts.user_panel')

@section('page_title', translate('All Invoices'))

@push('head_scripts')

@endpush

@section('panel_content')
    <x-dashboard.section-headers.section-header title="{{ translate('All invoices') }}" text="">
        <x-slot name="content">
            <a href="{{ route('order.create') }}" class="btn-primary">
                @svg('heroicon-o-plus', ['class' => 'h-4 h-4 mr-2'])
                <span>{{ translate('Add new Order') }}</span>
            </a>
        </x-slot>
    </x-dashboard.section-headers.section-header>

    <div class="w-full">
        @if($invoices_count > 0)
            <livewire:dashboard.tables.invoices-table :per-page="10" />
        @else
            <x-dashboard.empty-states.no-items-in-collection
                icon="heroicon-o-document"
                title="{{ translate('No invoices yet') }}"
                text="{{ translate('Engage your customers so you can get a new invoice!') }}"
              >

            </x-dashboard.empty-states.no-items-in-collection>
        @endif
    </div>
@endsection

@push('footer_scripts')

@endpush