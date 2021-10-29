<div class="specification-inner">
    @foreach ($product_attributes as $group => $attributes)
        <div class="specification-row">
            <div class="title">
                <h5>{{ $group }}</h5>
            </div>
            <ul class="specification-list list-group list-group-flush">
                @foreach($attributes as $attribute)
                    @php
                        $attribute_value = $product
                            ->attributes()
                            ->where('attribute_id', $attribute->id)
                            ->first();
                    @endphp
                    @isset($attribute_value)
                        <li class="list-group-item">
                            <label>{{ $attribute->name }}</label>
                            <span>{{ $attribute_value->attribute_value->values; }}</span>
                        </li>
                    @endisset
                @endforeach
            </ul>
        </div>
    @endforeach
</div>
