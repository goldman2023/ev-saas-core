<div class="form-group">
    <label class="input-label">{!! $label !!} {!! $required ? '<span class="text-danger">*</span>':'' !!}</label>

    @if($items)
        @foreach($items as $key => $label)
            @if($style === 'vanilla')
            <div class="form-control mb-2">
                <div class="custom-control custom-checkbox">
                    <input wire:model.defer="{{ $name }}"
                           type="checkbox"
                           id="checkbox-{{ $key }}-{{ Str::slug($label,'-') }}"
                           class="custom-control-input"
                           name="{{ $name }}@if(count($items) > 1)[]@endif"
                           value="{{ $key }}"
                           @if($key == $value) checked @endif>
                    <label class="custom-control-label" for="checkbox-{{ $key }}-{{ Str::slug($label,'-') }}">{{ $label }}</label>
                </div>
            </div>
            @endif
        @endforeach
    @endif

    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
