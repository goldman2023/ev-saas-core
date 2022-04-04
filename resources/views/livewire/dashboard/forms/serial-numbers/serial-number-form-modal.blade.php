<div class="fixed z-50 inset-0 overflow-y-auto" x-data="{
        show: @entangle('show').defer,
        id: 'serial-number-form-modal',
        status: @js($serialNumber->status ?? \App\Enums\SerialNumberStatusEnum::in_stock()->value),
    }"
    @modal-show.window="
        if($event.detail.id === id) {
            show = true;
            $wire.loadSerialNumber($event.detail.serial_number_id || null);
        }
    "
    x-show="show"
    x-cloak>
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                x-show="show"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="oapcity-100"
                x-transition:leave="ease-out duration-300"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"></div>

        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>


        <div class="relative inline-block align-bottom divide-y divide-gray-200 bg-white rounded-lg text-left shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full"
                x-on:click.outside="show = false"
                x-show="show"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-out duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            
            <div class="px-4 py-4 sm:px-5">
                <strong class="text-18">{{ empty($serialNumber->id) ? translate('Create new serial number') : translate('Serial number') }}</strong>
            </div>
            <div class="px-4 py-5 sm:p-6">
                {{-- Serial Number --}}
                <div class="flex flex-col" x-data="{}">
                    <label class="block text-sm font-medium text-gray-700">
                        {{ translate('Serial Number') }}
                    </label>
    
                    <div class="mt-1 sm:mt-2 ">
                        <input type="text" class="form-standard @error('serialNumber.serial_number') is-invalid @enderror"
                                wire:model.defer="serialNumber.serial_number" />

                        <x-system.invalid-msg field="serialNumber.serial_number"></x-system.invalid-msg>
                    </div>
                </div>
                {{-- END Serial Number --}}

                <!-- Status -->
                <div class="flex flex-col sm:pt-5">
                    <label class="block text-sm font-medium text-gray-700">
                        {{ translate('Status') }}
                    </label>

                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                        <x-dashboard.form.select :items="\App\Enums\SerialNumberStatusEnum::labels()" field="serialNumber.status" selected="status" :nullable="false"></x-dashboard.form.select>
                    </div>
                </div>
                <!-- END Status -->
            </div>
            <div class="flex justify-end px-4 py-4 sm:px-6">
                <button type="button" class="btn-ghost" @click="show = false">
                    <span>{{ translate('Cancel') }}</span>
                </button>
                <button type="button" class="btn-primary" @click="
                        $wire.set('serialNumber.status', status, true);
                    " 
                    wire:click="saveSerialNumber()">
                    <span>{{ translate('Save') }}</span>
                </button>
            </div>
        </div>
    </div>
</div>
