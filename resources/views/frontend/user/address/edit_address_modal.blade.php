<form class="form-default" role="form" action="{{ route('addresses.update', $address_data->id) }}" method="POST">
    @csrf
    <div class="p-3">
        <div class="row">
            <div class="col-md-2">
                <label>{{ translate('Address')}}</label>
            </div>
            <div class="col-md-10">
                <textarea class="form-control mb-3" placeholder="{{ translate('Your Address')}}" rows="2" name="address" required>{{ $address_data->address }}</textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <label>{{ translate('Country')}}</label>
            </div>
            <div class="col-md-10">
                <div class="mb-3">
                    <select class="form-control aiz-selectpicker" data-live-search="true" data-placeholder="{{ translate('Select your country')}}" name="country" id="edit_country" required>
                        @foreach (\App\Models\Country::where('status', 1)->get() as $key => $country)
                        <option value="{{ $country->name }}" @if($address_data->country == $country->name) selected @endif>
                            {{ $country->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">
                <label>{{ translate('City')}}</label>
            </div>
            <div class="col-md-10">
                <select class="form-control mb-3 aiz-selectpicker" data-live-search="true" name="city" required>

                </select>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-2">
                <label>{{ translate('Postal code')}}</label>
            </div>
            <div class="col-md-10">
                <input type="text" class="form-control mb-3" placeholder="{{ translate('Your Postal Code')}}" value="{{ $address_data->postal_code }}" name="postal_code" value="" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <label>{{ translate('Phone')}}</label>
            </div>
            <div class="col-md-10">
                <input type="text" class="form-control mb-3" placeholder="{{ translate('+880')}}" value="{{ $address_data->phone }}" name="phone" value="" required>
            </div>
        </div>
        <div class="form-group text-right">
            <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
        </div>
    </div>
</form>