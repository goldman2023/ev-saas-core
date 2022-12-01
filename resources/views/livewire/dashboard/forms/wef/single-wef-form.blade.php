@php
    // IMPORTANT: Seting key attr when calling livewire component, makes it reactive inside parent livewire component (when property of parent lw component changes)
    $wef_form_id = 'wef-single-form-'.\Str::slug($formType).'-'.(uniqid(!empty($subject) ? $subject->id : '')).'-'.$wefKey;
@endphp
<div class="w-full flex flex-col {{ $class }}" x-data="{
    show_form: @entangle('showForm').defer,
    form_type: @js($formType),
    template: @js($template),
    wef_key: @js($wefKey),
    wef_value: @entangle('wefValue').defer,
    wef_value_copy: @js($wefValue),
    wef_label: @js($wefLabel),
    custom_properties: @js($customProperties),
    predefined_items: @js($predefinedItems),
    save() {
        $wire.saveWEF();
    },
    get wef_form_key() {
        return '{{ $wef_form_id }}';
    },
}" 
    :id="wef_form_key"
    wire:ignore>
    @php
        if($positioning == 'vertical') {
            $form_element_wrapper_class = 'grid grid-cols-1 sm:gap-y-4 sm:items-start';
            $form_element_label_class = '!text-16 !font-bold';
        } else {
            $form_element_wrapper_class = 'grid grid-cols-1 sm:grid-cols-3 sm:gap-4 sm:items-start';
            $form_element_label_class = '';
        }
    @endphp

    {{-- Plain Text --}}
    <template x-if="form_type === 'plain_text'">
        <div class="{{ $form_element_wrapper_class }}" x-data="{}">
            <label class="flex items-center flex-wrap text-sm font-medium text-gray-700 {{ $form_element_label_class }}" >
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

    {{-- Textarea --}}
    <template x-if="form_type === 'textarea'">
        <div class="{{ $form_element_wrapper_class }}" x-data="{}">
            <label class="flex items-center flex-wrap text-sm font-medium text-gray-700 {{ $form_element_label_class }}" >
                <span x-text="wef_label"></span>

                <button class="text-underline ml-2 text-sky-500 hover:text-sky-800 text-12 mt-0.5"
                    @click="show_form = !show_form" x-show="!show_form">({{ translate('Edit') }})</button>
                
                <button class="text-underline ml-2 text-red-500 hover:text-red-800 text-12 mt-0.5"
                    @click="show_form = !show_form" x-show="show_form">({{ translate('Close') }})</button>
            </label>

            <div class="mt-1 sm:mt-0 sm:col-span-2">
                <template x-if="show_form">
                    <textarea type="text" :rows="WEF.getTextareaRows(custom_properties)" class="form-standard" x-model="wef_value" ></textarea>
                </template>

                <template x-if="!show_form">
                    <p class="text-14 " x-text="wef_value"></p>
                </template>
            </div>
        </div>
    </template>
    {{-- END Textarea --}}

    {{-- Number --}}
    <template x-if="form_type === 'number'">
        <div class="{{ $form_element_wrapper_class }}" x-data="{}">

            <label class="flex items-center flex-wrap text-sm font-medium text-gray-700  {{ $form_element_label_class }}" >
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
        <div class="{{ $form_element_wrapper_class }}"
            x-init="$nextTick(() => { 
                flatpickr('#'+wef_form_key+' .js-flatpickr', WEF.getDateOptions(custom_properties)); 
            });">

            <label class="flex items-center flex-wrap text-sm font-medium text-gray-700  {{ $form_element_label_class }}" >
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


    {{-- Text List --}}
    <template x-if="form_type === 'text_list'">
        <div class="{{ $form_element_wrapper_class }}"
            x-data="{
                get count() {
                    if(wef_value === undefined || wef_value === null) {
                        wef_value = [''];
                    }

                    return wef_value.length;
                },
                add() {
                    if(this.count < WEF.getMaxRows(custom_properties)) {
                        wef_value.push('');
                    }
                },
                remove(index) {
                    wef_value.splice(index, 1);
                },
            }" x-init="
                $nextTick(() => {
                    if(WEF.getMinRows(custom_properties) > 1) {
                        for(let i = 1; i < WEF.getMinRows(custom_properties); i++) {
                            add();
                        }
                    }
                });
            ">
            <label class="flex items-center flex-wrap text-sm font-medium text-gray-700 {{ $form_element_label_class }}" >
                <span x-text="wef_label"></span>

                <button class="text-underline ml-2 text-sky-500 hover:text-sky-800 text-12 mt-0.5"
                    @click="show_form = !show_form" x-show="!show_form">({{ translate('Edit') }})</button>
                
                <button class="text-underline ml-2 text-red-500 hover:text-red-800 text-12 mt-0.5"
                    @click="show_form = !show_form" x-show="show_form">({{ translate('Close') }})</button>
            </label>

            <div class="mt-1 sm:mt-0 sm:col-span-2">
                
                <div class="w-full" x-show="show_form">
                    <template x-if="count <= 1">
                        <div class="flex w-full">
                            <input type="text" class="form-standard "
                                placeholder="{{ translate('Value 1') }}"
                                x-model="wef_value[0]" />
                        </div>
                    </template>
                    <template x-if="count > 1">
                        <template
                            x-for="(val, key) in wef_value"
                            :key="'we-text-list-'+wef_key+'-'+key">
    
                            <div class="flex" :class="{'mt-2': key > 0}">
                                <input type="text" class="form-standard"
                                    x-bind:placeholder="'{{ translate('Value') }} '+(Number(key)+1)"
                                    x-model="wef_value[key]" />
    
                                <template x-if="(key+1) > WEF.getMinRows(custom_properties)">
                                    <span class="ml-2 flex items-center cursor-pointer"
                                        @click="remove(key)">
                                        @svg('heroicon-o-trash', ['class' => 'w-[22px] h-[22px] text-danger'])
                                    </span>
                                </template>
                            </div>
                        </template>
                    </template>

                    <div href="javascript:;" class="btn-ghost !pl-0 !text-14 mt-1"
                        @click="add()" x-show="count < WEF.getMaxRows(custom_properties)">
                        @svg('heroicon-o-plus', ['class' => 'h-3 w-3 mr-2'])
                        {{ translate('Add new') }}
                    </div>
                </div>
                
                <template x-if="!show_form && count > 0">
                    <p class="text-14 " x-text="wef_value.join(', ')"></p>
                </template>

            </div>
        </div>
    </template>
    {{-- END Text List --}}
    

    {{-- Dropdown --}}
    <template x-if="form_type === 'dropdown'">
        <div class="{{ $form_element_wrapper_class }}"
            x-data="{
                items: predefined_items,
                show_dropdown: false,
                multiple: objectHasProperty(custom_properties, 'multiple') && custom_properties.multiple,
                tag: false,
                countSelected() {
                    if(wef_value === undefined || wef_value === null) {
                        wef_value = [];
                    }

                    return wef_value.length;
                },
                getPlaceholder() {
                    if(this.countSelected() === 1) {
                        if(objectHasProperty(this.items, wef_value[0])) {
                            return this.items[wef_value[0]];
                        }
                        
                        return '';
                    } else if(this.countSelected() > 1) {
                        return '';
                    } else {
                        return '{{ translate('Choose option(s)') }}';
                    }
                },
                isSelected(key) {
                    return wef_value.indexOf(key) !== -1 ? true : false;
                },
                select(key, label) {
                    if(this.isSelected(key)) {
                        wef_value.splice(wef_value.indexOf(key), 1);
                    } else {
                        if(!this.multiple) {
                            wef_value = [key];
                        } else {
                            wef_value.push(key);
                        }
                    }

                    if(!this.multiple) {
                        this.show_dropdown = false;
                        this.placeholder = label;
                    }
                },
                getSelected() {
                    let selected_items = {};

                    wef_value.forEach((key, index) => {
                        if(objectHasProperty(this.items, key)) {
                            selected_items[key] = this.items[key];
                        }
                    });

                    return selected_items;
                }
            }">

            <label class="flex items-center flex-wrap text-sm font-medium text-gray-700 {{ $form_element_label_class }}" >
                <span x-text="wef_label"></span>

                <button class="text-underline ml-2 text-sky-500 hover:text-sky-800 text-12 mt-0.5"
                    @click="show_form = !show_form" x-show="!show_form">({{ translate('Edit') }})</button>
                
                <button class="text-underline ml-2 text-red-500 hover:text-red-800 text-12 mt-0.5"
                    @click="show_form = !show_form" x-show="show_form">({{ translate('Close') }})</button>
            </label>

            <div class="mt-1 sm:mt-0 sm:col-span-2" >

                <div class="we-select relative w-full" x-data="{}" @click.outside="show_dropdown = false" x-show="show_form">
                    <div class="we-select__selector select-none w-full flex flex-wrap border pl-3 pt-2 pb-1 pr-6 relative cursor-pointer"
                        @click="show_dropdown = !show_dropdown">
                        
                        @svg('heroicon-o-chevron-down', ['class' =>
                        'we-select__selector-arrow absolute w-[16px] h-[16px]
                        vertical-center', ':class' => "{'rotate-180': show_dropdown}"])

                        <template x-if="!multiple">
                            <span class="block pb-1" x-text="getPlaceholder()"></span>
                        </template>

                        <template x-if="multiple">
                            <div class="w-full flex flex-wrap">
                                <template x-if="countSelected() > 0">
                                    <template x-for="(item, key) in getSelected()" :key="'we-select__selector-selected-item-'+key">
                                        <div
                                            class="we-select__selector-selected-item rounded mr-2 mb-1 relative">
                                            <span
                                                class="we-select__selector-selected-item-label pl-1 mr-1" x-text="item"></span>
                                            <button type="button"
                                                class="we-select__selector-selected-item-remove px-2"
                                                @click="event.stopPropagation(); select(key, item)">
                                                <span>×</span>
                                            </button>
                                        </div>
                                    </template>
                                </template>
                                <template x-if="countSelected() <= 0">
                                    <span class="block pb-1"
                                        x-text="getPlaceholder()"></span>
                                </template>
                            </div>
                        </template>
                    </div>

                    <div class="we-select__dropdown  absolute bg-white shadow border rounded mt-1  w-full"
                        x-show="show_dropdown">
                        <ul class="we-select__dropdown-list select-none w-full">
                            <template x-for="(item, key) in items" :key="'we-select__dropdown-list-item-'+key">
                                <li class="we-select__dropdown-list-item py-2 px-3 cursor-pointer"
                                    x-text="item"
                                    :class="{'selected': isSelected(key) }"
                                    @click="select(key, item)"></li>
                            </template>
                        </ul>
                    </div>
                </div>

                <template x-if="!show_form && countSelected() > 0">
                    <div class="flex flex-wrap gap-3">
                        <template x-for="(key, index) in wef_value" :key="'we-select__selector-selected-item-display-'+key">
                            <div class="text-14 border border-gray-300 rounded-lg py-1 px-2" x-text="items[key]"></div>
                        </template>
                    </div>
                    
                </template>
            </div>
        </div>
    </template>
    {{-- END Dropdown --}}

    {{-- TODO: Checkbox, Radio, WYSIWYG --}}
    {{-- <template x-if="form_type === 'checkbox'">
        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
            x-data="{}">

            <label class="flex items-center flex-wrap text-sm font-medium text-gray-700" >
                <span x-text="wef_label"></span>

                <button class="text-underline ml-2 text-sky-500 hover:text-sky-800 text-12 mt-0.5"
                    @click="show_form = !show_form" x-show="!show_form">({{ translate('Edit') }})</button>
                
                <button class="text-underline ml-2 text-red-500 hover:text-red-800 text-12 mt-0.5"
                    @click="show_form = !show_form" x-show="show_form">({{ translate('Close') }})</button>
            </label>

            <div
                class="mt-1 sm:mt-0 sm:col-span-2 flex flex-col rounded-md shadow-sm space-y-4">
                <template
                    x-for="(item, key) in predefined_items"
                    :key="'wef-checkbox-'+wef_key+'-'+key">

                    <div class="relative flex items-center ">
                        <div class="flex items-center h-6">
                            <input type="checkbox"
                                x-model="wef_value"
                                :value="key"
                                :id="'wef-checkbox-'+wef_key+'-'+key"
                                class="form-checkbox-standard">
                        </div>
                        <div class="ml-3 text-sm">
                            <label class="font-medium text-gray-700 cursor-pointer"
                                x-text="item"
                                :for="'wef-checkbox-'+wef_key+'-'+key"></label>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </template> --}}
    {{-- END Checkbox --}}

    <div class="w-full flex justify-end pt-2 pr-1" x-show="show_form">
        <button class="text-underline ml-2 text-green-500 hover:text-green-800 text-12 mt-0.5" @click="save()" >
            {{ translate('Save') }}
        </button>
    </div>
</div>