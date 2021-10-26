<div class="pb-3">
    @if(!empty($attributes_for_variations))
        @foreach($attributes_for_variations as $attribute)
            <div class="full-width pb-2">
                <strong>{{ $attribute->name }}</strong>
                <ul class="d-flex list-group-horizontal align-items-center mb-1 mt-2 pl-0">
                    @foreach ($attribute->attribute_values as $value)
                        @php
                            $active = $current->variant[$attribute->id]['attribute_value_id'] === $value->id;
                        @endphp
                        <li class="list-group-item px-3 py-2 border rounded mr-2 pointer {{ $active ? 'active':'' }}">{{ $value->values }}</li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    @endif
</div>
