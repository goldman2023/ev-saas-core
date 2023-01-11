<div class="card mb-9 !pb-5">
    <div class="w-full">
        <div class="w-full pb-3 mb-2 border-b ">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                {{ translate('Printing Queue') }}
            </h3>

            @if($order->tasks->where('type', 'printing')->count() > 0)
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
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