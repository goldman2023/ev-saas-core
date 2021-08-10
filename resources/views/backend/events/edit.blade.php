@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
    <h1 class="mb-0 h6">{{ translate('Edit Event') }}</h5>
</div>
<div class="">
    <form class="" action="{{route('admin.events.update', $event->id)}}" method="POST" enctype="multipart/form-data" id="choice_form">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{ $event->id }}">
        <input type="hidden" name="lang" value="{{ $lang }}">

        <div class="row">
            <div class="col-lg-6">
                <div class="card mb-0 border-bottom-0">
                    <div class="card-body p-0">
                        <ul class="nav nav-tabs nav-fill border-light">
                            @foreach (\App\Models\Language::all() as $key => $language)
                                <li class="nav-item">
                                    <a class="nav-link text-reset @if ($language->code == $lang) active @else bg-soft-dark border-light border-left-0 @endif py-3" href="{{ route('admin.events.edit', ['id'=>$event->id, 'lang'=> $language->code] ) }}">
                                        <img src="{{ static_asset('assets/img/flags/'.$language->code.'.png') }}" height="11" class="mr-1">
                                        <span>{{$language->name}}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-lg-3 col-from-label">{{translate('Event Title')}} <span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" name="title" placeholder="{{translate('Event title')}}" value="{{$event->getTranslation('title', $lang)}}">
                                @error('title')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-from-label">{{translate('Event Description')}} <span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <textarea class="form-control" name="description">{{$event->getTranslation('description', $lang)}}</textarea>
                                @error('description')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-from-label">{{ translate('Event Image')}} <span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <div class="input-group" data-toggle="aizuploader" data-multiple="false">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                    </div>
                                    <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                    <input type="hidden" name="image" class="selected-files" value="{{ $event->upload_id }}">
                                </div>
                                <div class="file-preview box sm">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Event Data') }}</h5>
                    </div>
                    <div class="card-body">
                        @foreach ($attributes as $attribute)
                            <div class="form-group row">
                                @if ($attribute->type == 'number')
                                    @php
                                        $value = '';
                                        if ($event->attributes->where('attribute_id', $attribute->id)->first() != null) {
                                            $value = $event->attributes->where('attribute_id', $attribute->id)->first()->attribute_value->values;
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
                                                <option value="{{ $option->id }}" @if (in_array($option->id, $event->attributes->pluck('attribute_value_id')->toArray())) selected @endif>
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
                                                        @if (in_array( $option->id, $event->attributes->where('attribute_id', $attribute->id)->pluck('attribute_value_id')->toArray(),)) checked @endif>
                                                    <span class="aiz-square-check"></span>
                                                    <span>{{ $option->values }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    @endif
                                    @if ($attribute->type == 'plain_text' || $attribute->type == 'date')
                                        @php
                                            $value = '';
                                            if ($event->attributes->where('attribute_id', $attribute->id)->first() != null) {
                                                $value = $event->attributes->where('attribute_id', $attribute->id)->first()->attribute_value->values;
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
                                            $countries = App\Models\Country::where('status', 1)->get();
                                            $country_code = '';
                                            if ($event->attributes->where('attribute_id', $attribute->id)->first() != null) {
                                                $country_code = $event->attributes->where('attribute_id', $attribute->id)->first()->attribute_value->values;
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
            <button type="submit" class="btn btn-primary">{{translate('Save Event')}}</button>
        </div>
    </form>
</div>

@endsection
