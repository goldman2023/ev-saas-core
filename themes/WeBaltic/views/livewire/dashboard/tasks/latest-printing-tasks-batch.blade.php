<div class="bg-white border border-gray-200 rounded-lg">
    <div class="px-3 py-3 border-b border-gray-200">
        <div class="flex justify-between items-center flex-wrap sm:flex-nowrap">
            <div class="w-full">
                <h4 class="font-semibold">{{ translate('Latest Batch') }}</h4>
            </div>
        </div>
    </div>
    <div class="px-3 py-3 sm:px-3" >
        @if(!empty($upload))
            <div class="block hover:bg-gray-50">
                <div class="w-full">
                    <div class="flex items-center justify-between mb-2">
                        <a href="{{ $upload->url() }}" target="_blank" class="truncate text-sm font-medium text-indigo-600">
                            {{ $upload->file_original_name }}
                        </a>
                    </div>

                    {{-- Tasks --}}
                    <div class="w-full flex flex-col sm:flex-row items-start sm:items-center gap-x-2 text-14 mb-2">
                        <span class="flex items-center gap-x-1">
                            {{ translate('Tasks') }} ({{ $tasks?->count() ?? '?' }}):
                        </span>
                        @if($tasks->isNotEmpty())
                            @foreach($tasks as $index => $task)
                                <a href="{{ route('task.edit', $task->id) }}" target="_blank" class="text-blue-600">
                                    #{{ $task->id }}@if($index !== $tasks->count() - 1)<span class="text-gray-900">,</span>@endif
                                </a>
                            @endforeach
                        @endif
                    </div>

                    {{-- Orders --}}
                    <div class="w-full flex flex-col sm:flex-row items-start sm:items-center gap-x-2 text-14 mb-2">
                        <span class="flex items-center gap-x-1">
                            {{ translate('Orders') }} ({{ $orders?->count() ?? '?' }}):
                        </span>
                        @if($orders->isNotEmpty())
                            @foreach($orders as $index => $order)
                                <a href="{{ route('order.edit', $order->id) }}" target="_blank" class="text-blue-600">
                                    #{{ $order->id }}@if($index !== $orders->count() - 1)<span class="text-gray-900">,</span>@endif
                                </a>
                            @endforeach
                        @endif
                    </div>

                    <div class="flex flex-column sm:flex-row sm:items-center mb-2">
                        <p class="flex items-center text-sm text-gray-700">
                            @svg('heroicon-o-calendar-days', ['class' => 'mr-1.5 h-5 w-5 flex-shrink-0 text-gray-600'])
                            {{ translate('Completed on: ') }} {{ $upload->created_at->format('d M, Y H:i') }}
                        </p>
                    </div>

                    <div class="w-full text-right">
                        <a href="{{ $upload->url() }}" target="_blank" class="btn-primary !text-14 !py-1.5 !px-3">
                            @svg('heroicon-m-link', ['class' => 'w-5 h-5 mr-2'])
                            {{ translate('View PDF') }}
                        </a>
                    </div>
                </div>
            </div>
        @else
            <x-dashboard.empty-states.no-items-in-collection
                icon="heroicon-o-circle-stack"
                title="{{ translate('No printing batches yet') }}"
                text="{{ translate('Run `Print labels` action to see latest printing batch here') }}"
            />
        @endif
    </div>
</div>