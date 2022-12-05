<div class="specification-inner">

    @foreach ($product_grouped_attributes as $group_name => $group)
        <div class="specification-row">
            <div class="title">
                {{-- <h5>{{ $group->name }}</h5> --}}
            </div>

            <ul class="specification-list list-group list-group-flush p-0">
                @foreach($group->custom_attributes as $attribute)
                    @if($attribute->attribute_values->isNotEmpty() && !empty($att_values_plucked = $attribute->attribute_values->pluck('values')))
                        <li class="list-group-item py-1 border-b-1">
                            <label class="font-bold">{{ $attribute->name }}: </label>
                            <span>{{ $att_values_plucked[0] }} {{  $attribute->unit }}</span>
                            @isset($attribute->custom_properties->unit)
                                {{ $attribute->custom_properties->unit }}
                            @endisset
                        </li>
                    @endisset
                @endforeach
            </ul>
        </div>
    @endforeach
</div>
