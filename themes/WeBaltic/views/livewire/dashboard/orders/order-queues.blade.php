<div class="card mb-9 !p-4 !pt-2">
    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab"
            data-tabs-toggle="#order-queues-tabs-content" role="tablist">
            <li class="mr-2" role="presentation">
                <button class="inline-block font-medium text-lg p-3 border-b-2 rounded-t-lg"
                    id="order-queues-tab-delivery" data-tabs-target="#order-queues-tab-delivery-content" type="button"
                    role="tab" aria-selected="false">
                    {{ translate('Delivery') }}

                    @if($order->tasks->where('type', 'delivery')->count() > 0)


                    <span class="ml-2 badge-success">
                        <svg class="h-2 w-2 text-green-800" fill="currentColor" viewBox="0 0 8 8">
                            <circle cx="4" cy="4" r="3" />
                        </svg>
                        <span class="sr-only">
                            {{ \Str::headline($order->tasks->where('type',
                            'delivery')->first()->status) }}
                        </span>
                    </span>
                    @endif
                </button>
            </li>
            <li class="mr-2" role="presentation">
                <button
                    class="text-lg font-medium inline-block p-3 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                    id="order-queues-tab-printing" data-tabs-target="#order-queues-tab-printing-content" type="button"
                    role="tab" aria-selected="false">
                    {{ translate('Printing') }}

                    @if($order->tasks->where('type', 'printing')->count() > 0)
                    <span class="ml-2 badge-info">
                        <svg class="h-2 w-2 text-blue-800" fill="currentColor" viewBox="0 0 8 8">
                            <circle cx="4" cy="4" r="3" />
                        </svg>

                        <span class="hidden">
                            {{ \Str::headline($order->tasks->where('type', 'printing')->first()->status) }}
                        </span>
                    </span>
                    @endif
                </button>
            </li>

        </ul>
    </div>
    <div id="order-queues-tabs-content">
        {{-- Delivery Queues --}}
        <div class="p-2 hidden rounded-lg bg-gray-50 dark:bg-gray-800" id="order-queues-tab-delivery-content"
            role="tabpanel">
            <div class="w-full flex flex-col">
                @if(!empty($deliveryTask))
                <ul role="list" class="divide-y divide-gray-200 pb-1">
                    <li>
                        <a href="{{ route('task.edit', $deliveryTask->id) }}" target="_blank"
                            class="block hover:bg-gray-50">
                            <div class="py-2">
                                <div class="flex items-center justify-between">
                                    <p class="truncate text-sm font-medium text-indigo-600">{{ $deliveryTask->name }}
                                    </p>
                                </div>
                                <div class="mt-2 flex flex-column sm:flex-row sm:items-center">
                                    @if ($deliveryTask->status === \App\Enums\TaskStatusEnum::scoping()->value)
                                    <span class="badge-dark">{{ \Str::headline($deliveryTask->status) }}</span>
                                    @elseif($deliveryTask->status === \App\Enums\TaskStatusEnum::backlog()->value)
                                    <span class="badge-info">{{ \Str::headline($deliveryTask->status) }}</span>
                                    @elseif($deliveryTask->status === \App\Enums\TaskStatusEnum::in_progress()->value)
                                    <span class="badge-warning">{{ \Str::headline($deliveryTask->status) }}</span>
                                    @elseif($deliveryTask->status === \App\Enums\TaskStatusEnum::review()->value)
                                    <span class="badge-purple">{{ \Str::headline($deliveryTask->status) }}</span>
                                    @elseif($deliveryTask->status === \App\Enums\TaskStatusEnum::done()->value)
                                    <span class="badge-success">{{ \Str::headline($deliveryTask->status) }}</span>
                                    @endif

                                    <p class="flex items-center text-sm text-gray-500 ml-2">
                                        @svg('heroicon-o-calendar-days', ['class' => 'mr-1.5 h-5 w-5 flex-shrink-0
                                        text-gray-400'])
                                        {{ translate('Added to queue on: ') }} {{ $deliveryTask->created_at->format('d
                                        M, Y H:i') }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
                <div class="w-full flex gap-x-3">
                    @if(!empty($deliveryPDF))
                    <a href="{{ $deliveryPDF->url() }}" class="text-14 text-sky-500 hover:text-sky-600"
                        target="_blank">{{ translate('View Document') }}</a>
                    @endif
                    <a href="{{ route('task.edit', $deliveryTask->id) }}"
                        class="text-14 text-sky-500 hover:text-sky-600" target="_blank">{{ translate('Edit Task') }}</a>
                </div>
                @else
                <div class="w-full">
                    <p class="p-2 max-w-2xl text-sm text-gray-500 font-semibold">
                        {{ translate('When this order reaches `Delivery` cycle step, Task and delivery PDF will be
                        displayed here.') }}
                    </p>
                </div>
                @endif
            </div>
        </div>

        {{-- Printing Queues --}}
        <div class="hidden rounded-lg bg-gray-50 dark:bg-gray-800" id="order-queues-tab-printing-content"
            role="tabpanel">
            <div class="w-full">
                <div class="w-full pb-3 mb-2 border-b ">
                    @if($order->tasks->where('type', 'printing')->count() > 0)
                    <p class="p-2 mt-1 max-w-2xl text-sm text-gray-500 font-semibold flex align-center">
                        @svg('heroicon-o-check-circle', ['class' => 'inline mr-1.5 h-5 w-5 flex-shrink-0
                        text-green-500'])
                        {{ translate('Order was already added to the printing queue') }}
                    </p>
                    @else
                    <p class="p-2 max-w-2xl text-sm text-gray-500 font-semibold">
                        {{ translate('Current order was never added to any printing queue') }}
                    </p>
                    @endif
                </div>

                @if($order->tasks->where('type', 'printing')->count() > 0)
                <ul role="list" class="divide-y divide-gray-200">
                    @foreach($order->tasks->where('type', 'printing') as $task)
                    <li>
                        <a href="{{ route('tasks.index', $task->id) }}" target="_blank" class="block hover:bg-gray-50">
                            <div class="py-2">
                                <div class="flex items-center justify-between">
                                    <p class="truncate text-sm font-medium text-indigo-600">{{ $task->name }}</p>
                                </div>
                                <div class="mt-2 flex flex-column sm:flex-row sm:items-center">
                                    @if ($task->status === \App\Enums\TaskStatusEnum::scoping()->value)
                                    <span class="badge-dark">{{ \Str::headline($task->status) }}</span>
                                    @elseif($task->status === \App\Enums\TaskStatusEnum::backlog()->value)
                                    <span class="badge-info">{{ \Str::headline($task->status) }}</span>
                                    @elseif($task->status === \App\Enums\TaskStatusEnum::in_progress()->value)
                                    <span class="badge-warning">{{ \Str::headline($task->status) }}</span>
                                    @elseif($task->status === \App\Enums\TaskStatusEnum::review()->value)
                                    <span class="badge-purple">{{ \Str::headline($task->status) }}</span>
                                    @elseif($task->status === \App\Enums\TaskStatusEnum::done()->value)
                                    <span class="badge-success">{{ \Str::headline($task->status) }}</span>
                                    @endif

                                    <p class="flex items-center text-sm text-gray-500 ml-2">
                                        @svg('heroicon-o-calendar-days', ['class' => 'mr-1.5 h-5 w-5 flex-shrink-0
                                        text-gray-400'])
                                        {{ translate('Added to queue on: ') }} {{ $task->created_at->format('d M, Y
                                        H:i') }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    </li>
                    @endforeach
                </ul>
                @else
                <div class="bg-white scale-75" style="margin-bottom: -20px; width: 125%; transform-origin: top left;">
                    <x-dashboard.orders.order-details-card :order="$order">
                    </x-dashboard.orders.order-details-card>
                </div>

                <div class="{{ $class }}">
                    <button type="button" class="btn btn-primary w-full" wire:click="addToPrintingQueue()">
                        {{ translate('Add to print Queue') }}
                    </button>
                </div>
                @endif
            </div>
        </div>

    </div>
</div>
