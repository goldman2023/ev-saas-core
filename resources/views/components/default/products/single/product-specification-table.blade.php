<div class="specification-inner">

    @foreach ($product_grouped_attributes as $group_name => $group)
        <div class="specification-row">
            <div class="title">
                {{-- <h5>{{ $group->name }}</h5> --}}
            </div>

            <ul class="specification-list list-group list-group-flush p-0 grid-cols-2 grid gap-x-6 pl-4">
                @foreach($group->custom_attributes as $attribute)
                @if($attribute->id != 28)
                    @if($attribute->attribute_values->isNotEmpty() && !empty($att_values_plucked = $attribute->attribute_values->pluck('values')))
                        <li class="list-group-item py-1 border-b-1">
                            <label class="font-bold">{{ translate($attribute->name) }}: </label>
                            <span>{{ translate($att_values_plucked[0]) }} {{  $attribute->unit }}</span>
                            @isset($attribute->custom_properties->unit)
                                {{ $attribute->custom_properties->unit }}
                            @endisset
                        </li>
                    @endisset
                    @endif
                @endforeach
            </ul>
        </div>
    @endforeach
</div>
