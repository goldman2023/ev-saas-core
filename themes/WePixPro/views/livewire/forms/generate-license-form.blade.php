<div class="w-full" x-data="{
    serial_number: null,
    hw_id: null,
}" 
@display-modal.window="
    if($event.detail.id === id) {
        serial_number = $event.detail.serial_number;
    }
">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:divide-x">
        <div class="col-span-1">
            <!--Serial Number-->
            <div class="flex flex-col mb-3" x-data="{}">
                <label class="block text-sm font-medium text-gray-900 mb-2">
                    {{ translate('Serial Number') }}
                </label>

                <div class="mt-1 sm:mt-0 sm:col-span-2">
                    <x-dashboard.form.input field="serial_number" :x="true"/>
                </div>
            </div>
            <!-- END Serial Number -->

            <!--Hardware ID-->
            <div class="flex flex-col mb-3" x-data="{}">
                <label class="block text-sm font-medium text-gray-900 mb-2">
                    {{ translate('Hardware ID') }}
                </label>

                <div class="mt-1 sm:mt-0 sm:col-span-2">
                    <x-dashboard.form.input field="hw_id" :x="true"/>
                </div>
            </div>
            <!-- END Hardware ID -->
        </div>
        <div class="col-span-1 md:pl-5">
            <p class="">{{ translate('') }}</p>
        </div>
    </div>



    <div class="w-full flex justify-end mt-4" x-data="{}">
        <button type="button" class="btn btn-primary ml-auto btn-sm" @click="
            $wire.set('serial_number', serial_number, true);
            $wire.set('hw_id', hw_id, true);
        " wire:click="generate()">
            {{ translate('Activate') }}
        </button>
    </div>
</div>