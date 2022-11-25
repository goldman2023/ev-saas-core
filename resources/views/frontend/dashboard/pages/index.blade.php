@extends('frontend.layouts.user_panel')

@section('page_title', translate('All Pages'))

@push('head_scripts')

@endpush

@section('panel_content')
    <x-dashboard.section-headers.section-header title="{{ translate('All pages') }}" text="">
        <x-slot name="content">
            <a href="{{ route('page.create') }}" class="btn-primary">
                @svg('heroicon-o-plus', ['class' => 'h-4 h-4 mr-2'])
                <span>{{ translate('Add new') }}</span>
            </a>
        </x-slot>
    </x-dashboard.section-headers.section-header>

    <div class="w-full">
        @if($pages->count() > 0)
            <livewire:dashboard.tables.pages-table></livewire:dashboard.tables.pages-table>
        @else
            <x-dashboard.empty-states.no-items-in-collection
                icon="heroicon-o-document"
                title="{{ translate('No pages yet') }}"
                text="{{ translate('Create your first page!') }}"
                link-href-route="page.create"
                link-text="{{ translate('Add new Page') }}">

            </x-dashboard.empty-states.no-items-in-collection>
        @endif
    </div>
@endsection

@push('footer_scripts')

@endpush
