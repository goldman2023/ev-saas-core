@if ($attribute_value)
    <label>{{ $attribute->name }}</label>
    <span>{{ $attribute_value->attribute_value->values }}</span>
@endif

@if(isAdmin())
    edit
@endif
