<div class="w-full relative">
    <x-ev.loaders.spinner class="absolute-center z-10 hidden"
                              wire:loading.class.remove="hidden"></x-ev.loaders.spinner>

    <div class="w-full" wire:loading.class="opacity-30 pointer-events-none">
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

        {{-- First Name --}}
        <div class="mb-3">
            <label class="block text-16 font-medium text-gray-700">{{ translate('First name') }}</label>

            <div class="mt-1 relative rounded-md shadow-sm">
                <input type="text"
                        class="form-standard @error('name') is-invalid @enderror"
                        placeholder="John"
                        wire:model.defer="name"
                        data-test="we-register-name">

                        <x-system.invalid-icon field="name"/>
            </div>

            <x-system.invalid-msg field="name"/>
        </div>
        {{-- END First Name --}}

        {{-- Last Name --}}
        <div class="mb-3">
            <label class="block text-16 font-medium text-gray-700">{{ translate('Last name') }}</label>

            <div class="mt-1 relative rounded-md shadow-sm">
                <input type="text"
                        class="form-standard @error('surname') is-invalid @enderror"
                        placeholder="Smith"
                        wire:model.defer="surname"
                        data-test="we-register-surname">

                        <x-system.invalid-icon field="surname"/>
            </div>

            <x-system.invalid-msg field="surname"/>
        </div>
        {{-- END Last Name --}}

        {{-- Email --}}
        <div class="mb-3">
            <label class="block text-16 font-medium text-gray-700">{{ translate('Email') }}</label>

            <div class="mt-1 relative rounded-md shadow-sm">
                <input type="email"
                        name="email"
                        class="form-standard @error('email') is-invalid @enderror"
                        placeholder="you@example.com"
                        wire:model.defer="email"
                        data-test="we-register-email">

                        <x-system.invalid-icon field="email"/>
            </div>

            <x-system.invalid-msg field="email"/>
        </div>
        {{-- END Email --}}
        
        {{-- Password --}}
        <div class="mb-3">
            <label class="block text-16 font-medium text-gray-700">{{ translate('Password') }}</label>

            <div class="mt-1 relative rounded-md shadow-sm">
                <input type="password"
                        class="form-standard @error('password') is-invalid @enderror"
                        wire:model.defer="password"
                        data-test="we-register-password">

                        <x-system.invalid-icon field="password"/>
            </div>

            <x-system.invalid-msg field="password"/>
        </div> 
        {{-- END Password --}}

        {{-- Password Confirmation --}}
        <div class="mb-4">
            <label class="block text-16 font-medium text-gray-700">{{ translate('Password confirmation') }}</label>

            <div class="mt-1 relative rounded-md shadow-sm">
                <input type="password"
                        class="form-standard @error('password_confirmation') is-invalid @enderror"
                        wire:model.defer="password_confirmation"
                        data-test="we-register-password-confirmation">

                        <x-system.invalid-icon field="password_confirmation"/>
            </div>

            <x-system.invalid-msg field="password_confirmation"/>
        </div> 
        {{-- END Password Confirmation --}}

        {{-- Consent Terms and Conditions --}}
        <div class="mb-2 flex items-center justify-between">
            <div class="w-full relative flex items-start ml-1">
                <div class="flex items-center h-5">
                  <input id="register-form-terms-consent" type="checkbox" wire:model.defer="terms_consent" data-test="we-register-terms-consent"
                            class="form-checkbox-standard">
                </div>
                <div class="ml-3 text-sm">
                  <label for="register-form-terms-consent" class="cursor-pointer font-medium text-gray-700 @error('terms_consent') text-danger @enderror">
                    {{ translate('By Registering I agree to ') }} {{ get_site_name() }} {{ translate('Terms of Service') }}
                  </label>

                  <x-system.invalid-msg field="terms_consent"/>
                </div>
            </div>
        </div>
        {{-- END Consent Terms and Conditions --}}

        {{-- Register Action --}}
        <div class="mb-3">
            <button type="button"
                    class="btn bg-primary text-white w-full mt-2" 
                    wire:click="register()"
                    data-test="we-register-submit">
                {{ translate('Register')}}
            </button>
        </div>
        {{-- END Register Action --}}



        <div class="text-center">
            <span class="text-12 w-full text-muted">{{ translate('Already have an account?') }}</span>
            <a class="text-12 font-semibold" href="{{ route('user.login') }}">
                {{ translate('Sign In') }}
            </a>

            {{-- <a class="text-12 font-semibold" href="{{ route('business.register') }}">
                {{ translate('Business Sign Up') }}
            </a> --}}
        </div>
    </div>
</div>
