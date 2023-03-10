@extends('frontend.layouts.user_panel')

@section('page_title', translate('File Manager'))

@push('head_scripts')

@endpush

@section('panel_content')
<x-dashboard.section-headers.section-header title="{{ translate('Document template preview') }}" text="">
    <x-slot name="content">

    </x-slot>
</x-dashboard.section-headers.section-header>

<div class="w-full">
    <div class="sm:w-1/2">
    @include($template)
    </div>
</div>
@endsection

@push('footer_scripts')

@endpush
