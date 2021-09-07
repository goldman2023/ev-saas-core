<div class="form-group {{ $groupclass }}">
    <label @if($id) for="{{ $id }}" @endif class="input-label">{!! $label !!} {!! $required ? '<span class="text-danger">*</span>':'' !!}</label>

    @if(!empty($icon))
        <div @if($id) id="{{ $id }}" @endif
             class="js-flatpickr flatpickr-custom input-group input-group-merge"
             data-hs-flatpickr-options='@if(is_string($options)) {!! $options !!} @else @json($options) @endif'>

        @if($placement === 'prepend')
            <div class="input-group-prepend" data-toggle>
                <span class="input-group-text">
                    @if($icon)
                        @svg($icon, ['style' => 'width:16px;'])
                    @endif
                </span>
            </div>
        @endif
    @endif
            @php $value = is_array($value) ? (object) $value : $value; @endphp
            <input name="{{ $name }}"
                   type="text"
                   class="@if(empty($icon)) js-flatpickr form-control flatpickr-custom @else flatpickr-custom-form-control form-control @endif @error($errorBagName) is-invalid @enderror"
                   @if(empty($icon) && $id) id="{{ $id }}" @endif
                   @if($placeholder) placeholder="{{ $placeholder }}" @endif
                   @if(empty($icon)) data-hs-flatpickr-options='@if(is_string($options)) {!! $options !!} @else @json($options) @endif' @endif
                   @if(is_object($value) && isset($value->{$valueProperty}))
                        value="{{ $value->{$valueProperty} ?? '' }}"
                   @else
                        value="{{ $value }}"
                   @endif
                   data-input
                   {{ $attributes }}>

    @if(!empty($icon))
        </div>
    @endif

    {!! $slot !!}

    @error($errorBagName)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
