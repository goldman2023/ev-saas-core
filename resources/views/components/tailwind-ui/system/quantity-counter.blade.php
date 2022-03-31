@if($mini)
    <div class="">
        <div
            @if($id) id="{{ $id }}" @endif
            class="inline-flex flex-row items-center justify-center"
             x-data="{}"
             x-ref="js-quantity-counter"
        >
            <input class="form-standard py-0 px-1 text-center"
                   type="number"
                   min="0"
                   x-ref="quantity-counter-input-{{ $model->id }}"
                   x-model.lazy="qty">
        </div>
    </div>
@else

<div class="flex items-center rounded-lg bg-gray-200 justify-start {{ $class }}" 
        x-data="{
            disabled: {{ $disabled ? 'true':'false' }},
        }"
        :class="{'pointer-events-none opacity-60': disabled}"
        @if($model->hasVariations())
            @variation-changed.window="
                if(Number($event.detail.model_id) === model_id &&
                    $event.detail.model_type === model_type ) {
                    disabled = Number($event.detail.current_stock) <= 0;
                }
            "
        @endif
        x-init="$watch('qty', function(value) { if(Number(value) < 0) { qty = 0; } })"
>
    <div class="py-3 px-3 cursor-pointer select-none" @click="qty--">
        @svg('lineawesome-minus-solid', ['class' => 'w-4 h-4'])
    </div>
    <div class="min-w-[60px] h-full" x-ref="js-quantity-counter">
        <input class="w-full border-none shadow-none h-full text-center max-w-[60px] bg-transparent"
                   type="text"
                   min="0"
                   x-ref="quantity-counter-input-{{ $model->id }}"
                   x-model="qty">
    </div>
    <div class="py-3 px-3 cursor-pointer select-none" @click="qty++">
        @svg('lineawesome-plus-solid', ['class' => 'w-4 h-4'])
    </div>
</div>
@endif
