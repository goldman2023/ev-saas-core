<div class="card mb-9 !p-3 !pb-5">

<div class="mb-4 border-b border-gray-200 dark:border-gray-700">
    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
        <li class="mr-2" role="presentation">
            <button class="inline-block font-medium text-lg p-3 border-b-2 rounded-t-lg" id="profile-tab" data-tabs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">
                {{ translate('Delivery') }}
            </button>
        </li>
        <li class="mr-2" role="presentation">
            <button class="text-lg font-medium inline-block p-3 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="dashboard-tab" data-tabs-target="#dashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="false">
                {{ translate('Printing') }}
                @if($order->tasks->where('type', 'printing')->count() > 0)
                    <span class="ml-2 badge-info">{{ \Str::headline($order->tasks->where('type', 'printing')->first()->status) }}</span>
                @else
                <span class="ml-2 badge-info">{{ translate('Pending') }}</span>

                    @endif
            </button>
        </li>

    </ul>
</div>
<div id="myTabContent">
    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel" aria-labelledby="profile-tab">

    </div>
    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
        <div class="w-full">
            <div class="w-full pb-3 mb-2 border-b ">
                @if($order->tasks->where('type', 'printing')->count() > 0)
                    <p class="mt-1 max-w-2xl text-sm text-gray-500 flex align-center">
                        @svg('heroicon-o-check-circle', ['class' => 'inline mr-1.5 h-5 w-5 flex-shrink-0 text-green-500'])

                        {{ translate('Order was already added to the printing queue') }}
                    </p>
                @else
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        {{ translate('Current order was never added to any printing queue') }}
                    </p>
                @endif
            </div>

            @if($tasks->count() > 0)
                <ul role="list" class="divide-y divide-gray-200">
                    @foreach($tasks as $task)
                        <li>
                            <a href="{{ route('task.edit', $task->id) }}" target="_blank" class="block hover:bg-gray-50">
                                <div class="py-2">
                                    <div class="flex items-center justify-between">
                                        <p class="truncate text-sm font-medium text-indigo-600">{{ $task->name }}</p>
                                    </div>
                                    <div class="mt-2 flex flex-column sm:flex-row sm:items-center">
                                        @if ($task->status === \App\Enums\TaskStatusEnum::scoping()->value)
                                            <span class="badge-success">{{ \Str::headline($task->status) }}</span>
                                        @elseif($task->status === \App\Enums\TaskStatusEnum::backlog()->value)
                                            <span class="badge-info">{{ \Str::headline($task->status) }}</span>
                                        @elseif($task->status === \App\Enums\TaskStatusEnum::in_progress()->value)
                                            <span class="badge-danger">{{ \Str::headline($task->status) }}</span>
                                        @elseif($task->status === \App\Enums\TaskStatusEnum::review()->value)
                                            <span class="badge-purple">{{ \Str::headline($task->status) }}</span>
                                        @elseif($task->status === \App\Enums\TaskStatusEnum::done()->value)
                                            <span class="badge-info">{{ \Str::headline($task->status) }}</span>
                                        @endif

                                        <p class="flex items-center text-sm text-gray-500 ml-2">
                                            @svg('heroicon-o-calendar-days', ['class' => 'mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400'])
                                            {{ translate('Added to queue on: ') }} {{ $task->created_at->format('d M, Y H:i') }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="scale-75" style="margin-bottom: -20px; width: 125%; transform-origin: top left;">
                    <x-dashboard.orders.order-details-card :order="$order">
                    </x-dashboard.orders.order-details-card>
                </div>

                <div class="{{ $class }}" >
                    <button type="button" class="btn btn-primary w-full" wire:click="addToPrintingQueue()">
                        {{ translate('Add to print Queue') }}
                    </button>
                </div>
            @endif
        </div>
    </div>

</div>


</div>
