<!-- Toggle Switch -->
<div class="d-flex flex-col">
    <div class="d-flex align-items-center {{ $class }}">
        @if($prependText)
            <span class="font-size-1 text-muted">{{ $prependText }}</span>
        @endif
            <label class="toggle-switch mr-2" @if($id) for="{{ $id }}" @endif>
                <input type="checkbox"
                       name="{{ $name }}"
                       wire:model="{{ $name }}"
                       class="js-toggle-switch toggle-switch-input"
                       @if($id) id="{{ $id }}" @endif
                       @if($selected) selected @endif
                       data-hs-toggle-switch-options='@json($options)'
                       {{ $attributes }}>
                <span class="toggle-switch-label">
                  <span class="toggle-switch-indicator"></span>
                </span>
            </label>
        @if($appendText)
            <span class="font-size-1 text-muted">{{ $appendText }}</span>
        @endif
    </div>

    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
<!-- End Toggle Switch -->
