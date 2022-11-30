<div class="w-full flex flex-col {{ $class }}" x-data="{
    show_form: @entangle('showForm').defer,
    form_type: @js($formType),
    template: @js($template),
    wef_key: @js($wefKey),
    wef_value: @entangle('wefValue').defer,
    wef_value_copy: @js($wefValue),
    wef_label: @js($wefLabel),
    custom_properties: @js($customProperties),
    save() {
        $wire.saveWEF();
    }
}">
    {{-- Plain Text --}}
    <template x-if="form_type === 'plain_text'">
        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start" x-data="{}">
            <label class="flex items-center flex-wrap text-sm font-medium text-gray-700" >
                <span x-text="wef_label"></span>

                <button class="text-underline ml-2 text-sky-500 hover:text-sky-800 text-12 mt-0.5"
                    @click="show_form = !show_form" x-show="!show_form">({{ translate('Edit') }})</button>
                
                <button class="text-underline ml-2 text-red-500 hover:text-red-800 text-12 mt-0.5"
                    @click="show_form = !show_form" x-show="show_form">({{ translate('Close') }})</button>
            </label>

            <div class="mt-1 sm:mt-0 sm:col-span-2">
                <template x-if="show_form">
                    <input type="text" class="form-standard" x-model="wef_value" />
                </template>

                <template x-if="!show_form">
                    <p class="text-14 " x-text="wef_value"></p>
                </template>
            </div>
        </div>
    </template>
    {{-- END Plain Text --}}

    {{-- Number --}}
    <template x-if="form_type === 'number'">
        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start" x-data="{}">

            <label class="flex items-center flex-wrap text-sm font-medium text-gray-700" >
                <span x-text="wef_label"></span>
                
                <button class="text-underline ml-2 text-sky-500 hover:text-sky-800 text-12 mt-0.5"
                    @click="show_form = !show_form" x-show="!show_form">({{ translate('Edit') }})</button>
                
                <button class="text-underline ml-2 text-red-500 hover:text-red-800 text-12 mt-0.5"
                    @click="show_form = !show_form" x-show="show_form">({{ translate('Close') }})</button>
            </label>

            <div class="mt-1 sm:mt-0 sm:col-span-2 flex rounded-md shadow-sm">

                <template x-if="show_form">
                    <div class="w-full flex rounded-md shadow-sm">
                        <input type="number"
                            x-bind:min="WEF.getMinValue(custom_properties)" x-bind:max="WEF.getMaxValue(custom_properties)"
                            x-model="wef_value"
                            class="form-standard !rounded-r-none">

                        <template x-if="objectHasProperty(custom_properties, 'unit')">
                            <span x-text="custom_properties.unit"
                                class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm"></span>
                        </template>
                    </div>
                </template>

                <template x-if="!show_form && wef_value != null">
                    <p class="text-14 " x-text="wef_value+custom_properties.unit"></p>
                </template>
                
            </div>
        </div>
    </template>
    {{-- END Number --}}

    {{-- Date --}}
    <template x-if="form_type === 'date'">
        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start"
            x-data="{
                getDateOptions() {
                    let options = {
                        mode: 'single',
                        enableTime: false,
                    };

                    if(objectHasProperty(custom_properties, 'with_time') && custom_properties.with_time) {
                        options.enableTime = true;
                        options.dateFormat = 'd.m.Y H:i';
                    } else {
                        options.dateFormat = 'd.m.Y';
                    }

                    if(objectHasProperty(custom_properties, 'range') && custom_properties.range) {
                        options.mode = 'range';
                    }

                    return options;
                },
            }"
            x-init="$nextTick(() => { flatpickr('.js-flatpickr', getDateOptions()); });">

            <label class="flex items-center flex-wrap text-sm font-medium text-gray-700" >
                <span x-text="wef_label"></span>

                <button class="text-underline ml-2 text-sky-500 hover:text-sky-800 text-12 mt-0.5"
                    @click="show_form = !show_form" x-show="!show_form">({{ translate('Edit') }})</button>
                
                <button class="text-underline ml-2 text-red-500 hover:text-red-800 text-12 mt-0.5"
                    @click="show_form = !show_form" x-show="show_form">({{ translate('Close') }})</button>
            </label>

            <div class="mt-1 sm:mt-0 sm:col-span-2 flex rounded-md shadow-sm">
                <input x-model="wef_value" type="text"
                    class="js-flatpickr flatpickr-custom form-standard"
                    placeholder="{{ translate('Pick a date(s)') }}" data-input x-show="show_form" />

                <template x-if="!show_form">
                    <p class="text-14 " x-text="wef_value"></p>
                </template>
            </div>
        </div>
    </template>
    {{-- END Date --}}

    
    <div class="w-full flex justify-end pt-2 pr-1" x-show="show_form">
        <button class="text-underline ml-2 text-green-500 hover:text-green-800 text-12 mt-0.5" @click="save()" >
            {{ translate('Save') }}
        </button>
    </div>
</div>