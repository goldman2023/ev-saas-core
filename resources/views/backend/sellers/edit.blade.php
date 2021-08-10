@extends('backend.layouts.app')

@section('content')
    <form action="{{ route('admin.sellers.update', $seller->id) }}" method="POST">

        <div class="aiz-titlebar text-left mt-2 mb-3">
            <h5 class="mb-0 h6">{{ translate('Edit Seller Information') }}</h5>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Seller Information') }}</h5>
                    </div>

                    <div class="card-body">
                        <input name="_method" type="hidden" value="PATCH">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label" for="name">{{ translate('Name') }}</label>
                            <div class="col-sm-9">
                                <input type="text" placeholder="{{ translate('Name') }}" id="name" name="name"
                                    class="form-control" value="{{ $seller->user->name }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label" for="email">{{ translate('Email Address') }}</label>
                            <div class="col-sm-9">
                                <input type="text" placeholder="{{ translate('Email Address') }}" id="email" name="email"
                                    class="form-control" value="{{ $seller->user->email }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label" for="password">{{ translate('Password') }}</label>
                            <div class="col-sm-9">
                                <input type="password" placeholder="{{ translate('Password') }}" id="password"
                                    name="password" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Shop Information') }}</h5>
                    </div>

                    <div class="card-body">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label" for="name">{{ translate('Company Name') }}</label>
                            <div class="col-sm-9">
                                <input type="text" placeholder="{{ translate('Company Name') }}" id="company-name" name="company_name"
                                    class="form-control" value="{{ $seller->user->shop->name }}" required>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <div class="col-lg-6">


                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Company Data') }}</h5>
                    </div>
                    <div class="card-body">
                        @foreach ($attributes as $attribute)
                            <div class="form-group row">
                                @if ($attribute->type == 'number')
                                    @php
                                        $value = '';
                                        if ($seller->attributes->where('attribute_id', $attribute->id)->first() != null) {
                                            $value = $seller->attributes->where('attribute_id', $attribute->id)->first()->attribute_value->values;
                                        }

                                        if ($attribute->custom_properties === null) {
                                        }
                                        $custom_properties = json_decode($attribute->custom_properties);
                                        // TODO: Remove this is only a fallback quick-fix because of old attributes that do not have min/max values
                                        // Related to: https://app.usersnap.com/#/2f2a6b9f-d137-4d9c-b748-1c7228f02147/list
                                        /* if (empty($custom_properties->min_value)) {
                                            $custom_properties->min_value = 0;
                                        }

                                        if (empty($custom_properties->max_value)) {
                                            $custom_properties->max_value = 1000000000;
                                        } */
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
                                            <option value="{{ $option->id }}" @if (in_array($option->id, $seller->attributes->pluck('attribute_value_id')->toArray())) selected @endif>
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
                                                    @if (in_array($option->id, $seller->attributes->where('attribute_id', $attribute->id)->pluck('attribute_value_id')->toArray())) checked @endif>
                                                <span class="aiz-square-check"></span>
                                                <span>{{ $option->values }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                @endif
                                @if ($attribute->type == 'plain_text' || $attribute->type == 'date')
                                    @php
                                        $value = '';
                                        if ($seller->attributes->where('attribute_id', $attribute->id)->first() != null) {
                                            $value = $seller->attributes->where('attribute_id', $attribute->id)->first()->attribute_value->values;
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
                                        if ($seller->attributes->where('attribute_id', $attribute->id)->first() != null) {
                                            $country_code = $seller->attributes->where('attribute_id', $attribute->id)->first()->attribute_value->values;
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

                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-primary">{{ translate('Save') }}</button>
                </div>
            </div>
            </div>
        </form>

    @endsection
