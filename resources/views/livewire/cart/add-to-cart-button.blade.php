<a class="btn  d-flex justify-content-center align-items-center {{ $class }}"
   @click="
    if(!processing && Number(qty) > 0) {
        processing = true; // start addToCart button processing
        $wire.emit('addToCart', model_id, model_type, qty, true);
    }"
   x-cloak
   x-data="{
    disabled: {{ $disabled ? 'true':'false' }},
    label: '{{ $label }}',
    label_not_in_stock: '{{ $labelNotInStock }}',
   }"
   :class="{'btn-outline-{{ $btnType }} prevent-pointer-events opacity-6': disabled, 'btn-{{ $btnType }}': !disabled}"
   @if($model->hasVariations())
    @variation-changed.window="
    if(Number($event.detail.model_id) === model_id &&
       $event.detail.model_type === model_type
    ) {
        disabled = Number($event.detail.current_stock) <= 0;
    }
    "
    @endif
>
    <div class="align-items-center"
         :class="{'d-flex': !processing}"
         x-show="!processing" >

        @if(!empty($icon))
        <span x-show="!disabled" class="lh-10">
            {{ svg($icon, ['class' => 'ev-icon__xs mr-2']) }}
        </span>
        @endif

        <span x-text="disabled ? label_not_in_stock : label"></span>
    </div>

    <div x-show="processing">
        <div class="spinner-border text-white text-10 square-24" role="status">
            <span class="sr-only">{{ translate('Loading...') }}</span>
        </div>
    </div>
</a>
