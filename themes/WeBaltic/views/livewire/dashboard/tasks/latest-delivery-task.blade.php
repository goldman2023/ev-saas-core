<div class="bg-white border border-gray-200 rounded-lg">
    <div class="px-3 py-3 border-b border-gray-200">
        <div class="flex justify-between items-center flex-wrap sm:flex-nowrap">
            <div class="w-full">
                <h4 class="font-semibold">{{ translate('Latest Delivery') }}</h4>
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

                    <div class="flex flex-column sm:flex-row sm:items-center mb-2">
                        <p class="flex items-center text-sm text-gray-700">
                            @svg('heroicon-o-calendar-days', ['class' => 'mr-1.5 h-5 w-5 flex-shrink-0 text-gray-600'])
                            {{ translate('Completed on: ') }} {{ $upload->created_at->format('d M, Y H:i') }}
                        </p>
                    </div>

                    <div class="w-full flex gap-x-3">
                        <a href="{{ $upload->url() }}" class="text-14 text-sky-500 hover:text-sky-600" target="_blank">{{ translate('View Document') }}</a>
                        @if(!empty($deliveryTask))
                            <a href="{{ route('task.edit', $deliveryTask->id) }}" class="text-14 text-sky-500 hover:text-sky-600" target="_blank">
                                {{ translate('Edit Task') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <x-dashboard.empty-states.no-items-in-collection
                icon="heroicon-o-circle-stack"
                title="{{ translate('No delivery document generated') }}"
                text="{{ translate('When any order reaches delivery cycle, latest delivery document will be shown here') }}"
            />
        @endif
    </div>
</div>