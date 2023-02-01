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

    <div class="w-full" x-cloak>
        @if($tasks->isNotEmpty())
            <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                <ul class="flex overflow-x-auto sm:flex-wrap -mb-px text-sm font-medium text-center"
                    id="tasks-tabs-header" data-tabs-toggle="#tasks-tabs" role="tablist">

                    @foreach(\WeThemes\WeBaltic\App\Enums\TaskTypesEnum::labels() as $type => $type_label)
                        <li class="mr-2" role="presentation">
                            <button
                                class="inline-block p-4 rounded-t-lg border-b-2 text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-500 border-blue-600 dark:border-blue-500"
                                id="tasks-nav-{{ $type }}" data-tabs-target="#tasks-tab-{{ $type }}" type="button" role="tab"
                                aria-controls="tasks-nav-{{ $type }}" @if($type == 'printing') aria-selected="true" @endif>
                                {{ $type_label }} ({{ \App\Models\Task::where('type', $type)->count() }})
                            </button>
                        </li>
                    @endforeach

                </ul>
            </div>
            <div id="tasks-tabs">
                @foreach(\WeThemes\WeBaltic\App\Enums\TaskTypesEnum::labels() as $type => $label)
                    <div id="tasks-tab-{{ $type }}" role="tabpanel" class="sm:grid sm:grid-cols-12 gap-6">
                        <div class="sm:col-span-9">
                            <livewire:dashboard.tables.tasks-table :type="$type" table-id="tasks-table-{{ $type }}">
                            </livewire:dashboard.tables.tasks-table>
                        </div>
                        <div class="flex flex-col sm:col-span-3 gap-y-4">
                            @if(auth()->user()->isAdmin())
                                <livewire:dashboard.tables.action-panels.tasks-action-panel table-id="tasks-table-{{ $type }}" tasks-type="{{ $type }}" />
                            @else
                                <x-dashboard.elements.support-card class="card bg-white p-4 mb-3">
                                </x-dashboard.elements.support-card>
                            @endif

                            @if($type === 'printing')
                                <livewire:dashboard.tasks.latest-printing-tasks-batch />
                            @elseif($type === 'delivery')
                                <livewire:dashboard.tasks.latest-delivery-task />
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <x-dashboard.empty-states.no-items-in-collection
                icon="heroicon-o-document"
                title="{{ translate('No tasks yet') }}"
                text="{{ translate('There are currently no tasks at all. Do something Task related, and you\'ll see them here.') }}"
            >

            </x-dashboard.empty-states.no-items-in-collection>
        @endif


    </div>
@endsection

@push('footer_scripts')

@endpush
