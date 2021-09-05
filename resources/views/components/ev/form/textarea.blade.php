<div class="form-group">
    <label @if($id) for="{{ $id }}" @endif class="input-label">{{ $label }} {!! $required ? '<span class="text-danger">*</span>':'' !!}</label>
    <textarea name="{{ $name }}"
              wire:model.defer="{{ $name }}"
              class="form-control"
              @if($id) id="{{ $id }}" @endif
              @if($placeholder) placeholder="{{ $placeholder }}" @endif
              {{ $attributes }}>
    </textarea>

    {!! $slot !!}

    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
