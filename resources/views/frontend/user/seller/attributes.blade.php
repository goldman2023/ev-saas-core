@extends('frontend.layouts.user_panel')

@section('panel_content')
    <div class="aiz-titlebar mt-2 mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{ translate('Business Profile') }}</h1>
            </div>
        </div>
    </div>

    <x-company-categories-management :categories="$categories" :user="$user"> </x-company-categories-management>


    <x-subsidiary-companies-management> </x-subsidiary-companies-management>

    <form action="{{ route('frontend.attributes.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- Basic Info-->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Company Attributes') }}</h5>
            </div>
            <div class="card-body">
                @foreach ($attributes as $attribute)
                    <div class="form-group row">
                        @if ($attribute->type == 'number')
                            @php
                                $value = '';
                                if ($user->seller->attributes->where('attribute_id', $attribute->id)->first() != null) {
                                    $value = $user->seller->attributes->where('attribute_id', $attribute->id)->first()->attribute_value->values;
                                }
                                $custom_properties = json_decode($attribute->custom_properties);
                            @endphp
                            @if (isset($custom_properties->min_value))
                                <label
                                    class="col-md-4 col-from-label">{{ $attribute->name . ' (' . $custom_properties->min_value . ' - ' . $custom_properties->max_value . ')' }}</label>

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
                                        <option value="{{ $option->id }}" @if (in_array($option->id, $user->seller->attributes->pluck('attribute_value_id')->toArray())) selected @endif>{{ $option->getTranslation('name') }}
                                        </option>
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
                                                @if (in_array($option->id, $user->seller->attributes->where('attribute_id', $attribute->id)->pluck('attribute_value_id')->toArray())) checked @endif>
                                            <span class="aiz-square-check"></span>
                                            <span>{{ $option->values }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                            @if ($attribute->type == 'plain_text' || $attribute->type == 'date')
                                @php
                                    $value = '';
                                    if ($user->seller->attributes->where('attribute_id', $attribute->id)->first() != null) {
                                        $value = $user->seller->attributes->where('attribute_id', $attribute->id)->first()->attribute_value->values;
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
                                <div class="input-group">
                                    @if (isset($custom_properties->min_value))
                                        <input type="number" placeholder="0.00" id="{{ 'plain_text_' . $attribute->id }}"
                                            name="{{ $attribute->id }}" class="form-control" value="{{ $value }}"
                                            step="0.01" min="{{ $custom_properties->min_value }}"
                                            max="{{ $custom_properties->max_value }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text">{{ $custom_properties->unit }}</span>
                                        </div>
                                    @endif
                                </div>

                            @endif
                            @if ($attribute->type == 'country')
                                @php
                                    $countries = App\Models\Country::where('status', 1)->get();
                                    $country_code = '';
                                    if ($user->seller->attributes->where('attribute_id', $attribute->id)->first() != null) {
                                        $country_code = $user->seller->attributes->where('attribute_id', $attribute->id)->first()->attribute_value->values;
                                    }
                                @endphp
                                <select class="select2 form-control aiz-selectpicker" name="{{ $attribute->id }}"
                                    data-toggle="select2" data-placeholder="Choose Country ..." data-live-search="true">
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->code }}" @if ($country->code == $country_code) selected @endif>{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    </div>
                @endforeach

                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-primary" data-test="submit">{{ translate('Update Attributes') }}</button>
                </div>
            </div>
        </div>
        </div>
    </form>



@endsection

@section('script')
    <script type="text/javascript">
        function add_new_address() {
            $('#new-address-modal').modal('show');
        }

        $('.new-email-verification').on('click', function() {
            $(this).find('.loading').removeClass('d-none');
            $(this).find('.default').addClass('d-none');
            var email = $("input[name=email]").val();

            $.post('{{ route('user.new.verify') }}', {
                _token: '{{ csrf_token() }}',
                email: email
            }, function(data) {
                data = JSON.parse(data);
                $('.default').removeClass('d-none');
                $('.loading').addClass('d-none');
                if (data.status == 2)
                    AIZ.plugins.notify('warning', data.message);
                else if (data.status == 1)
                    AIZ.plugins.notify('success', data.message);
                else
                    AIZ.plugins.notify('danger', data.message);
            });
        });

        function edit_address(address) {
            var url = '{{ route('addresses.edit', ':id') }}';
            url = url.replace(':id', address);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: 'GET',
                success: function(response) {
                    $('#edit_modal_body').html(response);
                    $('#edit-address-modal').modal('show');
                    AIZ.plugins.bootstrapSelect('refresh');
                    var country = $("#edit_country").val();
                    get_city(country);
                }
            });
        }

        $(document).on('change', '[name=country]', function() {
            var country = $(this).val();
            get_city(country);
        });

        function get_city(country) {
            $('[name="city"]').html("");
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('get-city') }}",
                type: 'POST',
                data: {
                    country_name: country
                },
                success: function(response) {
                    var obj = JSON.parse(response);
                    if (obj != '') {
                        $('[name="city"]').html(obj);
                        AIZ.plugins.bootstrapSelect('refresh');
                    }
                }
            });
        }

    </script>
@endsection
