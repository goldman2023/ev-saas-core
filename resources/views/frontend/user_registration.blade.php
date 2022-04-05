@extends('frontend.layouts.' . $globalLayout)

@section('content')
<div class="bg-gray-100 pt-10 pb-10">
    <div
        class="min-h-full flex flex md:w-full md:max-w-6xl sm:rounded-2xl sm:shadow overflow-hidden sm:bg-card mx-auto bg-white">
        <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                <div>
                    <x-tenant.system.image alt="{{ get_site_name() }} logo" class="h-12 w-auto"
                        :image="get_site_logo()">
                    </x-tenant.system.image>
                    <h2 class="mt-6 text-3xl font-extrabold text-gray-900">{{ translate('Sign up') }}</h2>
                    <p class=" mt-2 text-sm text-gray-600">
                        {{ translate('Or') }}
                        <a href="{{ route('user.login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                            {{ translate('Already a member? Sign In') }} </a>
                    </p>
                </div>

                <div class="mt-3">
                    <div class="w-full ">
                        <x-system.social-login-buttons class="mb-5">
                            <div class="w-full relative mb-3">
                                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                    <div class="w-full border-t border-gray-300"></div>
                                </div>
                                <div class="relative flex justify-center">
                                    <span class="px-2 bg-white text-sm text-gray-500"> {{ translate('OR') }} </span>
                                </div>
                            </div>
                        </x-system.social-login-buttons>
                    </div>

                    <div class="mt-">
                        <form id="reg-form" class="space-y-6" role="form" action="{{ route('register') }}"
                            method="POST">
                            @csrf
                            <div class="grid grid-cols-2 gap-5">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">
                                        {{ translate('First Name') }}
                                    </label>
                                    <div class="mt-1">
                                        <input id="name" name="name" type="text" required class="form-standard">

                                        <x-system.invalid-msg class="w-full" field="name"></x-system.invalid-msg>
                                    </div>
                                </div>
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">
                                        {{ translate('Last Name') }}
                                    </label>
                                    <div class="mt-1">
                                        <input id="surname" name="surname" type="text" required class="form-standard">

                                        <x-system.invalid-msg class="w-full" field="surname"></x-system.invalid-msg>
                                    </div>
                                </div>
                            </div>



                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700"> {{ translate('Email
                                    address') }} </label>
                                <div class="mt-1">
                                    <input id="email" name="email" type="email" autocomplete="email" required
                                        class="form-standard">
                                    <x-system.invalid-msg class="w-full" field="email"></x-system.invalid-msg>
                                </div>
                            </div>

                            <div class="space-y-1">
                                <label for="password" class="block text-sm font-medium text-gray-700"> {{
                                    translate('Password') }} </label>
                                <div class="mt-1">
                                    <input id="password" name="password" type="password" autocomplete="current-password"
                                        required class="form-standard">
                                    <x-system.invalid-msg class="w-full" field="password"></x-system.invalid-msg>
                                </div>
                            </div>

                            <div class="space-y-1">
                                <label for="password" class="block text-sm font-medium text-gray-700"> {{
                                    translate('Confirm your password') }} </label>
                                <div class="mt-1">
                                    <input id="password_confirmation" name="password_confirmation" type="password"
                                        autocomplete="current-password" required class="form-standard">
                                    <x-system.invalid-msg class="w-full" field="password_confirmation">
                                    </x-system.invalid-msg>
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <input id="remember-me" name="remember-me" type="checkbox"
                                        class="form-checkbox-standard">
                                    <label for="remember-me" class="ml-2 block text-sm text-gray-900">
                                        {{ translate('By Registering I agree to ') }} {{ get_site_name() }} {{
                                        translate('Terms of Service') }}
                                    </label>
                                </div>

                                <div class="text-sm">
                                    {{-- TODO: Create password resets --}}
                                    {{-- <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
                                        {{ translate('Forgot your password?') }}
                                    </a> --}}
                                </div>
                            </div>

                            <div>
                                <button type="submit"
                                    class="btn-primary w-full justify-center items-center bg-indigo-600">
                                    {{ translate('Register') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="hidden lg:block relative w-0 flex-1">
            <div
                class="relative hidden md:flex flex-auto items-center justify-center h-full p-16 lg:px-20 overflow-hidden bg-gray-800 dark:border-l ">
                <svg viewBox="0 0 960 540" width="100%" height="100%" preserveAspectRatio="xMidYMax slice"
                    xmlns="http://www.w3.org/2000/svg" class="absolute inset-0 pointer-events-none ">
                    <g fill="none" stroke="currentColor" stroke-width="100" class="text-gray-700 opacity-25 ">
                        <circle r="234" cx="196" cy="23" class=""></circle>
                        <circle r="234" cx="790" cy="491" class=""></circle>
                    </g>
                </svg><svg viewBox="0 0 220 192" width="220" height="192" fill="none"
                    class="absolute -top-16 -right-16 text-gray-700 ">
                    <defs class="">
                        <pattern id="837c3e70-6c3a-44e6-8854-cc48c737b659" x="0" y="0" width="20" height="20"
                            patternUnits="userSpaceOnUse" class="">
                            <rect x="0" y="0" width="4" height="4" fill="currentColor" class=""></rect>
                        </pattern>
                    </defs>
                    <rect width="220" height="192" fill="url(#837c3e70-6c3a-44e6-8854-cc48c737b659)" class="">
                    </rect>
                </svg>
                <div class="z-10 relative w-full max-w-2xl">
                    <div class="text-5xl font-bold leading-none text-gray-100 ">
                        <div class="">{{ translate('Welcome to') }}</div>
                        <div class="">{{ translate('our community') }}</div>
                    </div>
                    <div class="mt-6 text-lg tracking-tight leading-6 text-gray-400 ">
                        {{ get_tenant_setting('registration_text', 'Join the global community of likeminded people') }}
                    </div>
                    <div class="flex items-center mt-8 ">
                        <div class="flex flex-0 items-center -space-x-1.5 ">
                            @for($i = 0; $i < 4; $i++) <img src="/images/male-09.jpeg"
                                class="flex-0 w-10 h-10 rounded-full ring-4 ring-offset-1 ring-gray-800 ring-offset-gray-800 object-cover ">
                                @endfor
                        </div>
                        <div class="ml-4 font-medium tracking-tight text-gray-400 ">
                            {{ translate('More than') }} {{ get_public_user_count() }}
                            {{ translate('people joined us, it\'s your turn') }}</div>
                    </div>
                </div>
            </div>
            {{-- <img class="absolute inset-0 h-full w-full object-cover"
                src="https://images.unsplash.com/photo-1505904267569-f02eaeb45a4c?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1908&q=80"
                alt=""> --}}
        </div>
    </div>
</div>
@endsection


@section('script')
@if(get_setting( 'google_recaptcha') == 1)
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endif

<script type="text/javascript">
    @if(get_setting( 'google_recaptcha') == 1)
        // making the CAPTCHA  a required field for form submission
        $(document).ready(function(){
            // alert('helloman');
            $("#reg-form").on("submit", function(evt)
            {
                var response = grecaptcha.getResponse();
                if(response.length == 0)
                {
                //reCaptcha not verified
                    alert("please verify you are humann!");
                    evt.preventDefault();
                    return false;
                }
                //captcha verified
                //do the rest of your validations here
                $("#reg-form").submit();
            });
        });
        @endif

        var isPhoneShown = true,
            countryData = window.intlTelInputGlobals.getCountryData(),
            input = document.querySelector("#phone-code");

        for (var i = 0; i < countryData.length; i++) {
            var country = countryData[i];
            if(country.iso2 == 'bd'){
                country.dialCode = '88';
            }
        }

        var iti = intlTelInput(input, {
            separateDialCode: true,
            utilsScript: "{{ static_asset('assets/js/intlTelutils.js') }}?1590403638580",
            onlyCountries: @php echo json_encode(\App\Models\Country::where('status', 1)->pluck('code')->toArray()) @endphp,
            customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
                if(selectedCountryData.iso2 == 'bd'){
                    return "01xxxxxxxxx";
                }
                return selectedCountryPlaceholder;
            }
        });

        var country = iti.getSelectedCountryData();
        $('input[name=country_code]').val(country.dialCode);

        input.addEventListener("countrychange", function(e) {
            // var currentMask = e.currentTarget.placeholder;

            var country = iti.getSelectedCountryData();
            $('input[name=country_code]').val(country.dialCode);

        });

        function toggleEmailPhone(el){
            if(isPhoneShown){
                $('.phone-form-group').addClass('d-none');
                $('.email-form-group').removeClass('d-none');
                isPhoneShown = false;
                $(el).html('{{ translate('Use Phone Instead') }}');
            }
            else{
                $('.phone-form-group').removeClass('d-none');
                $('.email-form-group').addClass('d-none');
                isPhoneShown = true;
                $(el).html('{{ translate('Use Email Instead') }}');
            }
        }
</script>
@endsection
