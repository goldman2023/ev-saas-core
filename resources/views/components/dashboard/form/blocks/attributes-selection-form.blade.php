@php
    $attribute = $attributesField."[attribute_key]";
    $selected_items = $selectedAttributesField."[attribute_key]";
@endphp
<div class="w-full" 
        :key="'{{ $formId }}'"
        wire:ignore
        x-data="{
            form_id: @js($formId),
            resetAttributesForm() {
                for(const attribute_key in {{ $attributesField }}) {
                    if(!{{ $attribute }}.is_predefined) {
                        {{ $attribute }}.attribute_values[0].id = null;
                        {{ $attribute }}.attribute_values[0].values = '';
                    } else {
                        for(let i = 0; i < {{ $attribute }}.attribute_values.length; i++ ) {
                            {{ $attribute }}.attribute_values[i].selected = false;
                        }
                    }
                }

                for(const attribute_key in {{ $selectedAttributesField }}) {
                    {{ $selected_items }} = [];
                }
            },
            {{-- Attribute specific functions --}}
            getSelectorID(field) {
                return 'attributes_'+field.id+'_attribute_values';
            },
            hasCustomProperty(field, name) {
                return field.custom_properties !== null &&
                        field.custom_properties !== undefined &&
                        typeof field.custom_properties === 'object' &&
                        !Array.isArray(field.custom_properties) &&
                        field.custom_properties.hasOwnProperty(name);
            },
            getMinValue(field) {
                return this.hasCustomProperty(field, 'min_value') ? field.custom_properties.min_value : 0;
            },
            getMaxValue(field) {
                return this.hasCustomProperty(field, 'max_value') ? field.custom_properties.max_value : 999;
            },
            getMinRows(field) {
                return this.hasCustomProperty(field, 'min_rows') ? field.custom_properties.min_rows : 0;
            },
            getMaxRows(field) {
                return this.hasCustomProperty(field, 'max_rows') ? field.custom_properties.max_rows : 999;
            },
        }"
        @reset-attributes-form.window="if($event.detail.form_id === form_id) resetAttributesForm();">
    <template x-for="(attribute, attribute_key) in {{ $attributesField }}">
        
        <div class="w-full mb-3" x-data="{}" x-cloak>
    
            {{-- Dropdown --}}
            <template x-if="{{ $attribute }}.type === 'dropdown'">
                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 "
                    x-data="{
                        items: {{ $attribute }}.attribute_values,
                        {{-- selected_items: {{ $selected_items }}, --}}
                        show: false,
                        multiple: hasCustomProperty({{ $attribute }}, 'multiple') && {{ $attribute }}.custom_properties.multiple,
                        tag: false,
                        countSelected() {
                            if({{ $selected_items }} === undefined || {{ $selected_items }} === null) {
                                {{ $selected_items }} = [];
                            }
    
                            return {{ $selected_items }}.length;
                        },
                        getPlaceholder() {
                            if(this.countSelected() === 1) {
                                return this.items.find(x => {
                                    return x.id == {{ $selected_items }}[0];
                                }).values || '';
                            } else if(this.countSelected() > 1) {
                                return '';
                            } else {
                                return '{{ translate('Choose option(s)') }}';
                            }
                        },
                        isSelected(key) {
                            return {{ $selected_items }}.indexOf(key) !== -1 ? true : false;
                        },
                        select(key, label) {
                            if(this.isSelected(key)) {
                                {{ $selected_items }}.splice({{ $selected_items }}.indexOf(key), 1);
                            } else {
                                if(!this.multiple) {
                                    {{ $selected_items }} = [key];
                                } else {
                                    {{ $selected_items }}.push(Number(key));
                                }
                            }
    
                            if(!this.multiple) {
                                this.show = false;
                                this.placeholder = label;
                            }
                        }
                    }">
                    <div
                        class="justify-center h-full col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                        <span class="text-sm font-medium text-gray-900"
                            x-text="{{ $attribute }}.name"></span>
                    </div>
    
                    <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full">
    
                        <div class="we-select relative w-full" x-data="{}"
                            @click.outside="show = false">
                            <div class="we-select__selector select-none w-full flex flex-wrap border pl-3 pt-2 pb-1 pr-6 relative cursor-pointer"
                                @click="show = !show">
                                @svg('heroicon-o-chevron-down', ['class' =>
                                'we-select__selector-arrow absolute w-[16px] h-[16px]
                                vertical-center', ':class' => "{'rotate-180': show}"])
    
                                <template x-if="!multiple">
                                    <span class="block pb-1" x-text="getPlaceholder()"></span>
                                </template>
    
                                <template x-if="multiple">
                                    <div class="w-full flex flex-wrap">
                                        <template x-if="countSelected() > 0">
                                            <template x-for="(item, index) in items.filter(x => {
                                                return {{ $selected_items }}.indexOf(x.id) !== -1;
                                            })" :key="'we-select__selector-selected-item-'+item.id+'-'+index">
                                                <div
                                                    class="we-select__selector-selected-item rounded mr-2 mb-1 relative">
                                                    <span
                                                        class="we-select__selector-selected-item-label pl-1 mr-1"
                                                        x-text="item.values"></span>
                                                    <button type="button"
                                                        class="we-select__selector-selected-item-remove px-2"
                                                        @click="event.stopPropagation(); select(item.id, item.values)">
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
                                x-show="show">
                                <ul class="we-select__dropdown-list select-none w-full">
                                    <template x-for="(item, index) in items" :key="'we-select__dropdown-list-item-'+item.id+'-'+index">
                                        <li class="we-select__dropdown-list-item py-2 px-3 cursor-pointer"
                                            x-text="item.values"
                                            :class="{'selected': isSelected(item.id) }"
                                            @click="select(item.id, item.values)"></li>
                                    </template>
                                </ul>
                            </div>
                        </div>
    
                        @if(!$noVariations)
                            <template x-if="hasCustomProperty({{ $attribute }}, 'multiple') && {{ $attribute }}.custom_properties.multiple">
                                <!-- Used for variations? -->
                                <div class="flex items-center pt-3 " x-data="{}">
                                    <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                        <span class="text-sm font-medium text-gray-900">{{
                                            translate('Used for variations') }}</span>
                                    </div>
    
                                    <div
                                        class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
    
                                        <button type="button"
                                            @click="{{ $attribute }}.for_variations = !{{ $attribute }}.for_variations"
                                            :class="{'bg-primary':{{ $attribute }}.for_variations, 'bg-gray-200':!{{ $attribute }}.for_variations}"
                                            class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                                            role="switch">
                                            <span
                                                :class="{'translate-x-5':{{ $attribute }}.for_variations, 'translate-x-0':!{{ $attribute }}.for_variations}"
                                                class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                        </button>
                                    </div>
                                </div>
                                <!-- END Used for variations? -->
                            </template>
                        @endif
                        
                    </div>
                </div>
            </template>
            {{-- END Dropdown --}}
    
    
            {{-- Plain Text --}}
            <template x-if="{{ $attribute }}.type === 'plain_text'">
                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                    x-data="{}">
    
                    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"
                        x-text="{{ $attribute }}.name"></label>
    
                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                        <input type="text" class="form-standard"
                            :id="'attributes_'+{{ $attribute }}.id+'_attribute_values'"
                            x-model="{{ $attribute }}.attribute_values[0].values" />
                    </div>
                </div>
            </template>
            {{-- END Plain Text --}}
    
            {{-- Number --}}
            <template x-if="{{ $attribute }}.type === 'number'">
                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                    x-data="{}">
    
                    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"
                        x-text="{{ $attribute }}.name"></label>
    
                    <div class="mt-1 sm:mt-0 sm:col-span-2 flex rounded-md shadow-sm">
                        <input type="number"
                            :id="'attributes_'+{{ $attribute }}.id+'_attribute_values'"
                            x-bind:min="getMinValue({{ $attribute }})" x-bind:max="getMaxValue({{ $attribute }})"
                            x-model="{{ $attribute }}.attribute_values[0].values"
                            class="form-standard !rounded-r-none">
    
                        <template x-if="hasCustomProperty({{ $attribute }}, 'unit')">
                            <span x-text="{{ $attribute }}.custom_properties.unit"
                                class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm"></span>
                        </template>
                    </div>
                </div>
            </template>
            {{-- END Number --}}
    
    
            {{-- Date --}}
            <template x-if="{{ $attribute }}.type === 'date'">
                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                    x-data="{
                        getDateOptions() {
                            let options = {
                                mode: 'single',
                                enableTime: false,
                            };
    
                            if(this.hasCustomProperty({{ $attribute }}, 'with_time') && {{ $attribute }}.custom_properties.with_time) {
                                options.enableTime = true;
                                options.dateFormat = 'd.m.Y H:i';
                            } else {
                                options.dateFormat = 'd.m.Y';
                            }
    
                            if(this.hasCustomProperty({{ $attribute }}, 'range') && {{ $attribute }}.custom_properties.range) {
                                options.mode = 'range';
                            }
    
                            return options;
                        },
                    }"
                    x-init="$nextTick(() => { flatpickr('.js-flatpickr', getDateOptions()); });">
    
                    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"
                        x-text="{{ $attribute }}.name"></label>
    
                    <div class="mt-1 sm:mt-0 sm:col-span-2 flex rounded-md shadow-sm">
                        <input x-model="{{ $attribute }}.attribute_values[0].values" type="text"
                            class="js-flatpickr flatpickr-custom form-standard"
                            placeholder="{{ translate('Pick a date(s)') }}" data-input />
                    </div>
                </div>
            </template>
            {{-- END Date --}}
    
    
            {{-- Checkbox --}}
            <template x-if="{{ $attribute }}.type === 'checkbox'">
                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                    x-data="{}">
    
                    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"
                        x-text="{{ $attribute }}.name"></label>
    
                    <div
                        class="mt-1 sm:mt-0 sm:col-span-2 flex flex-col rounded-md shadow-sm space-y-4">
                        <template
                            x-for="(attribute_value, index) in {{ $attribute }}.attribute_values"
                            :key="'we-checkbox-'+attribute_value.id+'-'+index">

                            <div class="relative flex items-center "
                                :class="{'!mt-0': index === 0}">
                                <div class="flex items-center h-6">
                                    <input type="checkbox"
                                        x-model="{{ $selected_items }}"
                                        :value="attribute_value.id"
                                        :id="'attribute_'+attribute_value.id"
                                        class="form-checkbox-standard">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label class="font-medium text-gray-700 cursor-pointer"
                                        x-text="attribute_value.values"
                                        :for="'attribute_'+attribute_value.id"></label>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </template>
            {{-- END Checkbox --}}
    
            {{-- Radio --}}
            <template x-if="{{ $attribute }}.type === 'radio'">
                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                    x-data="{}">
    
                    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"
                        x-text="{{ $attribute }}.name"></label>
    
                    <div
                        class="mt-1 sm:mt-0 sm:col-span-2 flex flex-col rounded-md shadow-sm space-y-4">
                        <template
                            x-for="(attribute_value, index) in {{ $attribute }}.attribute_values"
                            :key="'we-radio-'+attribute_value.id+'-'+index">

                            <div class="relative flex items-center "
                                :class="{'!mt-0': index === 0}">
                                <div class="flex items-center h-6">
                                    <input type="radio"
                                        x-model="{{ $selected_items }}"
                                        :value="attribute_value.id"
                                        :id="'attribute_'+attribute_value.id"
                                        class="form-radio-standard">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label class="font-medium text-gray-700 cursor-pointer"
                                        x-text="attribute_value.values"
                                        :for="'attribute_'+attribute_value.id"></label>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </template>
            {{-- END Radio --}}
    
    
            {{-- Text List --}}
            <template x-if="{{ $attribute }}.type === 'text_list'">
                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                    x-data="{
                        items: {{ $attribute }}.attribute_values.map(x => x.values),
                        hasID(index) {
                            return {{ $attribute }}.attribute_values[index].hasOwnProperty('id') && !isNaN({{ $attribute }}.attribute_values[index].id) ? true : false;
                        },
                        count() {
                            if({{ $attribute }}.attribute_values === undefined || {{ $attribute }}.attribute_values === null) {
                                {{ $attribute }}.attribute_values = [{
                                    values: ''
                                }];
                            }
    
                            return {{ $attribute }}.attribute_values.length;
                        },
                        add() {
                            if(this.count() < getMaxRows({{ $attribute }})) {
                                {{ $attribute }}.attribute_values.push({
                                    values: ''
                                });
                            }
                        },
                        remove(index) {
                            if(this.hasID(index)) {
                                $wire.removeAttributeValue({{ $attribute }}.attribute_values[index].id);
                            }
    
                            {{ $attribute }}.attribute_values.splice(index, 1);
                        },
                    }" x-init="
                        if(getMinRows({{ $attribute }}) > 1) {
                            for(let i=1; i < getMinRows({{ $attribute }}); i++) {
                                add();
                            }
                        }
                    ">
                    {{-- $watch('items', items => {
                    items.forEach((item, index) => {
                    if({{ $attribute }}.attribute_values[index] === undefined ||
                    {{ $attribute }}.attribute_values[index] === null) {
                    {{ $attribute }}.attribute_values[index] = {
                    values: item
                    };
                    } else {
                    {{ $attribute }}.attribute_values[index].values = item;
                    }
                    });
    
                    let diff = {{ $attribute }}.attribute_values.length - items.length;
    
                    if(diff > 0) {
                    Remove difference between {{ $attribute }}.attribute_values and mapped items.
                    {{ $attribute }}.attribute_values = {{ $attribute }}.attribute_values.slice(0, -(diff));
                    }
                    }); --}}
                    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"
                        x-text="{{ $attribute }}.name"></label>
    
                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                        <template x-if="count() <= 1">
                            <div class="flex w-full">
                                <input type="text" class="form-standard "
                                    placeholder="{{ translate('Value 1') }}"
                                    x-model="items[0]" />
                            </div>
                        </template>
                        <template x-if="count() > 1">
                            <template
                                x-for="(attribute_value, key) in {{ $attribute }}.attribute_values"
                                :key="'we-text-list-'+attribute_value.id+'-'+key">

                                <div class="flex" :class="{'mt-2': key > 0}">
                                    <input type="text" class="form-standard"
                                        :id="'attribute-'+{{ $attribute }}.id+'-text-list-input-'+key"
                                        x-bind:placeholder="'{{ translate('Value') }} '+(Number(key)+1)"
                                        x-model="attribute_value.values" />

                                    <template x-if="(key+1) > getMinRows({{ $attribute }})">
                                        <span class="ml-2 flex items-center cursor-pointer"
                                            @click="remove(key)">
                                            @svg('heroicon-o-trash', ['class' => 'w-[22px]
                                            h-[22px] text-danger'])
                                        </span>
                                    </template>
                                </div>
                            </template>
                        </template>
    
                        <div href="javascript:;" class="btn-ghost !pl-0 !text-14 mt-1"
                            @click="add()" x-show="count() < getMaxRows({{ $attribute }})">
                            @svg('heroicon-o-plus', ['class' => 'h-3 w-3 mr-2'])
                            {{ translate('Add new') }}
                        </div>
                    </div>
                </div>
            </template>
            {{-- END Text List --}}
    
            {{-- Image --}}
            <template x-if="{{ $attribute }}.type === 'image'">
                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                    x-data="{}">
    
                    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"
                        x-text="{{ $attribute }}.name"></label>
    
                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                        <div class="w-full" x-data="{
                            id: 'attributes_'+{{ $attribute }}.id+'_attribute_values',
                            file_name: '',
                        }" @we-media-selected-event.window="
                            if($event.detail.for_id === id) {
                                {{ $attribute }}.attribute_values[0].values = $event.detail.selected[0]['id'] || '';
                                file_name = $event.detail.selected[0]['file_name'] || '';
                            }
                        ">
                            <div class="max-w-lg flex justify-center border-2 border-gray-300 border-dashed rounded-md cursor-pointer"
                                :class="{'px-6 pt-5 pb-6': {{ $attribute }}.attribute_values[0].values !== undefined && {{ $attribute }}.attribute_values[0].values !== null && {{ $attribute }}.attribute_values[0].values > 0 }"
                                @click="$wire.emit('showMediaLibrary', id, 'image', [{id:{{ $attribute }}.attribute_values[0].values, file_name:file_name}])">
    
                                <template
                                    x-if="{{ $attribute }}.attribute_values[0].values !== undefined && {{ $attribute }}.attribute_values[0].values !== null && {{ $attribute }}.attribute_values[0].values > 0">
                                    <div class="h-[200px] w-full rounded cursor-pointer">
                                        <img class="w-full h-[200px] object-contain"
                                            x-bind:src="window.WE.IMG.url(file_name)" />
                                    </div>
                                </template>
    
                                <template
                                    x-if="!({{ $attribute }}.attribute_values[0].values !== undefined && {{ $attribute }}.attribute_values[0].values !== null && {{ $attribute }}.attribute_values[0].values > 0)">
                                    <div class="space-y-1 text-center py-7">
                                        <svg class="mx-auto h-12 w-12 text-gray-400"
                                            stroke="currentColor" fill="none"
                                            viewBox="0 0 48 48" aria-hidden="true">
                                            <path
                                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label
                                                class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                <span>{{ translate('Select a file') }}</span>
                                            </label>
                                            <p class="pl-1">{{ translate('or drag and drop') }}
                                            </p>
                                        </div>
                                        <p class="text-xs text-gray-500">{{ translate('PNG, JPG,
                                            GIF up to 3MB') }}</p>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            {{-- END Image --}}
    
            {{-- TODO: Add wysiwyg, gallery, country type attribute --}}
        </div>
    </template>
</div>
