@extends('frontend.layouts.user_panel')

@section('page_title', translate('All Tasks'))

@push('head_scripts')

@endpush

@section('panel_content')
    <x-dashboard.section-headers.section-header title="{{ translate('All tasks') }}" text="">
        <x-slot name="content">
            <a href="{{ route('task.create') }}" class="btn-primary">
                @svg('heroicon-o-plus', ['class' => 'h-4 h-4 mr-2'])
                <span>{{ translate('Add new') }}</span>
            </a>
        </x-slot>
    </x-dashboard.section-headers.section-header>

    <div class="w-full">
        @if($tasks > 0)
            <livewire:dashboard.tables.tasks-table></livewire:dashboard.tables.tasks-table>
        @else
            <x-dashboard.empty-states.no-items-in-collection
                icon="heroicon-o-document"
                title="{{ translate('No tasks yet') }}"
                text="{{ translate('Engage your customers so you can get a new task!') }}"
              >

            </x-dashboard.empty-states.no-items-in-collection>
        @endif

    </div>
@endsection

@push('footer_scripts')

@endpush
