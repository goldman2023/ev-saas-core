@extends('frontend.layouts.user_panel')

@section('meta_title', translate('My Purchases'))

@push('head_scripts')
    
@endpush

@section('panel_content')
    <x-dashboard.section-headers.section-header title="{{ translate('My Downloads') }}" text="">
        <x-slot name="content">
            {{-- <a href="{{ route('order.create') }}" class="btn-primary">
                @svg('heroicon-o-plus', ['class' => 'h-4 h-4 mr-2'])
                <span>{{ translate('Add new') }}</span>
            </a> --}}
        </x-slot>
    </x-dashboard.section-headers.section-header>

    <div class="w-full">
        

        @do_action('view.dashboard.my-downloads.end')
    </div>

@endsection

@push('footer_scripts')

@endpush
