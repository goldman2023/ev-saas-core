@extends('frontend.layouts.user_panel')

@section('page_title', translate('Edit Task'))

@push('head_scripts')

@endpush

@section('panel_content')
    <section>
        <x-dashboard.section-headers.section-header title="{{ translate('Edit Task') }}" text="">
            <x-slot name="content">
                <a href="{{ route('tasks.index') }}" class="btn-standard">
                    @svg('heroicon-o-chevron-left', ['class' => 'h-4 h-4 mr-2'])
                    <span>{{ translate('All Tasks') }}</span>
                </a>
            </x-slot>
        </x-dashboard.section-headers.section-header>

        <livewire:dashboard.forms.tasks.task-form :task="$task"></livewire:dashboard.forms.tasks.task-form>
    </section>
@endsection

@push('footer_scripts')
@endpush