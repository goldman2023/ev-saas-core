@extends('frontend.layouts.user_panel')

@section('page_title', translate('All Quizzes'))

@push('head_scripts')

@endpush

@section('panel_content')
    <x-dashboard.section-headers.section-header title="{{ translate('All Quizzes') }}" text="">
        <x-slot name="content">
            <a href="{{ route('we-quiz.create') }}" class="btn-primary">
                @svg('heroicon-o-plus', ['class' => 'h-4 h-4 mr-2'])
                <span>{{ translate('New Quiz') }}</span>
            </a>
        </x-slot>
    </x-dashboard.section-headers.section-header>

    <div class="w-full">
        @if($quizes->count() > 0)
            <livewire:dashboard.tables.we-quiz-table></livewire:dashboard.tables.we-quiz-table>
        @else
            <x-dashboard.empty-states.no-items-in-collection
                icon="heroicon-o-document"
                title="{{ translate('No quizzes yet') }}"
                text="{{ translate('Create your first quiz!') }}"
                link-href-route="dashboard.we-quiz.create"
                link-text="{{ translate('Add new Quiz') }}">

            </x-dashboard.empty-states.no-items-in-collection>
        @endif

    </div>
@endsection

@push('footer_scripts')

@endpush
