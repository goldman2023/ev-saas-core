<div class="form-group {{ $groupclass }} {{ $quantityCounter && !$disabled ? 'js-quantity-counter input-group-quantity-counter':'' }}">
    @if(!empty($label))
        <label @if($id) for="{{ $id }}" @endif class="input-label">{!! $label !!} {!! $required ? '<span class="text-danger">*</span>':'' !!}</label>
    @endif

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

        @if($quantityCounter && !$disabled)
            <div class="js-quantity-counter input-group-quantity-counter">
        @endif
            @php $value = is_array($value) ? (object) $value : $value; @endphp
            <input @if(!empty($name)) wire:model.{{ $wireType }}="{{ $name }}" @endif
                   type="{{ $quantityCounter && !$disabled ? 'number' : $type }}"
                   class="form-control {{ $class }} @error($errorBagName) is-invalid @enderror {{ $quantityCounter && !$disabled ? 'js-result input-group-quantity-counter-control': '' }}"
                   name="{{ $name }}"
                   @if($id) id="{{ $id }}" @endif
                   @if($placeholder) placeholder="{{ $placeholder }}" @endif
                   @if(is_object($value) && isset($value->{$valueProperty}))
                        value="{{ $value->{$valueProperty} ?? '' }}"
                   @else
                        value="{{ $value }}"
                   @endif
                   aria-label="{{ $label }}"
                   @if(empty($name)) wire:ignore @endif
                   {{ $attributes }}
                   @if($disabled) disabled @endif
            >
        @if($quantityCounter && !$disabled)
                <div class="input-group-quantity-counter-toggle">
                    <a class="js-minus input-group-quantity-counter-btn" href="javascript:;">
                        <i class="tio-remove"></i>
                    </a>
                    <a class="js-plus input-group-quantity-counter-btn" href="javascript:;">
                        <i class="tio-add"></i>
                    </a>
                </div>
            </div>
        @endif

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

    @error($errorBagName)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
