<form action="#" method="POST" class="relative mt-6 grid grid-cols-1 gap-y-4 sm:grid-cols-2 sm:gap-x-6" x-data="{
    consent: @js($consent ?? 'false')
}" wire:submit.prevent="contactUs()" wire:loading.class="opacity-30 pointer-events-none">
    <x-ev.loaders.spinner class="absolute-center z-10 hidden" wire:loading.class.remove="hidden"></x-ev.loaders.spinner>

    <div>
        <label for="first-name" class="block text-sm font-medium text-gray-900">{{ translate('First name') }}</label>
        <div class="mt-1">
            <x-dashboard.form.input field="first_name" />
        </div>
    </div>
    <div>
        <label for="last-name" class="block text-sm font-medium text-gray-900">{{ translate('Last name') }}</label>
        <div class="mt-1">
            <x-dashboard.form.input field="last_name" />
        </div>
    </div>
    <div class="sm:col-span-2">
        <label for="email" class="block text-sm font-medium text-gray-900">Email</label>
        <div class="mt-1">
            <x-dashboard.form.input field="email" type="email" input-class="w-full" />
        </div>
    </div>
    {{-- <div>
        <div class="flex justify-between">
            <label for="phone" class="block text-sm font-medium text-gray-900">Phone</label>
            <span id="phone-optional" class="text-sm text-gray-500">Optional</span>
        </div>
        <div class="mt-1">
            <input type="text" name="phone" id="phone" autocomplete="tel"
                class="py-3 px-4 block w-full shadow-sm text-gray-900 focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md"
                aria-describedby="phone-optional">
        </div>
    </div> --}}
    <div class="sm:col-span-2">
        <label for="subject" class="block text-sm font-medium text-gray-900">Subject</label>
        <div class="mt-1">
            <x-dashboard.form.input field="subject" type="text" input-class="w-full" />
        </div>
    </div>
    <div class="sm:col-span-2">
        <div class="flex justify-between">
            <label for="message" class="block text-sm font-medium text-gray-900">{{ translate('Message') }}</label>
            {{-- <span id="message-max" class="text-sm text-gray-500">Max. 500 characters</span> --}}
        </div>
        <div class="mt-1">
            <textarea wire:model.defer="message" rows="4"
                class="@error('message') is-invalid @enderror py-3 px-4 block w-full shadow-sm text-gray-900 border border-gray-300 rounded-md"></textarea>

            <x-system.invalid-msg field="message"></x-system.invalid-msg>
        </div>
    </div>
    <div class="sm:col-span-2">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <button type="button" @click="consent = !consent" :class="{'bg-primary':consent,'bg-gray-200':!consent}"
                    class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                    role="switch" aria-checked="false">
                    <span class="sr-only">Agree to policies</span>
                    <span aria-hidden="true" :class="{'translate-x-5':consent,'translate-x-0':!consent}"
                        class="inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                </button>
            </div>
            <div class="ml-3">
                <p class="text-base text-gray-500 @error('consent') text-danger @enderror cursor-pointer">
                    <span @click="consent = !consent">
                        {{ translate('I have read and accept the') }}
                    </span>
                    <a href="/privacy-policy-page/" target="_blank" class="font-medium text-primary underline">{{
                        translate('Privacy Policy') }}</a>
                </p>
            </div>
        </div>

        <x-system.invalid-msg field="consent"></x-system.invalid-msg>
    </div>
    <div class="sm:col-span-2 sm:flex sm:justify-start">
        <button type="submit" class="mt-2 btn-primary" @click="$wire.set('consent', consent, true);">Submit</button>
    </div>
</form>
