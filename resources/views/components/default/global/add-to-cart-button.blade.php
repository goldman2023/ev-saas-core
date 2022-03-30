<a class="flex content-center items-center {{ $class }}"
   x-cloak
   x-data="{
    disabled: {{ $disabled ? 'true':'false' }},
    label: '{{ $label }}',
    label_not_in_stock: '{{ $labelNotInStock }}',
    addToCart() {
        if(!processing && Number(qty) > 0) {
            processing = true; // start addToCart button processing

            Livewire.find($('#cart-panel').attr('wire:id')).emit('addToCart', model_id, model_type, qty, true);
        }
    }
   }"
   :class="{'btn-outline-{{ $btnType }} pointer-events-none opacity-60': disabled, 'btn-{{ $btnType }}': !disabled}"
   @if($model->hasVariations())
    @variation-changed.window="
        if(Number($event.detail.model_id) === model_id &&
        $event.detail.model_type === model_type
        ) {
            disabled = Number($event.detail.current_stock) <= 0;
        }
    "
    @endif
    @click="addToCart()"
>
    <div class="items-center"
         :class="{'flex': !processing}"
         x-show="!processing" >

        @if(!empty($icon))
        <span x-show="!disabled" class="lh-10">
            {{ svg($icon, ['class' => 'ev-icon__xs w-[16px] h-[16px] mr-2']) }}
        </span>
        @endif

        <span x-text="disabled ? label_not_in_stock : label"></span>
    </div>

    <div x-show="processing">
        @php
            if($btnSize === 'xs') {
               $loading_class = 'w-[16px] h-[16px]';
            } else if($btnSize === 'sm') {
               $loading_class = 'w-[24px] h-[24px]';
            }
        @endphp
        <div class="spinner-border text-white text-10  {{ $loading_class }}" role="status">
        </div>
    </div>
</a>
