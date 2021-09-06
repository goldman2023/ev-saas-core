<!-- Quill -->
<div class="quill-custom">
    <label class="input-label">{!! $label !!} {!! $required ? '<span class="text-danger">*</span>':'' !!}</label>
    <div class="js-quill {{ $class }}" style="min-height: 20rem;"
         data-hs-quill-options='{
           "placeholder": "{{ $placeholder }}",
            "modules": {
              "toolbar": [
                @json($toolbar_items)
             ]
           }
          }'>
    </div>
    <input type="text" value="{{ $attributes['value'] }}" data-textarea name="{{ $name }}" style="display: none !important;" wire:model.delay="{{ $name }}"/>

    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
<!-- End Quill -->
