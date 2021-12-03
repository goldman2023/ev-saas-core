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

        @if($quantityCounter)
            <div class="js-quantity-counter input-group-quantity-counter">
        @endif

            <input
                x-model="{{ $name }}"
                type="{{ $quantityCounter && !$disabled ? 'number' : $type }}"
                class="form-control {{ $class }} {{ $quantityCounter && !$disabled ? 'js-result input-group-quantity-counter-control': '' }}"
                :class="{'is-invalid' : validation_errors.hasOwnProperty('{{ $name }}')}"
                name="{{ $name }}"
                @if($id) id="{{ $id }}" @endif
                @if($placeholder) placeholder="{{ $placeholder }}" @endif
                aria-label="{{ $label }}"
                @if($disabled) disabled @endif
                {{ $attributes }}
            >

        @if($quantityCounter)
                <div class="input-group-quantity-counter-toggle">
                    <a class="js-minus input-group-quantity-counter-btn {{ $disabled ? 'd-none':'' }}" href="javascript:;">
                        <i class="tio-remove"></i>
                    </a>
                    <a class="js-plus input-group-quantity-counter-btn {{ $disabled ? 'd-none':'' }}" href="javascript:;">
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

    <div class="invalid-feedback d-block"
         x-show="validation_errors.hasOwnProperty('{{ $name }}')"
         x-text="getSafe(() => validation_errors['{{ $name }}'][0], '')">
    </div>
</div>
