<div class="form-group">
    <label @if($id) for="{{ $id }}" @endif class="input-label">{{ $label }} {!! $required ? '<span class="text-danger">*</span>':'' !!}</label>
    <textarea name="{{ $name }}"
              wire:model.defer="{{ $name }}"
              class="form-control @error($errorBagName) is-invalid @enderror"
              @if(!empty($max) && ctype_digit($max)) max="{{ $max }}" @endif
              @if($id) id="{{ $id }}" @endif
              @if($placeholder) placeholder="{{ $placeholder }}" @endif
              {{ $attributes }}>
    </textarea>

    {!! $slot !!}

    @error($errorBagName)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
