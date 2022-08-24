@extends('frontend.layouts.user_panel')

@section('page_title', translate('All Sections'))

@push('head_scripts')

@endpush

@section('panel_content')
    <x-dashboard.section-headers.section-header title="{{ translate('All sections') }}" text="">
        <x-slot name="content">
            <a href="{{ route('section.create') }}" class="btn-primary">
                @svg('heroicon-o-plus', ['class' => 'h-4 h-4 mr-2'])
                <span>{{ translate('Add new') }}</span>
            </a>
        </x-slot>
    </x-dashboard.section-headers.section-header>

    <div class="w-full">
        @if($sections->count() > 0)
            <livewire:dashboard.tables.sections-table></livewire:dashboard.tables.sections-table>
        @else
            <x-dashboard.empty-states.no-items-in-collection 
                icon="heroicon-o-collection" 
                title="{{ translate('No sections yet') }}"
                text="{{ translate('Create your first section!') }}"
                link-href-route="section.create"
                link-text="{{ translate('Add new Section') }}">

            </x-dashboard.empty-states.no-items-in-collection>
        @endif
    </div>
@endsection

@push('footer_scripts')

@endpush
