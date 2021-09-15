<div class="specification-inner">
    @foreach ($product_attributes as $group => $attributes)
        <div class="specification-row">
            <div class="title">
                <h5>{{ $group }}</h5>
            </div>
            <ul class="list-inline specification-list">
                @foreach($attributes as $attribute)
                    @php
                        $attribute_value = $product
                            ->attributes()
                            ->where('attribute_id', $attribute->id)
                            ->first();
                    @endphp
                    @isset($attribute_value)
                        <li>
                            <label>{{ $attribute->name }}</label> 
                            <span>{{ $attribute_value->attribute_value->values; }}</span>
                        </li>
                    @endisset
                @endforeach
            </ul>
        </div>
    @endforeach
</div>
