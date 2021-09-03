<div class="form-group">
    <label for="{{ $id }}" class="input-label">{!! $label !!} {!! $required ? '<span class="text-danger">*</span>':'' !!}</label>

    @if($icon)
        <div class="input-group @if($merge) input-group-merge @endif">
    @endif
        @if($icon && $icon_placement === 'prepend')
            <div class="input-group-prepend">
                <span class="input-group-text">
                  @svg($icon, ['class' => ''])
                </span>
            </div>
        @endif
            <input wire:model.defer="{{ $name }}" type="{{ $type }}" class="form-control {{ $class }} @error($name) is-invalid @enderror" name="{{ $name }}" id="{{ $id }}" placeholder="{{ $placeholder }}" aria-label="{{ $label }}">
        @if($icon && $icon_placement === 'append')
            <div class="input-group-append">
                <span class="input-group-text">
                  @svg($icon, ['class' => ''])
                </span>
            </div>
        @endif
    @if($icon)
        </div>
    @endif

    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
