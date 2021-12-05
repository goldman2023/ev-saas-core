<a class="btn btn-{{ $btnType }} d-flex justify-content-center align-items-center {{ $class }}"
   @click="
    if(!processing && Number(qty) > 0) {
        processing = true; // start addToCart button processing
        $wire.emit('addToCart', model_id, model_type, qty, true);
    }"
   x-cloak
>
    <div class="align-items-center"
         :class="{'d-flex': !processing}"
         x-show="!processing" >
        @if(!empty($icon)) {{ svg($icon, ['class' => 'ev-icon__xs mr-2']) }} @endif
        <span>{{ $label }}</span>
    </div>

    <div x-show="processing">
        <div class="spinner-border text-white text-10 square-24" role="status">
            <span class="sr-only">{{ translate('Loading...') }}</span>
        </div>
    </div>
</a>
