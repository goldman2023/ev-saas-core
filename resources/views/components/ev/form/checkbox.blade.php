@if($items)
    @props(array_keys($items))
@endif

<div class="form-group" data-component-name="{{ $name }}">
    <label class="input-label">{!! $label !!} {!! $required ? '<span class="text-danger">*</span>':'' !!}</label>

    @if($items)
        @foreach($items as $key => $item)
            @php
                $item = is_array($item) ? (object) $item : $item;
                $id = 'checkbox-'.$key.'-'.Str::slug((is_object($item) ? ($item->{$labelProperty}??'') : $item),'-');
            @endphp

            @if($style === 'vanilla')
                <div class="form-control mb-2">
                    <div class="custom-control custom-checkbox">
                        <input wire:model.{{ $wireType }}="{{ $name.($appendToName ? '.'.$key.'.'.$valueProperty : '') }}"
                               type="checkbox"
                               id="{{ $id }}"
                               data-key="{{ $key }}"
                               class="custom-control-input @error($errorBagName) is-invalid @enderror"
                               name="{{ $name }}@if(count($items) > 1)[]@endif"
                               @if(!empty($value) || !empty($valueProperty)) value="{{ is_object($item) ? ($item->{$valueProperty}??'') : $key }}" @endif
                               @if((!is_object($item) && $key === $value) || (is_object($item) && $item->selected)) checked @endif
                               {{ $attributes }}>

                        <label class="custom-control-label" for="{{ $id }}">
                            {{ is_object($item) ? ($item->{$labelProperty}??'') : $item }}
                        </label>
                    </div>
                </div>
            @endif

            @if(isset(${$key}) && !empty(${$key}))
                <div data-slot-name="{{ $key }}">
                    {!! ${$key} !!}
                </div>
            @endif
        @endforeach
    @endif

    @error($errorBagName)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror

    <script>
        $(function() {
            $('[data-component-name="{{ $name }}"] [type="checkbox"]').off().on('change', function(event) {
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
