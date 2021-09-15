 <form action="{{ route('frontend.attributes.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- Basic Info-->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate($user->user_type . ' Attributes')}}</h5>
            </div>
            <div class="card-body">
                @foreach ($attributes as $attribute)
                    <div class="form-group row">
                        <label class="col-md-4 col-from-label">{{ $attribute->name }}</label>
                        <div class="col-md-8">
                            @if ($attribute->type == 'dropdown')
                                <select name="{{ $attribute->id }}" id="{{ 'dropdown_'. $attribute->id }}" class="form-control aiz-selectpicker" data-selected-text-format="count" data-live-search="true" data-placeholder="{{ translate('Choose Attributes') }}">                                    
                                    @foreach ($attribute->attribute_values as $option)
                                        <option value="{{ $option->id }}" @if(in_array($option->id, $user->seller->attributes->pluck('attribute_value_id')->toArray())) selected @endif>{{ $option->getTranslation('name') }}</option>
                                    @endforeach
								</select>
                            @endif
                            @if ($attribute->type == 'checkbox')
                                <input type="hidden" name="{{ $attribute->id }}" />
                                <div class="aiz-checkbox-list">
                                    @foreach ($attribute->attribute_values as $option)
                                        <label class="aiz-checkbox">
                                            <input
                                                type="checkbox"
                                                name="{{ $attribute->id }}[]"
                                                value="{{ $option->id }}" @if (in_array($option->id, $user->seller->attributes->where('attribute_id', $attribute->id)->pluck('attribute_value_id')->toArray())) checked @endif
                                            >
                                            <span class="aiz-square-check"></span>
                                            <span>{{ $option->values }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                            @if ($attribute->type == 'plain_text' || $attribute->type == 'number' || $attribute->type == 'date')
                                @php
                                    $value = "";
                                    if ($user->seller->attributes->where('attribute_id', $attribute->id)->first() != null) {
                                        $value = $user->seller->attributes->where('attribute_id', $attribute->id)->first()->attribute_value->values;
                                    }
                                    $input_type = 'text';
                                    if ($attribute->type != 'plain_text') $input_type = $attribute->type;
                                @endphp
                                @if($input_type != 'date')
                                    <input type="{{ $input_type }}" placeholder="{{ translate('Default Value')}}" id="{{ $attribute->type . '_' . $attribute->id }}" name="{{ $attribute->id }}" class="form-control" value="{{ $value }}" step="any">
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
                            @if ($attribute->type == "country")
                                @php
                                    $countries = App\Models\Country::where('status', 1)->get();
                                    $country_code = "";
                                    if ($user->seller->attributes->where('attribute_id', $attribute->id)->first() != null) {
                                        $country_code = $user->seller->attributes->where('attribute_id', $attribute->id)->first()->attribute_value->values;
                                    }
                                @endphp
                                <select class="select2 form-control aiz-selectpicker" name="{{ $attribute->id }}" data-toggle="select2" data-placeholder="Choose Country ..." data-live-search="true">
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->code }}" @if($country->code == $country_code) selected @endif>{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    </div>
                @endforeach

                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-primary">{{translate('Update Attributes')}}</button>
                </div>
            </div>
        </div>
      </div>
    </form>