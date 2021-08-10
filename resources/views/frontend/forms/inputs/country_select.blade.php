 <label class="control-label">{{ translate('Select your country') }}</label>
 <select class="form-control aiz-selectpicker" data-live-search="true" name="country" data-test="country">
     @foreach (\App\Models\Country::where('status', 1)->get() as $key => $country)
        <option value="{{ $country->code }}" {{ old("country") == $country->code ? 'selected' : '' }}>{{ $country->name }}</option>
     @endforeach
 </select>
