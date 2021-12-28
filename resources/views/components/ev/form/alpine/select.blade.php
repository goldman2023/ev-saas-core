<div class="form-group {{ $class }}"
     x-data="{
        tags: {{ $items->isEmpty() && $tags ? 'true' : 'false' }},
     }"
     x-init="
        $.HSCore.components.HSSelect2.init($($refs['select_{{ $name }}']));

        $($refs['select_{{ $name }}']).on('select2:select', (event) => {
          {{ $name }} = event.target.value;
        });

        $watch('{{ $name }}', (value) => {
          $($refs['select_{{ $name }}']).val(value).trigger('change');
        });
 ">

    @if (!empty(trim($label)))
        <label @if($id) for="{{ $id }}" @endif class="input-label">{{ $label }} {!! $required ? '<span class="text-danger">*</span>':'' !!}</label>
    @endif

    <select
        x-model="{{ $name }}"
        x-ref="select_{{ $name }}"
        name="{{ $name }}"

        @if($id) id="{{ $id }}" @endif
        class="js-select2-custom custom-select"
        :class="{'is-invalid' : validation_errors.hasOwnProperty('{{ $name }}')}"
        size="1"

        @if($multiple) multiple @endif
        data-hs-select2-options='@json($options)'
        {{ $attributes }}
    >

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

    <div class="invalid-feedback d-block"
         x-show="validation_errors.hasOwnProperty('{{ $name }}')"
         x-text="getSafe(() => validation_errors['{{ $name }}'][0], '')"></div>
</div>
