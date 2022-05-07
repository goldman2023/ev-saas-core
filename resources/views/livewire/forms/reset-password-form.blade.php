<div class="w-full relative">
    <x-ev.loaders.spinner class="absolute-center z-10 hidden"
                              wire:target="resetPassword"
                              wire:loading.class.remove="hidden"></x-ev.loaders.spinner>

    <div class=""
            wire:loading.class="opacity-30 pointer-events-none"
            wire:target="resetPassword"
    >

        <div class="mb-4">
            <label class="block text-16 font-medium text-gray-700">{{ translate('New Password') }}</label>

            <div class="mt-1 relative rounded-md shadow-sm">
                <x-dashboard.form.input field="new_password" type="password">
                    {{-- <x-system.invalid-icon field="email"/> --}}
                </x-dashboard.form.input>
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-16 font-medium text-gray-700">{{ translate('New Password Confirmation') }}</label>

            <div class="mt-1 relative rounded-md shadow-sm">
                <x-dashboard.form.input field="new_password_confirmation" type="password">
                    {{-- <x-system.invalid-icon field="email"/> --}}
                </x-dashboard.form.input>
            </div>
        </div>

        <div class="mb-3">
            <button type="button"
                    class="btn-primary w-full justify-center" wire:click="resetPassword()"
                    data-test="we-reset-password-submit">
                {{ translate('Reset')}}
            </button>
        </div>
    </div>
</div>
