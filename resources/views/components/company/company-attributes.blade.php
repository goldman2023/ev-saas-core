@foreach ($items as $attribute)
    <div class="bg-white shadow-sm rounded mb-1">
        <div class="fs-15 fw-600 p-3 border-bottom">
            {{ translate('Filter by') }} {{ $attribute->name }}
        </div>        
        <div class="p-3">
            @if ($attribute->type == "dropdown")
                <div class="form-group">
                    <select class="js-custom-select custom-select" size="1" style="opacity: 0;"
                            data-hs-select2-options='{
                            "placeholder": "Nothing Selected..."
                            }'
                            onchange="filter()"
                            name="attribute_{{ $attribute->id }}">
                            <option value="-1" @if(isset($selected[$attribute->id]) && $selected[$attribute->id] == null) selected @endif>{{ translate('Nothing Selected') }}</option>
                            @foreach ($attribute->attribute_values as $option)
                                <option value="{{ $option->id }}" @if(isset($selected[$attribute->id]) && $selected[$attribute->id] == $option->id) selected @endif>{{ $option->values }}</option>
                            @endforeach
                    </select>
                </div>
            @endif
            @if ($attribute->type == "checkbox")
                <div class="form-group">
                    @foreach ($attribute->attribute_values as $option)
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox"
                                    name="attribute_{{ $attribute['id'] }}[]"
                                    onchange="filter()"
                                    class="custom-control-input"
                                    value="{{ $option->id }}" 
                                    @if(isset($selected[$attribute->id]) && in_array($option->id, $selected[$attribute->id])) checked @endif
                            >
                            <label class="custom-control-label">{{ $option->values }}</label>
                        </div>
                    @endforeach
                </div>                    
            @endif
            @if ($attribute->type == "country")
                @php 
                    $countries = App\Models\Country::where('status', 1)->get();
                @endphp
                <div class="form-group">
                    <select class="js-custom-select custom-select" size="1" style="opacity: 0;"
                            data-hs-select2-options='{
                            "placeholder": "Nothing Selected..."
                            }'
                            onchange="filter()"
                            name="attribute_{{ $attribute->id }}">
                        <option value="-1" @if(isset($selected[$attribute->id]) && $selected[$attribute->id] == null) selected @endif>{{ translate('Nothing Selected') }}</option>
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
                <div class="form-group">
                    <input type="text" 
                            class="js-daterangepicker-times form-control daterangepicker-custom-input"
                            value="{{ $date_range_value }}" 
                            name="attribute_{{ $attribute->id }}"
                            data-hs-daterangepicker-options='{
                                "timePicker": true,
                                "locale": {
                                    "format": "DD-MM-Y HH:mm",
                                    "separator": " to ",
                                    "cancelLabel": "Clear"
                                }
                            }'>
                </div>
            @endif
            @if ($attribute->type == "number")
                @php

                    $custom_properties = $attribute->custom_properties;
                    $min_value = $attribute->attribute_values->min('values');
                    $max_value = $attribute->attribute_values->max('values');

                    $from = $min_value;
                    $to = $max_value;

                    if (!is_numeric($min_value)) $min_value = $custom_properties->min_value;
                    if (!is_numeric($max_value)) $max_value = $custom_properties->max_value;

                    if (isset($selected[$attribute->id])) {
                        $range_arr = explode(';', $selected[$attribute->id]);
                        $from = $range_arr[0];
                        $to = $range_arr[1];
                    }

                @endphp
                <div class="form-group">
                    <input class="js-ion-range-slider" 
                        onchange="filter()"
                        type="text"
                        name="attribute_{{ $attribute->id }}"
                        data-hs-ion-range-slider-options='{
                            "extra_classes": "range-slider-custom range-slider-custom-grid",
                            "type": "double",
                            "hide_from_to": false,
                            "min": @if(count($attribute->attribute_values) < 1 || $max_value == $min_value) 0 @else {{$min_value}} @endif,
                            "max": @if(count($attribute->attribute_values) < 1) 0 @else {{$max_value}} @endif,
                            "from": {{floatval($from)}},
                            "to": {{floatval($to)}}
                        }'>
                    
                </div>
            @endif            
        </div>
    </div>
@endforeach