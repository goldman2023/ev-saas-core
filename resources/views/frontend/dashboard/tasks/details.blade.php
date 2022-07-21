@extends('frontend.layouts.user_panel')

@section('page_title', translate('Task #') . ($task->id ?? '') . translate('details'))

@push('head_scripts')
@endpush

@section('panel_content')
    <x-dashboard.section-headers.section-header title="{{ translate('All tasks') }}" text="">
        <x-slot name="content">
            <a href="{{ route('tasks.index') }}" class="btn-primary">
                @svg('heroicon-o-chevron-left', ['class' => 'h-4 h-4 mr-2'])
                <span>{{ translate('All tasks') }}</span>
            </a>
        </x-slot>
    </x-dashboard.section-headers.section-header>

    <div class="bg-gray-50">
        <div class="max-w-2xl mx-auto pt-16 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
            <div class="px-4 space-y-2 sm:px-0 sm:flex sm:items-baseline sm:justify-between sm:space-y-0 mb-3">
                <div class="flex items-center sm:space-x-4">
                    <h1 class="ftext-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl">{{ translate('Task') }}:
                        #{{ $task->id }}</h1>

                    <span class="badge-dark ml-2">{{ \App\Enums\TaskTypesEnum::labels()[$task->type] ?? '' }}</span>
                    <div class="flex items-center">
                        @if ($task->status === App\Enums\TaskStatusEnum::scoping()->value)
                            <span class="badge-success">{{ ucfirst(\Str::replace('_', ' ', $task->status)) }}</span>
                        @elseif($task->status === App\Enums\TaskStatusEnum::backlog()->value)
                            <span class="badge-info">{{ ucfirst(\Str::replace('_', ' ', $task->status)) }}</span>
                        @elseif($task->status === App\Enums\TaskStatusEnum::in_progress()->value)
                            <span class="badge-danger">{{ ucfirst(\Str::replace('_', ' ', $task->status)) }}</span>
                        @elseif($task->status === App\Enums\TaskStatusEnum::review()->value)
                            <span class="badge-purple">{{ ucfirst(\Str::replace('_', ' ', $task->status)) }}</span>
                        @elseif($task->status === App\Enums\TaskStatusEnum::done()->value)
                            <span class="badge-blue">{{ ucfirst(\Str::replace('_', ' ', $task->status)) }}</span>
                        @endif
                    </div>
                </div>
                <p class="text-sm text-gray-600">
                    {{ translate('Task created on:') }}
                    <time datetime="2021-03-22"
                        class="font-semibold text-gray-900">{{ $task->created_at->format('M d, Y H:i') }}</time>
                </p>
            </div>

            {{-- Actions --}}
            <div class="px-4 py-2 space-y-2 sm:px-0 flex items-center justify-between sm:space-y-0 mb-4">
            </div>

            <div>
                <span class="text-center"> Name: {{ $task->name }} </span>
            </div>
            

            <div>
                <span class="text-center"> Subject Type: {{ App\Models\Product::where('id',$task->subject_id)->first()->name }} </span>
            </div>

            <div>
                <a class="media align-items-center text-14" href="{{ route('user.details', ['id' => $task->user_id]) }}">
                    @php
                        $user = App\Models\User::where('id', $task->user_id)->first();
                    @endphp
                    @if (!empty($user->thumbnail))
                        <img class="h-10 w-10 rounded-full border-3 ring-2 border-gray-200 mr-3 object-cover shrink-0"
                            src="{{ $user->getThumbnail(['w' => '120']) }}" />
                    @endif
                    <span class="text-blue-600"> {{ $user->name . ' ' . $user->surname }}</span>
                </a>
            </div>

            <div>
                <a class="media align-items-center text-14"
                    href="{{ route('user.details', ['id' => $task->assignee_id]) }}">
                    @php
                        $user = App\Models\User::where('id', $task->assignee_id)->first();
                    @endphp
                    @if (!empty($user->thumbnail))
                        <img class="h-10 w-10 rounded-full border-3 ring-2 border-gray-200 mr-3 object-cover shrink-0"
                            src="{{ $user->getThumbnail(['w' => '120']) }}" />
                    @endif
                    <span class="text-blue-600"> {{ $user->name . ' ' . $user->surname }}</span>
                </a>
            </div>
            <div>
                <span class="text-center"> Content: {{ $task->content }} </span>
            </div>
        </div>
    </div>
@endsection
@push('footer_scripts')
@endpush
