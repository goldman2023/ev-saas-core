<div class="w-100 position-relative">
    <x-ev.loaders.spinner class="absolute-center z-10 d-none"
                              wire:target="login"
                              wire:loading.class.remove="d-none"></x-ev.loaders.spinner>

    <div class=""
            wire:loading.class="opacity-3 prevent-pointer-events"
            wire:target="login"
    >
        <div class="mb-4">
            <label class="input-label">{{ translate('Email') }}</label>

            <div class="input-group input-group-sm mb-2">

                <input type="email"
                    data-test="we-login-email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}" placeholder="{{ translate('Email') }}"
                    name="email"
                    wire:model.defer="email">
            </div>
            <x-system.invalid-msg field="email" type="slim"></x-system.invalid-msg>
        </div>

        <div class="mb-3">
            <label class="input-label">{{ translate('Password') }}</label>
            <div class="input-group input-group-sm mb-2">
                <input type="password"
                    data-test="we-login-password"
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="{{ translate('Password') }}" name="password" id="password"
                    wire:model.defer="password">
            </div>
            <x-system.invalid-msg field="password" type="slim"></x-system.invalid-msg>
        </div>

        <div class="row mb-2">
            <div class="col-6">
                <label class="">
                    <input type="checkbox" name="remember" wire:model.defer="remember">
                    <span class="opacity-60 small">{{ translate('Remember Me') }}</span>
                </label>
            </div>
            <div class="col-6 text-right">
                <a href="{{ route('password.request') }}" class="small link-underline">
                    {{ translate('Forgot password?') }}
                </a>
            </div>
        </div>

        <div class="mb-3">
            <button type="button"
            data-test="we-login-submit"
            class="btn btn-sm btn-primary btn-block" wire:click="login()">
                {{ translate('Login')}}
            </button>
        </div>


        <div class="text-center">
            <span class="small text-muted">{{ translate('Do not have an account?') }}</span>
            <a class="js-animation-link small font-weight-bold" href="{{ route('user.registration') }}">
                {{ translate('Sign Up') }}
            </a>

            {{-- <a class="js-animation-link small font-weight-bold" href="{{ route('business.register') }}">
                {{ translate('Business Sign Up') }}
            </a> --}}
        </div>
    </div>
</div>
