@extends('frontend.layouts.user_panel')

@section('page_title', translate('Quiz Results'))

@push('head_scripts')

@endpush

@section('panel_content')
    <x-dashboard.section-headers.section-header title="{{ translate('Quiz Results') }}" text="">
        <x-slot name="content">
            <a href="{{ route('dashboard.we-quiz.details', $quiz->id) }}" class="btn-primary">
                @svg('heroicon-o-pencil', ['class' => 'h-4 h-4 mr-2'])
                <span>{{ translate('Quiz Details') }}</span>
            </a>
        </x-slot>
    </x-dashboard.section-headers.section-header>

    <div class="w-full">
        @if($quiz->results()->count() > 0)
            <livewire:dashboard.tables.we-quiz-results-table :we-quiz="$quiz"/>
        @else
            <x-dashboard.empty-states.no-items-in-collection
                icon="heroicon-o-chat-bubble-left-right"
                title="{{ translate('No quiz results yet') }}"
                text="{{ translate('Engage your customers with interesting questions!') }}"
                link-href-route="dashboard.we-quiz.edit"
                link-text="{{ translate('Edit Quiz') }}">

            </x-dashboard.empty-states.no-items-in-collection>
        @endif

    </div>
@endsection

@push('footer_scripts')

@endpush
