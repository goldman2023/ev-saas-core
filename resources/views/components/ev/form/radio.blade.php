@if($items)
    @props(array_keys($items))
@endif

<div class="form-group" data-component-name="{{ $name }}">
    <label class="input-label">{!! $label !!} {!! $required ? '<span class="text-danger">*</span>':'' !!}</label>

    @if($items)
        @php $i = 0; @endphp
        @foreach($items as $key => $label)
            @if($style === 'vanilla')
                <div class="form-control mb-2">
                    <div class="custom-control custom-radio">
                        <input wire:model.defer="{{ $name }}"
                               type="radio"
                               class="custom-control-input"
                               name="{{ $name }}"
                               id="radio-{{ $key }}-{{ Str::slug($label,'-') }}"
                               @if($key === $value || (empty($value) && $i === 0)) checked @endif
                               value="{{ $key }}">
                        <label class="custom-control-label" for="radio-{{ $key }}-{{ Str::slug($label,'-') }}">{{ $label }}</label>
                    </div>
                </div>
                @if(isset(${$key}) && !empty(${$key}))
                    <div data-slot-name="{{ $key }}">
                        {!! ${$key} !!}
                    </div>
                @endif
            @endif

            @php $i++; @endphp
        @endforeach
    @endif

    {!! $slot !!}

    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror

    <script>
        $(function() {
            $('[data-component-name="{{ $name }}"] [type="radio"]').change(function(event) {
                if($(this).is(':checked')) {
                    // hide all other
                    $('[data-component-name="{{ $name }}"] [type="radio"]').each(function(index, radio) {
                        $('div[data-slot-name="'+$(radio).val()+'"]').children().first().addClass('d-none');
                    });

                    // Activate the selected
                    $('div[data-slot-name="'+$(this).val()+'"]').children().first().removeClass('d-none');
                }
            });
        });
    </script>
</div>
