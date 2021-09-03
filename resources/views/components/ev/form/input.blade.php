<div class="form-group {{ $groupclass }}">
    <label @if($id) for="{{ $id }}" @endif class="input-label">{!! $label !!} {!! $required ? '<span class="text-danger">*</span>':'' !!}</label>

    @if(!empty($icon) || !empty($text))
        <div class="input-group @if($merge) input-group-merge @endif">

        @if($placement === 'prepend')
            <div class="input-group-prepend">
                <span class="input-group-text">
                    @if($icon)
                        @svg($icon, ['class' => ''])
                    @elseif($text)
                        {{ $text }}
                    @endif
                </span>
            </div>
        @endif
    @endif
            <input wire:model.defer="{{ $name }}"
                   type="{{ $type }}"
                   class="form-control {{ $class }}
                   @error($name) is-invalid @enderror"
                   name="{{ $name }}"
                   @if($id) id="{{ $id }}" @endif
                   @if($placeholder) placeholder="{{ $placeholder }}" @endif
                   aria-label="{{ $label }}"
                   {{ $attributes }}
            >
    @if(!empty($icon) || !empty($text))
        @if($placement === 'append')
            <div class="input-group-append">
                <span class="input-group-text">
                  @if($icon)
                     @svg($icon, ['class' => ''])
                  @elseif($text)
                     {{ $text }}
                  @endif
                </span>
            </div>
        @endif

        </div>
    @endif

    {!! $slot !!}

    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
