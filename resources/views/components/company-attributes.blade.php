@foreach ($items as $attribute)
    <div class="bg-white shadow-sm rounded mb-1">
        <div class="fs-15 fw-600 p-3 border-bottom">
            {{ translate('Filter by') }} {{ $attribute->name }}
        </div>        
        <div class="p-3">
            @if ($attribute->type == "dropdown")
                <div class="form-group">
                    <select onchange="filter()" class="select2 form-control aiz-selectpicker" name="attribute_{{ $attribute->id }}" data-toggle="select2" data-placeholder="Choose ..." data-live-search="true">
                        <option value="" @if(isset($selected[$attribute->id]) && $selected[$attribute->id] == null) selected @endif>{{ translate('Nothing Selected') }}</option>
                        @foreach ($attribute->attribute_values as $option)
                            <option value="{{ $option->id }}" @if(isset($selected[$attribute->id]) && $selected[$attribute->id] == $option->id) selected @endif>{{ $option->values }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
            @if ($attribute->type == "checkbox")
                <div class="aiz-checkbox-list">
                    @foreach ($attribute->attribute_values as $option)
                        <label class="aiz-checkbox">
                            <input
                                type="checkbox"
                                name="attribute_{{ $attribute['id'] }}[]"
                                value="{{ $option->id }}" @if(isset($selected[$attribute->id]) && in_array($option->id, $selected[$attribute->id])) checked @endif
                                onchange="filter()"
                            >
                            <span class="aiz-square-check"></span>
                            <span>{{ $option->values }}</span>
                        </label>
                    @endforeach
                </div>
            @endif
            @if ($attribute->type == "country")
                @php 
                    $countries = App\Models\Country::where('status', 1)->get();
                @endphp
                <div class="form-group">
                    <select onchange="filter()" class="select2 form-control aiz-selectpicker" name="attribute_{{ $attribute->id }}" data-toggle="select2" data-placeholder="Choose Country ..." data-live-search="true">
                        <option value="" @if(isset($selected[$attribute->id]) && $selected[$attribute->id] == null) selected @endif>{{ translate('Nothing Selected') }}</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->code }}" @if(isset($selected[$attribute->id]) && $selected[$attribute->id] == $country->code) selected @endif>{{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
            @if ($attribute->type == "date")
                @php
                    $date_range_value = $attribute->attribute_values->min('values') . ' to ' .  Carbon\Carbon::now()->format('d-m-Y H:m');
                    if(isset($selected[$attribute->id])) $date_range_value = $selected[$attribute->id];
                @endphp
                <input 
                    type="text"
                    class="form-control aiz-date-range"
                    value="{{ $date_range_value }}" name="attribute_{{ $attribute->id }}"
                    aria-describedby="date_range"
                    placeholder="Select Date" data-time-picker="true" data-format="DD-MM-Y HH:mm"
                    data-filterable="true"
                    data-separator=" to " autocomplete="off">
            @endif
            @if ($attribute->type == "number")
                @php

                    $custom_properties = json_decode($attribute->custom_properties);
                    $min_value = $attribute->attribute_values->min('values');
                    $max_value = $attribute->attribute_values->max('values');

                    if (!is_numeric($min_value)) $min_value = $custom_properties->min_value;
                    if (!is_numeric($max_value)) $max_value = $custom_properties->max_value;

                @endphp
                <div class="aiz-range-slider">
                    <div
                        id="input-slider-range"
                        class="input-slider-range"
                        data-attribute-id="{{ $attribute->id }}"
                        data-range-value-min="@if(count($attribute->attribute_values) < 1 || $max_value == $min_value) 0 @else {{$min_value}} @endif"
                        data-range-value-max="@if(count($attribute->attribute_values) < 1) 0 @else {{$max_value}} @endif"
                    ></div>
                    <div class="row mt-2">
                        <div class="col-6">
                            <span class="range-slider-value value-low fs-14 fw-600 opacity-70"
                                @if (isset($selected[$attribute->id]) && $selected[$attribute->id][0] != null)
                                    data-range-value-low="{{ $selected[$attribute->id][0] }}"
                                @elseif(floatval($min_value) > 0 && $max_value != $min_value)
                                    data-range-value-low="{{floatval($min_value)}}"
                                @else
                                    data-range-value-low="0"
                                @endif
                                id="input-slider-range-value-low"
                            ></span>
                        </div>
                        <div class="col-6 text-right">
                            <span class="range-slider-value value-high fs-14 fw-600 opacity-70"
                                @if (isset($selected[$attribute->id]) && $selected[$attribute->id][1] != null)
                                    data-range-value-high="{{ $selected[$attribute->id][1] }}"
                                @elseif(floatval($max_value) > 0)
                                    data-range-value-high="{{floatval($max_value)}}"
                                @else
                                    data-range-value-high="0"
                                @endif
                                id="input-slider-range-value-high"
                            ></span>
                        </div>
                    </div>
                    <input type="hidden" name="attribute_{{ $attribute->id }}[]" @if(isset($selected[$attribute->id]) && $selected[$attribute->id][0] != null) value="{{ $selected[$attribute->id][0] }}" @endif>
                    <input type="hidden" name="attribute_{{ $attribute->id }}[]" @if(isset($selected[$attribute->id]) && $selected[$attribute->id][1] != null) value="{{ $selected[$attribute->id][1] }}" @endif>
                </div>
            @endif            
        </div>
    </div>
@endforeach