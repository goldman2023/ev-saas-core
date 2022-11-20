@extends('frontend.layouts.user_panel')

@section('page_title', translate('File Manager'))

@push('head_scripts')

@endpush

@section('panel_content')
    <x-dashboard.section-headers.section-header title="{{ translate('File manager') }}" text="">
        <x-slot name="content">

        </x-slot>
    </x-dashboard.section-headers.section-header>

    <div class="w-full">
        <livewire:we-media-library display="inline" />

    </div>
        @endsection

@push('footer_scripts')

@endpush
