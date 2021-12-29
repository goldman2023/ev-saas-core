@if($mini)
    <div class="">
        <div
            @if($id) id="{{ $id }}" @endif
            class="js-quantity-counter d-inline-flex flex-row align-items-center justify-content-center"
             x-data="{

             }"
             x-ref="js-quantity-counter"
             x-init="$nextTick(() => { (new window.EV.form.HSQuantityCounter()).init($($el)); });"
        >

            <a class="js-minus btn square-20 btn-icon btn-outline-secondary rounded-circle" href="javascript:;">
                <i class="tio-remove text-12-i"></i>
            </a>

            <input class="js-result form-control h-auto border-0 py-0 px-1 text-center"
                   type="number"
                   min="0"
                   x-ref="quantity-counter-input-{{ $model->id }}"
                    {{-- TODO: .lazy does not trigger change of data on input change from quantity-counter js. Think of a solution that will support both 1) input manual change, 2) quantity-counter +/- change --}}
                   x-model.number="qty">

            <a class="js-plus btn square-20 btn-icon btn-outline-secondary rounded-circle" href="javascript:;">
                <i class="tio-add text-12-i"></i>
            </a>

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
         x-data="{

         }"
         x-ref="js-quantity-counter"
         x-init="(new window.EV.form.HSQuantityCounter()).init($($el));"
    >

        <div class="col-7">
            <small class="d-block text-body font-weight-bold">{{ translate('Select quantity') }}</small>

            <input class="js-result form-control h-auto border-0 rounded-lg p-0"
                   type="text"
                   min="0"
                   x-ref="quantity-counter-input-{{ $model->id }}"
                   x-model="qty">
        </div>

        <div class="col-5 text-right">
            <a class="js-minus btn btn-xs btn-icon btn-outline-secondary rounded-circle" href="javascript:;">
                <i class="tio-remove"></i>
            </a>
            <a class="js-plus btn btn-xs btn-icon btn-outline-secondary rounded-circle" href="javascript:;">
                <i class="tio-add"></i>
            </a>
        </div>
    </div>
</div>
@endif
