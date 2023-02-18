@if($mini)
    <div
        @if($id) id="{{ $id }}" @endif
        class="inline-flex flex-row items-center justify-center"
        x-data="{
            disabled: @js($disabled),
        }"
        x-ref="quantity-counter-mini-input-{{ $model->id }}"
        x-init="$watch('{{ $qtyField }}', function(value) { if(Number(value) < 0) { {{ $qtyField }} = 0; } })"
        :class="{'pointer-events-none opacity-60': disabled}"
        @if(method_exists($model, 'hasVariations') && $model?->hasVariations() ?? false)
            @variation-changed.window="
                if(Number($event.detail.model_id) === model_id &&
                    $event.detail.model_type === model_type ) {
                    disabled = Number($event.detail.current_stock) <= 0;
                }
            "
        @endif
    >
        <div class="flex items-center space-x-3">
            <button @click="{{ $qtyField }}--" class="inline-flex items-center p-1 text-sm font-medium text-gray-500 bg-white rounded-full border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-2 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
                @svg('heroicon-o-minus', ['class' => 'w-4 h-4'])
            </button>
            <div>
                <input class="bg-gray-50 w-16 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block px-2.5 py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    type="number"
                    min="0"
                    x-ref="quantity-counter-input-{{ $model->id }}"
                    x-model.lazy="{{ $qtyField }}">
            </div>
            <button @click="{{ $qtyField }}++" class="inline-flex items-center p-1 text-sm font-medium text-gray-500 bg-white rounded-full border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-2 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
                @svg('heroicon-o-plus', ['class' => 'w-4 h-4'])
            </button>
        </div>
    </div>
@else

    <div class="flex items-center rounded-lg bg-gray-200 justify-start {{ $class }}" 
            x-data="{
                disabled: @js($disabled),
            }"
            :class="{'pointer-events-none opacity-60': disabled}"
            @if(method_exists($model, 'hasVariations') && $model?->hasVariations() ?? false)
                @variation-changed.window="
                    if(Number($event.detail.model_id) === model_id &&
                        $event.detail.model_type === model_type ) {
                        disabled = Number($event.detail.current_stock) <= 0;
                    }
                "
            @endif
            x-init="$watch('{{ $qtyField }}', function(value) { if(Number(value) < 0) { {{ $qtyField }} = 0; } })"
    >
        <div class="py-3 px-3 cursor-pointer select-none" @click="{{ $qtyField }}--">
            @svg('lineawesome-minus-solid', ['class' => 'w-4 h-4'])
        </div>
        <div class="min-w-[60px] h-full">
            <input class="w-full border-none shadow-none h-full text-center max-w-[60px] bg-transparent"
                type="text"
                min="0"
                x-ref="quantity-counter-input-{{ $model->id }}"
                x-model.lazy="{{ $qtyField }}">
        </div>
        <div class="py-3 px-3 cursor-pointer select-none" @click="{{ $qtyField }}++">
            @svg('lineawesome-plus-solid', ['class' => 'w-4 h-4'])
        </div>
    </div>
@endif
