@extends('frontend.layouts.user_panel')

@section('page_title', translate('Document templates'))

@push('head_scripts')

@endpush

@section('panel_content')
<x-dashboard.section-headers.section-header title="{{ translate('Document templates') }}" text="">
    <x-slot name="content">

    </x-slot>
</x-dashboard.section-headers.section-header>

<div class="w-full grid sm:grid-cols-3 gap-6">
    @foreach($availableTemplates as $template)
    <div class="card">
        <div class="text-xl font-medium mb-3">
            {{ translate('Template:')}} {{ $template }}
        </div>
        <div>
            <a class="text-indigo-700" href="{{ route('document.templates.preview', $template) }}">
                {{ translate('Preview') }}
            </a>
        </div>
    </div>
    @endforeach
</div>
@endsection

@push('footer_scripts')

@endpush
