@push('head_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jsoneditor/9.9.0/jsoneditor.min.js" integrity="sha512-WuimD+3eJ3qkskeMQiQZesaYjwyBiTN2Xg2tI60IDp5jx402/u8lLZAqCgAei92NInz0Jn+xYqJKYCbxic4hIA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsoneditor/9.9.0/jsoneditor.min.css" integrity="sha512-8ca3Rhl1VGRZ72Vjj35LcQasrUEZZLknd2qJF/RDQocmA/4q/v5gD3H7NZtZ2ssfkN6VqDuzKqYdeaT0YUubZw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

<div class="relative w-full" x-data="{
    license: @entangle('license').defer,
    license_data: @entangle('license_data').defer,
}" 
wire:loading.class="opacity-30 pointer-events-none"
@display-modal.window="
    if($event.detail.id === id) {
        $wire.setLicense($event.detail.license_id);
    }
">
    <x-ev.loaders.spinner class="absolute-center z-10 hidden" wire:loading.class.remove="hidden"></x-ev.loaders.spinner>


    <div class="w-full space-y-3">
        <!-- License Name-->
        <div class="flex flex-col" x-data="{}">
            <label class="block text-sm font-medium text-gray-900 mb-2">
                {{ translate('License Name') }}
            </label>

            <div class="mt-1 sm:mt-0 sm:col-span-2">
                <x-dashboard.form.input field="license.license_name" :x="true" />
            </div>
        </div>
        <!-- END License Name -->

        <!-- Serial Number-->
        <div class="flex flex-col" x-data="{}">
            <label class="block text-sm font-medium text-gray-900 mb-2">
                {{ translate('Serial Number') }}
            </label>

            <div class="mt-1 sm:mt-0 sm:col-span-2">
                <x-dashboard.form.input field="license.serial_number" :x="true" :disabled="true" />
            </div>
        </div>
        <!-- END Serial Number -->

        <!-- License Type-->
        <div class="flex flex-col" x-data="{}">
            <label class="block text-sm font-medium text-gray-900 mb-2">
                {{ translate('License Type') }}
            </label>

            <div class="mt-1 sm:mt-0 sm:col-span-2">
                <x-dashboard.form.input field="license.license_type" :x="true" />
            </div>
        </div>
        <!-- END License Type -->

        <!-- License Type-->
        <div class="flex flex-col" x-data="{}">
            <label class="block text-sm font-medium text-gray-900 mb-2">
                {{ translate('License Data') }}
            </label>

            <div class="mt-1 sm:mt-0 sm:col-span-2">
                <x-dashboard.form.json-editor field="license_data" id="license-data-json-editor" />
            </div>
        </div>
        <!-- END License Type -->
    </div>

    <div class="w-full flex justify-end mt-4" x-data="{}">
        <button type="button" class="btn btn-primary ml-auto btn-sm" wire:click="save()">
            {{ translate('Save') }}
        </button>
    </div>
</div>