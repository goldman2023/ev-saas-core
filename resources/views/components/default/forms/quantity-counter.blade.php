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
<div class="border rounded-lg py-2 px-3 my-2"
    x-data="{
        disabled: {{ $disabled ? 'true':'false' }},
    }"
    :class="{'prevent-pointer-events opacity-6': disabled}"
     @if($model->hasVariations())
         @variation-changed.window="
             if(Number($event.detail.model_id) === model_id &&
                $event.detail.model_type === model_type ) {
                disabled = Number($event.detail.current_stock) <= 0;
             }
         "
     @endif
>
    <div
        @if($id) id="{{ $id }}" @endif
        class="js-quantity-counter row align-items-center"
         x-data="{}"
         x-ref="js-quantity-counter"
    >

        <div class="col-7">
            <small class="d-block text-body font-weight-bold">{{ translate('Select quantity') }}</small>

            <input class="js-result form-control h-auto border-0 rounded-lg p-0"
                   type="text"
                   min="0"
                   x-ref="quantity-counter-input-{{ $model->id }}"
                   x-model="qty">
        </div>
    </div>
</div>
@endif
