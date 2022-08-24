@extends('frontend.layouts.user_panel')

@section('page_title', translate('Add new Section'))

@push('head_scripts')

@endpush

@section('panel_content')
    <section>
        <x-dashboard.section-headers.section-header title="{{ translate('New Section') }}" text="">
            <x-slot name="content">
                <a href="{{ route('sections.index') }}" class="btn-standard">
                    @svg('heroicon-o-chevron-left', ['class' => 'h-4 h-4 mr-2'])
                    <span>{{ translate('All sections') }}</span>
                </a>
            </x-slot>
        </x-dashboard.section-headers.section-header>

        <livewire:dashboard.forms.sections.section-form />
    </section>
@endsection

@push('footer_scripts')

@endpush
