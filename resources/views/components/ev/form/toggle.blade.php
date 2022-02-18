<!-- Toggle Switch -->
<div class="d-flex flex-col">
    <div class="d-flex align-items-center {{ $class }}">
        @if($prependText)
            <span class="font-size-1 text-muted">{{ $prependText }}</span>
        @endif
            <label class="toggle-switch mr-2 {{ $classLabel }}" @if($id) for="{{ $id }}" @endif for="toggle-{{ $name }}">
                <input type="checkbox"
                       name="{{ $name }}"
                       id="toggle-{{ $name }}"
                       wire:model.defer="{{ $name }}"
                       class="js-toggle-switch toggle-switch-input"
                       @if($id) id="{{ $id }}" @endif
                       @if($selected) selected @endif
                       data-hs-toggle-switch-options='@json($options)'
                       {{ $attributes }}>
                <span class="toggle-switch-label">
                  <span class="toggle-switch-indicator"></span>
                </span>

                @if($appendText)
                    <span class="font-size-1 text-muted ml-2">{{ $appendText }}</span>
                @endif
            </label>
    </div>

    @error($errorBagName)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
<!-- End Toggle Switch -->
