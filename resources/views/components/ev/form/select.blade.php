<div class="form-group {{ $class }}">
    <label @if($id) for="{{ $id }}" @endif class="input-label">{{ $label }} {!! $required ? '<span class="text-danger">*</span>':'' !!}</label>
    <select @if($id) id="{{ $id }}" @endif class="js-select2-custom custom-select" name="{{ $name }}" size="1" style="opacity: 0;"
            @if($multiple) multiple @endif
            data-hs-select2-options='@json($options)'>
        @if($placeholder || ($items->isEmpty() && $tags)) <option label="empty"></option> @endif

        @if($items)
            @foreach($items as $key => $item)
                <option value="{{ is_object($item) ? ($item->{$value_property}??'') : $key }}">{{ is_object($item) ? ($item->{$label_property}??'') : $item }}</option>
            @endforeach
        @endif
    </select>
    {!! $slot !!}
</div>
