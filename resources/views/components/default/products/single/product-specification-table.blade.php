<div class="specification-inner">

    @foreach ($product_grouped_attributes as $group_name => $group)
        <div class="specification-row mt-3">
            <div class="title">
                <h5>{{ $group->name }}</h5>
            </div>

            <ul class="specification-list list-group list-group-flush">
                @foreach($group->custom_attributes as $attribute)
                    @if($attribute->attribute_values->isNotEmpty() && !empty($att_values_plucked = $attribute->attribute_values->pluck('values')))
                        <li class="list-group-item">
                            <label>{{ $attribute->name }}</label>
                            <span>{{ $att_values_plucked->join(',') }}</span>
                        </li>
                    @endisset
                @endforeach
            </ul>
        </div>
    @endforeach
</div>
