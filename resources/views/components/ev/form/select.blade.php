<div class="form-group {{ $class }}">
    @if (!empty(trim($label)))
        <label @if($id) for="{{ $id }}" @endif class="input-label">{{ $label }} {!! $required ? '<span class="text-danger">*</span>':'' !!}</label>
    @endif

    <select @if($isWired) wire:model.defer="{{ $name }}" @endif
            @if(!$isWired) wire:ignore @endif
            name="{{ $name }}"
            @if($id) id="{{ $id }}" @endif
            class="js-select2-custom custom-select @error($errorBagName) is-invalid @enderror"
            size="1" style="opacity: 0;"
            @if($multiple) multiple @endif
            data-hs-select2-options='@json($options)'
            @if($items->isEmpty() && $tags) dynamic-items @endif
            {{ $attributes }}>

        @if($items)
            @foreach($items as $key => $item)
                @php $item = is_array($item) ? (object) $item : $item; @endphp
                <option value="{{ is_object($item) ? ($item->{$valueProperty}??'') : $key }}"
                        {!! is_object($item) && !empty($item->attributes) ? $item->attributes : "" !!}
                        @if($selected == (is_object($item) ? ($item->{$valueProperty}??'') : $key)
                            ||
                            (empty($selected) && (($item->selected ?? false)  || (empty($placeholder) && $key === 0))))
                            selected
                        @endif>
                    {{ is_object($item) ? ($item->{$labelProperty}??'') : $item }}
                </option>
            @endforeach
        @endif
    </select>

    {!! $slot !!}

    @error($errorBagName)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
