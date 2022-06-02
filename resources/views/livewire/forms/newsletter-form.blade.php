<form class="mt-4 sm:flex sm:flex-col sm:max-w-md" wire:submit.prevent="subscribe()" wire:loading.class="opacity-30 pointer-events-none" x-data="{
    consent: @js($consent ?? 'false')
}">
    
    <div class="sm:flex mb-2">
        <x-dashboard.form.input field="email" type="email" placeholder="{{ translate('Enter your email') }}" />

        <div class="flex sm:hidden relative items-start mt-3">
            <div class="flex items-center h-5">
              <input id="newsletter-form-consent-mobile" x-model="consent" type="checkbox" class="focus:ring-primary h-4 w-4 text-primary border-gray-300 rounded">
            </div>
            <div class="ml-3 text-sm">
              <label for="newsletter-form-consent-mobile" wire:model:defer="consent" class="font-medium text-gray-300 select-none @error('consent') text-danger @enderror">{{ translate('I agree to receiving newsletter') }}</label>
            </div>
        </div>

        <div class="mt-3 rounded-md sm:mt-0 sm:ml-3 sm:flex-shrink-0">
          <button type="submit" class="sm:w-full btn-primary" @click="$wire.set('consent', consent, true);">
              {{ translate('Subscribe') }}
          </button>
        </div>
    </div>

    <div class="hidden sm:flex relative items-start">
        <div class="flex items-center h-5">
          <input id="newsletter-form-consent" x-model="consent" type="checkbox" class="focus:ring-primary h-4 w-4 text-primary border-gray-300 rounded">
        </div>
        <div class="ml-3 text-sm">
          <label for="newsletter-form-consent" wire:model:defer="consent" class="font-medium text-gray-300 select-none @error('consent') text-danger @enderror">{{ translate('I agree to receiving newsletter') }}</label>
        </div>
    </div>
</form>