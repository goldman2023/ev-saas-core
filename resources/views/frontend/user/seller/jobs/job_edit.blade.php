@extends('frontend.layouts.user_panel')

@section('panel_content')
    <div class="aiz-titlebar mt-2 mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{ translate('Edit Job') }}</h1>
            </div>
        </div>
    </div>
    <form class="" action="{{route('jobs.update', $job->id)}}" method="POST" enctype="multipart/form-data" id="choice_form">
        @csrf
        <input type="hidden" name="id" value="{{ $job->id }}">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-lg-3 col-from-label">{{translate('Title')}} <span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" name="title" placeholder="{{translate('Job title')}}" value="{{$job->title}}">
                                @error('title')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-from-label">{{translate('Excerpt')}} <span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <textarea class="form-control" name="excerpt">{{$job->excerpt}}</textarea>
                                @error('excerpt')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-from-label">{{translate('Content')}} <span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <textarea class="form-control" name="content">{{$job->content}}</textarea>
                                @error('content')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Job Data') }}</h5>
                    </div>
                    <div class="card-body">
                        @foreach ($attributes as $attribute)
                            <div class="form-group row">
                                @if ($attribute->type == 'number')
                                    @php
                                        $value = '';
                                        if ($job->attributes->where('attribute_id', $attribute->id)->first() != null) {
                                            $value = $job->attributes->where('attribute_id', $attribute->id)->first()->attribute_value->values;
                                        }
                                        
                                        if ($attribute->custom_properties === null) {
                                        }
                                        $custom_properties = json_decode($attribute->custom_properties);
                                    @endphp

                                    @isset($custom_properties->min_value)
                                        <label
                                            class="col-md-4 col-from-label">{{ $attribute->name . ' (' . $custom_properties->min_value . ' - ' . $custom_properties->max_value . ')' }}</label>
                                    @else
                                        <label class="col-md-4 col-from-label">{{ $attribute->name }}</label>

                                    @endif
                                @else
                                    <label class="col-md-4 col-from-label">{{ $attribute->name }}</label>
                                @endif
                                <div class="col-md-8">
                                    @if ($attribute->type == 'dropdown')
                                        <select name="{{ $attribute->id }}" id="{{ 'dropdown_' . $attribute->id }}"
                                            class="form-control aiz-selectpicker" data-selected-text-format="count"
                                            data-live-search="true" data-placeholder="{{ translate('Choose Attributes') }}">
                                            @foreach ($attribute->attribute_values as $option)
                                                <option value="{{ $option->id }}" @if (in_array($option->id, $job->attributes->pluck('attribute_value_id')->toArray())) selected @endif>
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
                                                        @if (in_array( $option->id, $job->attributes->where('attribute_id', $attribute->id)->pluck('attribute_value_id')->toArray(),)) checked @endif>
                                                    <span class="aiz-square-check"></span>
                                                    <span>{{ $option->values }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    @endif
                                    @if ($attribute->type == 'plain_text' || $attribute->type == 'date' || $attribute->type == 'text_list')
                                        @php
                                            $value = '';
                                            if ($job->attributes->where('attribute_id', $attribute->id)->first() != null) {
                                                $value = $job->attributes->where('attribute_id', $attribute->id)->first()->attribute_value->values;
                                            }
                                        @endphp
                                        @if ($attribute->type == 'text_list' )
                                            @php
                                                $items = array();
                                                if(json_decode($value))$items = array_values(json_decode($value));
                                                $first_value = (array_shift($items));
                                            @endphp
                                            {{-- <input type="text" class="form-control aiz-tag-input" name="{{$attribute->id}}" id="text_list_{{$attribute->id}}" data-role="tagsinput" value="{{ $value }}"> --}}
                                            <div>
                                                <!-- Form Group -->
                                                <div class="js-add-field form-group"
                                                    data-hs-add-field-options='{
                                                        "template": "#addAddressFieldEgTemplate{{$attribute->id}}",
                                                        "container": "#addAddressFieldEgContainer{{$attribute->id}}",
                                                        "defaultCreated": 0
                                                    }'>
                                                    <div>
                                                        <input type="text" class="form-control" name="{{$attribute->id}}[]" id="{{$attribute->id}}" placeholder="Type {{$attribute->name}}" aria-label="Your address" value="{{$first_value}}">

                                                        <!-- Container For Input Field -->
                                                        <div id="addAddressFieldEgContainer{{$attribute->id}}"></div>

                                                        <a href="javascript:;" class="js-create-field form-link btn btn-sm btn-no-focus btn-ghost-primary">
                                                            <i class="tio-add"></i> {{$attribute->name}}
                                                        </a>
                                                    </div>
                                                </div>
                                                <!-- End Form Group -->
                                                
                                                <!-- Add Phone Input Field -->
                                                <div id="addAddressFieldEgTemplate{{$attribute->id}}" style="display: none;">
                                                    <div class="input-group-add-field"> 
                                                        <input type="text" class="form-control" name="{{$attribute->id}}[]" placeholder="Type {{$attribute->name}}">

                                                        <a class="js-delete-field input-group-add-field-delete" href="javascript:;">
                                                            <i class="tio-clear"></i>
                                                        </a>
                                                    </div>
           
                                                </div>
                                                <script>
                                                    var id = "{{$attribute->id}}";
                                                    var js_var = JSON.parse('<?php echo json_encode($items); ?>');
                                                    js_var.map((item, index)=>{
                                                        var inputHtml = '<div class="input-group-add-field"><input type="text" value="'+item+'"class="form-control" name="{{$attribute->id}}[]" placeholder="Type {{$attribute->name}}"><a class="js-delete-field input-group-add-field-delete" onclick="removeItem(this)" href="javascript:;"><i class="tio-clear"></i></a></div>';
                                                        document.getElementById("addAddressFieldEgContainer"+ id).insertAdjacentHTML('beforebegin', inputHtml);
                                                    })

                                                </script>
                                            </div>
                                        @elseif ($attribute->type == 'plain_text')
                                            <input type="text" placeholder="{{ translate('Default Value') }}"
                                                id="{{ 'plain_text_' . $attribute->id }}" name="{{ $attribute->id }}"
                                                class="form-control" value="{{ $value }}">
                                        @elseif ($attribute->type == 'date')
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
                                        @if (isset($custom_properties->min_value))
                                            <div class="input-group">
                                                <input type="number" placeholder="0.00" id="{{ 'plain_text_' . $attribute->id }}"
                                                    name="{{ $attribute->id }}" class="form-control" value="{{ $value }}"
                                                    step="0.01" min="{{ $custom_properties->min_value }}"
                                                    max="{{ $custom_properties->max_value }}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">{{ $custom_properties->unit }}</span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="input-group">
                                                <input type="number" placeholder="0.00" id="{{ 'plain_text_' . $attribute->id }}"
                                                    name="{{ $attribute->id }}" class="form-control" value="{{ $value }}"
                                                    step="0.01" >
                                                <div class="input-group-append">
                                                    @if ($custom_properties)
                                                        <span class="input-group-text">{{ $custom_properties->unit }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                    @if ($attribute->type == 'country')
                                        @php
                                            $countries = App\Country::where('status', 1)->get();
                                            $country_code = '';
                                            if ($job->attributes->where('attribute_id', $attribute->id)->first() != null) {
                                                $country_code = $job->attributes->where('attribute_id', $attribute->id)->first()->attribute_value->values;
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
        </div>
        
        <div class="form-group mb-0 text-right">
            <button type="submit" class="btn btn-primary">{{translate('Save job')}}</button>
        </div>
    </form>

@endsection

@section('script')
    <script>
        function removeItem(e) {
            $(e).parent().remove();
        }
    </script>
@endsection

