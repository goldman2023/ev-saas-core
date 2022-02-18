<!-- Quill -->
@if($editor === 'quill')
<div class="quill-custom">
    <label class="input-label">{!! $label !!} {!! $required ? '<span class="text-danger">*</span>':'' !!}</label>
    <div class="js-quill {{ $class }} @error($errorBagName) is-invalid @enderror" style="min-height: 20rem;"
         data-hs-quill-options='{
           "placeholder": "{{ $placeholder }}",
            "modules": {
              "toolbar": [
                @json($toolbar_items)
             ]
           }
          }'>
    </div>
    <input type="text"
    value="{{ $attributes['value'] }}"
    data-textarea name="{{ $name }}" style="display: none !important;" wire:model.delay="{{ $name }}" />

    @error($errorBagName)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
<!-- End Quill -->

@elseif($editor === 'toast-ui-editor')
<!-- ToastUI Editor -->
<div class="form-group">
    <div class="toast-ui-editor-custom">
        <label class="input-label">{!! $label !!} {!! $required ? '<span class="text-danger">*</span>':'' !!}</label>

        <div class="js-toast-ui-editor {{ $class }} @error($errorBagName) is-invalid @enderror"
             @if(!empty($options)) data-ev-toastui-editor-options='@if(is_string($options)) {!! $options !!} @else @json($options) @endif' @endif
        ></div>

        <input type="text"
               value="{{ $attributes['value'] }}"
               data-textarea name="{{ $name }}" style="display: none !important;" wire:model.delay="{{ $name }}"/>

        @error($errorBagName)
        <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
</div>
<!-- End ToastUI Editor -->
@endif
<!-- -->
