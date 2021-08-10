<!-- @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif -->

<form id="shop" class="" action="{{ route('shops.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="fs-15 fw-600 p-3 border-bottom">
        {{ translate('Company Info') }}
    </div>
    <div class="p-3">
        <div class="form-group">
            <label>{{ translate('Company Name') }} <span class="text-primary">*</span></label>
            <input type="text" value="{{ old('company_name') }}" class="form-control{{ $errors->has('company_name') ? ' is-invalid' : '' }}"
                placeholder="{{ translate('Company Name') }}" name="company_name" data-test="company_name">
            @error('company_name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group d-none">
            <label>{{ translate('Logo') }}</label>
            <div class="custom-file">
                <label class="custom-file-label">
                    <input type="file" class="custom-file-input" name="logo" accept="image/*">
                    <span class="custom-file-name">{{ translate('Choose image') }}</span>
                </label>
            </div>
        </div>
        <div class="form-group">
            <label>{{ translate('Headquarters Address') }} <span class="text-primary">*</span></label>
            <input type="text" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" value="{{ old('address') }}"
                placeholder="{{ translate('Address') }}" name="address" data-test="address">
            @error('address')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- TODO : Add country dropdown --}}
        <div class="form-group">
            @include('frontend.forms.inputs.country_select')
        </div>
    </div>

    @if (!Auth::check())
        <div class="fs-15 fw-600 p-3 border-bottom">
            {{ translate('Personal Info') }} -
            <small>{{ __('This information will be kept private at all times') }}
                <img src="https://uxwing.com/wp-content/themes/uxwing/download/01-user_interface/success-green-check-mark.png"
                    style="width: 15px;" />
            </small>
        </div>
        <div class="p-3">
            <div class="form-group">
                <label>{{ translate('Your Name') }} <span class="text-primary">*</span></label>
                <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                    value="{{ old('name') }}" value="{{ old('name') }}" placeholder="{{ translate('Name') }}"
                    name="name" data-test="name">
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            </div>

            <div class="form-group">
                <label>{{ translate('Your Email') }} <span class="text-primary">*</span></label>
                <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                    value="{{ old('email') }}" placeholder="{{ translate('Email') }}" name="email" name="form-email">
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>{{ translate('Contact Phone') }} <span class="text-primary">*</span></label>
                <input type="tel" value="{{ old('phone_number') }}"
                    class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}"
                    placeholder="{{ translate('Contact Phone') }}" name="phone_number" data-test="phone_number">
                @error('phone_number')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>{{ translate('Your Password') }} <span class="text-primary">*</span></label>
                <input type="password"
                    class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                    placeholder="{{ translate('Password') }}" name="password" data-test="password">
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>


            <div class="form-group">
                <label>{{ translate('Repeat Password') }} <span class="text-primary">*</span></label>
                <input type="password" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                    placeholder="{{ translate('Confirm Password') }}" name="password_confirmation" data-test="password_confirmation">
                @error('password_confirmation')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    @endif


    @if (\App\Models\BusinessSetting::where('type', 'google_recaptcha')->first()->value == 1)
        <div class="form-group mt-2 mx-auto row">
            <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_KEY') }}"></div>
        </div>
    @endif

    <div class="text-right">
        <button type="submit" class="btn btn-primary" data-test="submit">{{ translate('Register Your Company') }}</button>
    </div>
</form>
