<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{ translate('Product Data') }}</h5>
    </div>
    <div class="card-body">
        <div class="customer_choice_options" id="customer_choice_options">
            @foreach ($product_attributes as $attribute)
                <div class="form-group row">
                    @if ($attribute->type == 'number')
                        @php
                            $value = '';
                            if ($product->attributes()->where('attribute_id', $attribute->id)->first() != null) {
                                $value = $product->attributes()->where('attribute_id', $attribute->id)->first()->attribute_value->values;
                            }

                            if ($attribute->custom_properties === null) {
                            }
                            $custom_properties = json_decode($attribute->custom_properties);

                        @endphp

                        @isset($custom_properties->min_value)
                            <label
                                class="col-lg-3 col-from-label">{{ $attribute->name . ' (' . $custom_properties->min_value . ' - ' . $custom_properties->max_value . ')' }}</label>
                        @else
                            <label class="col-lg-3 col-from-label">{{ $attribute->name }}</label>

                        @endif
                    @else
                        <label class="col-lg-3 col-from-label">{{ $attribute->name }}</label>
                @endif
                <div class="col-lg-8">
                    @if ($attribute->type == 'dropdown')
                        <select name="{{ $attribute->id }}" id="{{ 'dropdown_' . $attribute->id }}"
                            class="form-control aiz-selectpicker" data-selected-text-format="count"
                            data-live-search="true" data-placeholder="{{ translate('Choose Attributes') }}">
                            @foreach ($attribute->attribute_values as $option)
                                <option value="{{ $option->id }}" @if (in_array($option->id, $product->attributes()->pluck('attribute_value_id')->toArray())) selected @endif>
                                    {{ $option->getTranslation('name') }}</option>
                            @endforeach
                        </select>
                    @endif
                    @if ($attribute->type == 'checkbox')
                        <input type="hidden" name="{{ $attribute->id }}" />
                        <div class="aiz-checkbox-list">
                            @foreach ($attribute->attribute_values as $option)
                                <label class="aiz-checkbox">
                                    <input type="checkbox" name="{{ $attribute->id }}[]"
                                        value="{{ $option->id }}"
                                        @if (in_array($option->id, $product->attributes()->where('attribute_id', $attribute->id)->pluck('attribute_value_id')->toArray())) checked @endif>
                                    <span class="aiz-square-check"></span>
                                    <span>{{ $option->values }}</span>
                                </label>
                            @endforeach
                        </div>
                    @endif
                    @if ($attribute->type == 'plain_text' || $attribute->type == 'date')
                        @php
                            $value = '';
                            if ($product->attributes()->where('attribute_id', $attribute->id)->first() != null) {
                                $value = $product->attributes()->where('attribute_id', $attribute->id)->first()->attribute_value->values;
                            }
                        @endphp
                        @if ($attribute->type == 'plain_text')
                            <input type="text" placeholder="{{ translate('Default Value') }}"
                                id="{{ 'plain_text_' . $attribute->id }}" name="{{ $attribute->id }}"
                                class="form-control" value="{{ $value }}">
                        @else
                            <input
                                id="{{ 'date_' . $attribute->id }}"
                                type="text"
                                class="form-control aiz-date-range"
                                value="{{ $value }}" name="{{ $attribute->id }}"
                                aria-describedby="date_range"
                                placeholder="Select Date" data-time-picker="true" data-format="DD-MM-Y HH:mm"
                                autocomplete="off" data-single="true">
                        @endif
                    @endif
                    @if ($attribute->type == 'number')
                        @isset($custom_properties->min_value)
                            <div class="input-group">
                                <input type="number" placeholder="0.00" id="{{ 'plain_text_' . $attribute->id }}"
                                    name="{{ $attribute->id }}" class="form-control" value="{{ $value }}"
                                    step="0.01" min="{{ $custom_properties->min_value }}"
                                    max="{{ $custom_properties->max_value }}">
                                <div class="input-group-append">
                                    <span class="input-group-text">{{ $custom_properties->unit }}</span>
                                </div>
                            </div>

                        @endisset
                    @endif
                    @if ($attribute->type == 'country')
                        @php
                            $countries = App\Models\Country::where('status', 1)->get();
                            $country_code = '';
                            if ($product->attributes()->where('attribute_id', $attribute->id)->first() != null) {
                                $country_code = $product->attributes()->where('attribute_id', $attribute->id)->first()->attribute_value->values;
                            }
                        @endphp
                        <select class="select2 form-control aiz-selectpicker" name="{{ $attribute->id }}"
                            data-toggle="select2" data-placeholder="Choose Country ..." data-live-search="true">
                            @foreach ($countries as $country)
                                <option value="{{ $country->code }}" @if ($country->code == $country_code) selected @endif>
                                    {{ $country->name }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
