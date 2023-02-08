<div class="w-full relative">
    <x-ev.loaders.spinner class="absolute-center z-10 hidden"
                              wire:target="forgotPassword"
                              wire:loading.class.remove="hidden"></x-ev.loaders.spinner>

    <div class=""
            wire:loading.class="opacity-30 pointer-events-none"
            wire:target="forgotPassword"
    >

        <div class="mb-4">
            <label class="block text-16 font-medium text-gray-700">{{ translate('Email') }}</label>

            <div class="mt-1 relative rounded-md shadow-sm">
                <x-dashboard.form.input field="email">
                    {{-- <x-system.invalid-icon field="email"/> --}}
                </x-dashboard.form.input>
            </div>
        </div>

        <div class="mb-3">
            <button type="button"
                    class="btn-primary w-full justify-center" wire:click="forgotPassword()"
                    data-test="we-reset-password-submit">
                {{ translate('Submit')}}
            </button>
        </div>

        @if(get_tenant_setting('disable_user_registration') !== true)
            <div class="text-center">
                <span class="text-12 w-full text-muted">{{ translate('Do not have an account?') }}</span>
                <a class="text-12 font-semibold text-primary" href="{{ route('user.registration') }}">
                    {{ translate('Sign Up') }}
                </a>
            </div>
        @endif
    </div>
</div>
