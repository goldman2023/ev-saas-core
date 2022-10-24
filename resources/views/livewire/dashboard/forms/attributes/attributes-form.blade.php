<div class="w-full" x-data="{
    predefined_types: @js(App\Enums\AttributeTypeEnum::getPredefined()),
    type: @js($attribute->type ?? App\Enums\AttributeTypeEnum::dropdown()->value),
    filterable: @js($attribute->filterable),
    is_schema: @js($attribute->is_schema),
    is_admin: @js($attribute->is_admin),
    custom_properties: {...{
        'multiple': false,
        'min_value': 0,
        'max_value': 0,
        'max_rows': 0,
        'min_rows': 0,
        'unit': '',
        'with_time': false,
        'range': false,
    }, ...@js($attribute->custom_properties ?? ((object) []))},
    attribute_values: @entangle('attribute_values').defer,
    countAttributeValues() {
        if(this.attribute_values === null || this.attribute_values === undefined || this.attribute_values.length <= 0) {
            this.attribute_values.push({
                values: '',
            });
        }

        return this.attribute_values.length;
    },
}" x-init="countAttributeValues()">
    {{-- FIXME: If $attribute->custom_properties is {} and not null, it will rise livewire checksum error on
    saveAttribute() --}}

    <div class="w-full relative">
        <x-ev.loaders.spinner class="absolute-center z-10 hidden" wire:target="saveAttribute"
            wire:loading.class.remove="hidden"></x-ev.loaders.spinner>

        <div class="w-full" wire:loading.class="opacity-30 pointer-events-none" wire:target="saveAttribute">

            <div class="grid grid-cols-12 gap-8 mb-10">
                {{-- Left side --}}
                <div class="col-span-8  ">
                    <div class="p-4 border bg-white border-gray-200 rounded-lg shadow">
                        <div class="w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-1">{{ translate('Attribute') }}
                            </h3>
                            <p class="flex items-center-1 max-w-2xl text-sm text-gray-500">
                                {{ translate('Current attribute is related to ').': ' }}
                                <span class="badge-info mx-1">{{ $content_type_label }}</span>
                                {{ translate('content type') }}
                            </p>
                        </div>

                        <div class="mt-6 sm:mt-3 space-y-6 sm:space-y-5">
                            <!-- Name -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                x-data="{}">

                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Name') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <input type="text"
                                        class="form-standard @error('attribute.name') is-invalid @enderror"
                                        placeholder="{{ translate('New attribute name') }}" {{--
                                        @input="generateURL($($el).val())" --}} wire:model.defer="attribute.name" />

                                    <x-system.invalid-msg field="attribute.name"></x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END Name -->

                            <!-- Type -->
                            <div
                                class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <label class="flex items-center text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    <span class="mr-2">{{ translate('Type') }}</span>
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <x-dashboard.form.select :items="\App\Enums\AttributeTypeEnum::labels()"
                                        selected="type"></x-dashboard.form.select>
                                </div>
                            </div>
                            <!-- END Type -->

                            <!-- Filterable -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                x-data="{}">
                                <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                    <span class="text-sm font-medium text-gray-900" id="availability-label">{{
                                        translate('Filterable') }}</span>
                                    <span class="text-sm text-gray-500" id="availability-description">{{ translate('All
                                        filterable attributes will be displayed in archive pages filter section')
                                        }}</span>
                                </div>

                                <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">

                                    <button type="button" @click="filterable = !filterable"
                                        :class="{'bg-primary':filterable, 'bg-gray-200':!filterable}"
                                        class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                                        role="switch">
                                        <span :class="{'translate-x-5':filterable, 'translate-x-0':!filterable}"
                                            class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                    </button>

                                    <x-system.invalid-msg field="attribute.filterable"></x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END Filterable -->

                            <!-- Is admin -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                x-data="{}">
                                <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                    <span class="text-sm font-medium text-gray-900" id="availability-label">{{
                                        translate('Is admin') }}</span>
                                    <span class="text-sm text-gray-500" id="availability-description">{{
                                        translate('Lorem ipsum olor sit amet') }}</span>
                                </div>

                                <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">

                                    <button type="button" @click="is_admin = !is_admin"
                                        :class="{'bg-primary':is_admin, 'bg-gray-200':!is_admin}"
                                        class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                                        role="switch">
                                        <span :class="{'translate-x-5':is_admin, 'translate-x-0':!is_admin}"
                                            class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                    </button>

                                    <x-system.invalid-msg field="attribute.is_admin"></x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END Is admin -->

                            <!-- Is schema -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                x-data="{}">
                                <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                    <span class="text-sm font-medium text-gray-900" id="availability-label">{{
                                        translate('Is schema') }}</span>
                                    <span class="text-sm text-gray-500" id="availability-description">{{ translate('All
                                        schema attributes will be used to populate corresponding Schema.org markup')
                                        }}</span>
                                </div>

                                <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">

                                    <button type="button" @click="is_schema = !is_schema"
                                        :class="{'bg-primary':is_schema, 'bg-gray-200':!is_schema}"
                                        class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                                        role="switch">
                                        <span :class="{'translate-x-5':is_schema, 'translate-x-0':!is_schema}"
                                            class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                    </button>

                                    <x-system.invalid-msg field="attribute.is_schema"></x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END Is schema -->

                            {{-- Is schema - key and value --}}
                            <div x-show="is_schema"
                                class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                x-data="{}">

                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Schema Key and Value') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-1">
                                    <input type="text"
                                        class="form-standard @error('attribute.schema_key') is-invalid @enderror"
                                        placeholder="{{ translate('Schema key') }}" {{--
                                        @input="generateURL($($el).val())" --}}
                                        wire:model.defer="attribute.schema_key" />

                                    <x-system.invalid-msg field="attribute.schema_key"></x-system.invalid-msg>
                                </div>
                                <div class="mt-1 sm:mt-0 sm:col-span-1">
                                    <input type="text"
                                        class="form-standard @error('attribute.schema_value') is-invalid @enderror"
                                        placeholder="{{ translate('Schema value') }}" {{--
                                        @input="generateURL($($el).val())" --}}
                                        wire:model.defer="attribute.schema_value" />

                                    <x-system.invalid-msg field="attribute.schema_value"></x-system.invalid-msg>
                                </div>
                            </div>
                            {{-- END Is schema - key and value --}}


                            <!-- Dropdown: Custom properties -->
                            <div x-show="type === 'dropdown'"
                                class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                x-data="{}">
                                <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                    <span class="text-sm font-medium text-gray-900" id="availability-label">{{
                                        translate('Multiple') }}</span>
                                    <span class="text-sm text-gray-500" id="availability-description">{{
                                        translate('Allow multiple dropdown selection') }}</span>
                                </div>

                                <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                    <button type="button"
                                        @click="custom_properties.multiple = !custom_properties.multiple"
                                        :class="{'bg-primary':custom_properties.multiple, 'bg-gray-200':!custom_properties.multiple}"
                                        class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                                        role="switch">
                                        <span
                                            :class="{'translate-x-5':custom_properties.multiple, 'translate-x-0':!custom_properties.multiple}"
                                            class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                    </button>
                                </div>
                            </div>
                            <!-- END Dropdown: Custom properties -->

                            <!-- Number Custom properties -->
                            <div x-show="type === 'number'" class="w-full">
                                <!-- Min. value -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                    x-data="{}">

                                    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                        {{ translate('Minimum value') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-1">
                                        <input type="number" class="form-standard"
                                            placeholder="{{ translate('Minimum value') }}"
                                            x-model="custom_properties.min_value" />
                                    </div>
                                </div>
                                <!-- END Min. value -->

                                <!-- Max. value -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5"
                                    x-data="{}">

                                    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                        {{ translate('Maximum value') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-1">
                                        <input type="number" class="form-standard"
                                            placeholder="{{ translate('Maximum value') }}"
                                            x-model="custom_properties.max_value" />
                                    </div>
                                </div>
                                <!-- END Max. value -->

                                <!-- Unit -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5"
                                    x-data="{}">

                                    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                        {{ translate('Unit') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <input type="text" class="form-standard" placeholder="{{ translate('Unit') }}"
                                            x-model="custom_properties.unit" />
                                    </div>
                                </div>
                                <!-- END Unit -->
                            </div>
                            <!-- END Number Custom properties -->

                            <!-- Date Custom properties -->
                            <div x-show="type === 'date'" class="w-full">
                                {{-- With time --}}
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                    x-data="{}">
                                    <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                        <span class="text-sm font-medium text-gray-900" id="availability-label">{{
                                            translate('With time') }}</span>
                                        <span class="text-sm text-gray-500" id="availability-description">{{
                                            translate('Include time along with date') }}</span>
                                    </div>

                                    <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">

                                        <button type="button"
                                            @click="custom_properties.with_time = !custom_properties.with_time"
                                            :class="{'bg-primary':custom_properties.with_time, 'bg-gray-200':!custom_properties.with_time}"
                                            class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                                            role="switch">
                                            <span
                                                :class="{'translate-x-5':custom_properties.with_time, 'translate-x-0':!custom_properties.with_time}"
                                                class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                        </button>

                                    </div>
                                </div>
                                {{-- END With time --}}

                                <!-- Range -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5"
                                    x-data="{}">
                                    <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                        <span class="text-sm font-medium text-gray-900" id="availability-label">{{
                                            translate('Is range') }}</span>
                                        <span class="text-sm text-gray-500" id="availability-description">{{
                                            translate('If enabled, date wil be a date range. From X to Y date.')
                                            }}</span>
                                    </div>

                                    <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                        <button type="button"
                                            @click="custom_properties.range = !custom_properties.range"
                                            :class="{'bg-primary':custom_properties.range, 'bg-gray-200':!custom_properties.range}"
                                            class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                                            role="switch">
                                            <span
                                                :class="{'translate-x-5':custom_properties.range, 'translate-x-0':!custom_properties.range}"
                                                class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                        </button>
                                    </div>
                                </div>
                                <!-- END Range -->
                            </div>
                            <!-- END Date Custom properties -->


                            <!-- Text Repeater custom properties-->
                            <div x-show="type === 'text_list'" class="w-full">
                                <!-- Min. value -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                    x-data="{}">

                                    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                        {{ translate('Minimum rows') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-1">
                                        <input type="number" class="form-standard" min="0"
                                            placeholder="{{ translate('Minimum rows') }}"
                                            x-model="custom_properties.min_rows" />
                                    </div>
                                </div>
                                <!-- END Min. value -->

                                <!-- Max. value -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5"
                                    x-data="{}">

                                    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                        {{ translate('Maximum rows') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-1">
                                        <input type="number" class="form-standard" min="0"
                                            placeholder="{{ translate('Maximum rows') }}"
                                            x-model="custom_properties.max_rows" />
                                    </div>
                                </div>
                                <!-- END Max. value -->
                            </div>
                            <!-- END Text Repeater custom properties-->


                            <div class="w-full sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5">
                                <div class="w-full flex justify-end">
                                    <button type="button" class="btn btn-primary ml-auto" @click="
                                                $wire.set('attribute.custom_properties', custom_properties, true);
                                                $wire.set('attribute.type', type, true);
                                                $wire.set('attribute.is_schema', is_schema, true);
                                                $wire.set('attribute.is_admin', is_admin, true);
                                                $wire.set('attribute.filterable', filterable, true);
                                            " wire:click="saveAttribute()">
                                        {{ translate('Save') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Right side --}}
                <div class="col-span-4">
                    {{-- Actions --}}
                    <div class="p-4 border bg-white border-gray-200 rounded-lg shadow">
                        <div class="w-full flex">

                            <button type="button" class="btn btn-primary ml-auto" @click="
                                    $wire.set('attribute.custom_properties', custom_properties, true);
                                    $wire.set('attribute.type', type, true);
                                    $wire.set('attribute.is_schema', is_schema, true);
                                    $wire.set('attribute.is_admin', is_schema, true);
                                    $wire.set('attribute.filterable', is_schema, true);
                                " wire:click="saveAttribute()">
                                {{ translate('Save') }}
                            </button>
                        </div>
                    </div>
                    {{-- END Actions --}}

                    @if($is_update && in_array($attribute->type, App\Enums\AttributeTypeEnum::getPredefined()))
                    {{-- Attribute Values --}}
                    <div class="mt-8 border bg-white border-gray-200 rounded-lg shadow select-none" x-data="{
                                open: true,
                            }" :class="{'p-4': open}" wire:ignore>
                        <div class="w-full flex items-center justify-between cursor-pointer " @click="open = !open"
                            :class="{'border-b border-gray-200 pb-4 mb-4': open, 'p-4': !open}">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Attribute values') }}
                            </h3>
                            @svg('heroicon-o-chevron-down', ['class' => 'h-4 w-4', ':class' => "{'rotate-180':open}"])
                        </div>

                        <div class="w-full" x-show="open">
                            <template x-if="predefined_types.indexOf(type) !== -1">
                                <!-- Values of Predefined Types -->
                                <div class="w-full grid grid-cols-12 gap-3" x-data="{
                                        count() {
                                            if(this.attribute_values === undefined || this.attribute_values === null) {
                                                this.attribute_values = [{values: ''}];
                                            }

                                            return this.attribute_values.length;
                                        },
                                        hasID(index) {
                                            return this.attribute_values[index].hasOwnProperty('id') ? true : false;
                                        },
                                        add() {
                                            this.attribute_values.push({values:''});
                                        },
                                        remove(index) {
                                            if(this.hasID(index)) {
                                                $wire.removeAttributeValue(this.attribute_values[index]['id']);
                                            }
                                            this.attribute_values.splice(index, 1);
                                        },
                                    }">
                                    <div class="col-span-12">
                                        <template x-if="count() <= 1">
                                            <div class="flex">
                                                <input type="text" class="form-standard"
                                                    placeholder="{{ translate('Value 1') }}"
                                                    x-model="attribute_values[0]['values']" />
                                            </div>
                                        </template>
                                        <template x-if="count() > 1">
                                            <template
                                                x-for="[key, attribute_value] of Object.entries(attribute_values)">
                                                <div class="flex" :class="{'mt-2': key > 0}">
                                                    <input type="text" class="form-standard"
                                                        x-bind:placeholder="'{{ translate('Value') }} '+(Number(key)+1)"
                                                        x-model="attribute_value.values" />
                                                    <template x-if="key > 0">
                                                        <span class="ml-2 flex items-center cursor-pointer"
                                                            @click="remove(key)">
                                                            @svg('heroicon-o-trash', ['class' => 'w-[22px] h-[22px]
                                                            text-danger'])
                                                        </span>
                                                    </template>
                                                </div>
                                            </template>
                                        </template>

                                        <a href="javascript:;" class="btn-ghost !pl-0 !text-14 mt-1" @click="add()">
                                            @svg('heroicon-o-plus', ['class' => 'h-3 w-3 mr-2'])
                                            {{ translate('Add new') }}
                                        </a>

                                        {{-- <x-system.invalid-msg field="attribute.attribute_values">
                                        </x-system.invalid-msg> --}}
                                    </div>
                                </div>
                                <!-- END Values of Predefined Types -->
                            </template>

                            <div class="w-full flex justify-end">
                                <button type="button" class="btn btn-primary ml-auto" @click="
                                                $wire.set('attribute_values', attribute_values, true);
                                            " wire:click="saveAttributeValues()">
                                    {{ translate('Save') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    {{-- END Attribute Values --}}
                    @endif

                </div>
            </div>
        </div>
    </div>

</div>
