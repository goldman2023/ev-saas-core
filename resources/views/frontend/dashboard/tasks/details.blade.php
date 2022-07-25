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

    <div class="min-h-full">
        <main class="pb-8">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:max-w-7xl lg:px-0">
                <div class="grid grid-cols-1 gap-4 items-start lg:grid-cols-3 lg:gap-8">
                    <!-- Left column -->
                    <div class="grid grid-cols-1 gap-4 lg:col-span-2">

                        <div class="rounded-lg p-6 bg-white overflow-hidden shadow">
                            <div class="flex items-center">
                                <h1 class="ftext-xl font-medium tracking-tight text-gray-900 sm:text-3xl">{{ $task->name }}
                                </h1>
                                @if ($task->status === App\Enums\TaskStatusEnum::scoping()->value)
                                    <span class="badge-info">{{ ucfirst(\Str::replace('_', ' ', $task->status)) }}</span>
                                @elseif($task->status === App\Enums\TaskStatusEnum::backlog()->value)
                                    <span class="badge-yellow">{{ ucfirst(\Str::replace('_', ' ', $task->status)) }}</span>
                                @elseif($task->status === App\Enums\TaskStatusEnum::in_progress()->value)
                                    <span class="badge-success">{{ ucfirst(\Str::replace('_', ' ', $task->status)) }}</span>
                                @elseif($task->status === App\Enums\TaskStatusEnum::review()->value)
                                    <span class="badge-success">{{ ucfirst(\Str::replace('_', ' ', $task->status)) }}</span>
                                @elseif($task->status === App\Enums\TaskStatusEnum::done()->value)
                                    <span class="badge-info">{{ ucfirst(\Str::replace('_', ' ', $task->status)) }}</span>
                                @endif
                            </div>


                            <div class="flex flex-col space-y-12">
                                <p class="text-sm text-gray-600">
                                    <time datetime="2021-03-22"
                                        class="font-medium text-gray-700">{{ $task->created_at->format('M d, Y H:i') }}</time>
                                </p>
                                <div>
                                   <p class="font-semibold text-gray-700"> {{ translate('Subject') }}:
                                    {{ App\Models\Product::where('id',$task->subject_id)->first()->name}} </p>
                                </div>
                                <div>
                                   <p class="font-semibold text-gray-700"> {{ translate('Description') }}</p>
                                    {!! $task->content !!} 
                                </div>
                            </div>
                        </div>

                        <livewire:actions.social-comments :reviews="true" :item="$task" />
                    </div>
                    <!-- Right column -->
                    <div class="grid grid-cols-1 gap-4">

                        <div class="rounded-lg bg-white overflow-hidden shadow">
                            <div class="p-6 relative">

                                <div class="space-y-6">
                                    <div class="space-y-6">
                                        <h3 class="font-semibold text-gray-700">{{ translate('Creator') }}</h3>
                                        <a class="media align-items-center text-14"
                                            href="{{ route('user.details', ['id' => $task->user_id]) }}">
                                            @php
                                                $user = App\Models\User::where('id', $task->user_id)->first();
                                                $shop = new App\Models\Shop();
                                            @endphp
                                            <div class="flex items-center">
                                                @if (!empty($user->thumbnail))
                                                    <img class="h-9 w-9 rounded-full border-3 ring-2 border-gray-200 mr-3 object-cover shrink-0"
                                                        src="{{ $user->getThumbnail(['w' => '120']) }}" />
                                                @else
                                                    <img class="h-9 w-9 rounded-full border-3 ring-2 border-gray-200 mr-3 object-cover shrink-0"
                                                        src="{{ $shop->get_company_logo() }}" />
                                                @endif
                                                <span class="font-semibold text-gray-700">
                                                    {{ $user->name . ' ' . $user->surname }}</span>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="space-y-6">
                                        <h3 class="font-semibold">{{ translate('Assignee') }}</h3>
                                        <a class="media align-items-center text-14"
                                            href="{{ route('user.details', ['id' => $task->assignee_id]) }}">
                                            @php
                                                $user = App\Models\User::where('id', $task->assignee_id)->first();
                                                $shop = new App\Models\Shop();
                                            @endphp
                                            <div class="flex items-center">
                                                @if (!empty($user->thumbnail))
                                                    <img class="h-9 w-9 rounded-full border-3 ring-2 border-gray-200 mr-3 object-cover shrink-0"
                                                        src="{{ $user->getThumbnail(['w' => '120']) }}" />
                                                @else
                                                    <img class="h-9 w-9 rounded-full border-3 ring-2 border-gray-200 mr-3 object-cover shrink-0"
                                                        src="{{ $shop->get_company_logo() }}" />
                                                @endif
                                                <span class="font-semibold text-gray-700">
                                                    {{ $user->name . ' ' . $user->surname }}</span>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="space-x-20">
                                        <a href="{{ route('task.edit', ['id' => $task->id]) }}"
                                            class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                            {{ translate('Edit') }}
                                            @svg('heroicon-s-pencil', ['class' => 'w-6 h-6 ml-2'])
                                        </a>

                                        <a href="{{ route('task.destroy', ['id' => $task->id]) }}"
                                            class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-white bg-[#ff0000] hover:bg-gray-50">
                                            {{ translate('Delete') }}
                                            @svg('heroicon-s-trash', ['class' => 'w-6 h-6 ml-2'])
                                        </a>
                                    </div>
                                        <a href="{{ route('task.completed', ['id' => $task->id]) }}"
                                        class="w-full flex justify-center items-center px-3 py-2 border border-transparent shadow-sm text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        {{ translate('Mark as Done') }}
                                        @svg('heroicon-s-badge-check', ['class' => 'w-6 h-6 ml-2'])
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-lg bg-white overflow-hidden shadow">
                            <div class="p-6 relative">
                                <h3 class="text-base font-medium text-gray-900 relative">
                                    {{ translate('Task History') }}


                                </h3>
                                {{-- Live data badge --}}
                                <div class="absolute right-6 top-6">

                                    <span
                                        class="relative inline-flex font-bold items-center px-3 py-0.5 rounded-full text-sm bg-red-100 text-red-500">
                                        <span
                                            class="animate-ping inline-flex h-1.5 w-1.5 mr-3 rounded-full bg-red-900 opacity-100"></span>
                                        {{ translate('Live') }}
                                    </span>
                                </div>
                                {{-- Live data badge end --}}
                                <livewire:product-activity type="product" :product="$task" />
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
@push('footer_scripts')
@endpush
