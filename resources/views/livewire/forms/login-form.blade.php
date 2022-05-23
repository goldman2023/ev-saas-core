<form class="w-full relative" wire:submit.prevent="login()">
    <x-ev.loaders.spinner class="absolute-center z-10 hidden"
                              wire:target="login"
                              wire:loading.class.remove="hidden"></x-ev.loaders.spinner>

    <div class=""
            wire:loading.class="opacity-30 pointer-events-none"
            wire:target="login"
    >

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

        <div class="mb-4">
            <label class="block text-16 font-medium text-gray-700">{{ translate('Email') }}</label>

            <div class="mt-1 relative rounded-md shadow-sm">
                <input type="email"
                        name="email"
                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('email') input-invalid @enderror"
                        placeholder="you@example.com"
                        wire:model.defer="email"
                        data-test="we-login-email">

                        <x-system.invalid-icon field="email"/>
            </div>

            <x-system.invalid-msg field="email"/>
        </div>

        <div class="mb-3">
            <label class="block text-16 font-medium text-gray-700">{{ translate('Password') }}</label>

            <div class="mt-1 relative rounded-md shadow-sm">
                <input type="password"
                        name="password"
                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('password') input-invalid @enderror"
                        wire:model.defer="password"
                        data-test="we-login-password">

                        <x-system.invalid-icon field="password"/>
            </div>

            <x-system.invalid-msg field="password"/>
        </div>

        <div class="mb-2 flex items-center justify-between">
            <div class="relative flex items-start ml-1">
                <div class="flex items-center h-5">
                  <input name="remember" id="login-form-remember" type="checkbox" wire:model.defer="remember" data-test="we-login-remember"
                            class="h-4 w-4 text-sky-600 border-gray-300 rounded">
                </div>
                <div class="ml-3 text-sm">
                  <label for="login-form-remember" class="font-medium text-gray-700">{{ translate('Remember Me') }}</label>
                </div>
            </div>
            <div class="text-right">
                <a href="{{ route('user.forgot-password') }}" class="text-12 underline" data-test="we-login-forgot-password-link">
                    {{ translate('Forgot password?') }}
                </a>
            </div>
        </div>

        <div class="mb-3">
            <button type="submit"
                    class="btn bg-primary text-white w-full mt-2"
                    data-test="we-login-submit">
                {{ translate('Login')}}
            </button>
        </div>

        <div class="text-center">
            <span class="text-12 w-full text-muted">{{ translate('Do not have an account?') }}</span>
            <a class="text-12 font-semibold" href="{{ route('user.registration').(!empty($redirect_url) ? '?redirect_url='.urlencode($redirect_url) : '') }}">
                {{ translate('Sign Up') }}
            </a>

            {{-- <a class="text-12 font-semibold" href="{{ route('business.register') }}">
                {{ translate('Business Sign Up') }}
            </a> --}}
        </div>
    </div>
</form>
