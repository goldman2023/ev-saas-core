<div class="w-full" x-data="{
    predefined_types: @js(App\Enums\AttributeTypeEnum::getPredefined()),
    type: @js($attribute->type ?? App\Enums\AttributeTypeEnum::dropdown()->value),
    slug: @js($attribute->slug),
    filterable: @js($attribute->filterable),
    is_schema: @js($attribute->is_schema),
    {{-- is_admin: @js($attribute->is_admin), --}}
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
}" x-cloak>
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
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">

                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Name') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <x-dashboard.form.input field="attribute.name" placeholder="{{ translate('New attribute name') }}" />
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
                                    <x-dashboard.form.select :items="\App\Enums\AttributeTypeEnum::labels()" selected="type"></x-dashboard.form.select>
                                </div>
                            </div>
                            <!-- END Type -->

                            <!-- Filterable -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                    <span class="text-sm font-medium text-gray-900" id="availability-label">{{
                                        translate('Filterable') }}</span>
                                    <span class="text-sm text-gray-500" id="availability-description">{{ translate('All
                                        filterable attributes will be displayed in archive pages filter section')
                                        }}</span>
                                </div>

                                <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                    <x-dashboard.form.toggle field="filterable" error-field="attribute.filterable" />
                                </div>
                            </div>
                            <!-- END Filterable -->

                            <!-- Is admin -->
                            {{-- <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                x-data="{}">
                                <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                    <span class="text-sm font-medium text-gray-900" id="availability-label">{{
                                        translate('Is admin') }}</span>
                                    <span class="text-sm text-gray-500" id="availability-description">{{
                                        translate('Visible only for admin') }}</span>
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
                            </div> --}}
                            <!-- END Is admin -->

                            <!-- Is schema -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                    <span class="text-sm font-medium text-gray-900" id="availability-label">{{
                                        translate('Is schema') }}</span>
                                    <span class="text-sm text-gray-500" id="availability-description">{{ translate('All
                                        schema attributes will be used to populate corresponding Schema.org markup')
                                        }}</span>
                                </div>

                                <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                    <x-dashboard.form.toggle field="is_schema" error-field="attribute.is_schema" />
                                </div>
                            </div>
                            <!-- END Is schema -->

                            {{-- Is schema - key and value --}}
                            <div x-show="is_schema"
                                class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Schema Key and Value') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-1">
                                    <x-dashboard.form.input field="attribute.schema_key" placeholder="{{ translate('Schema key') }}" />
                                </div>
                                <div class="mt-1 sm:mt-0 sm:col-span-1">
                                    <x-dashboard.form.input field="attribute.schema_value" placeholder="{{ translate('Schema value') }}" />
                                </div>
                            </div>
                            {{-- END Is schema - key and value --}}


                            <!-- Dropdown: Custom properties -->
                            <div x-show="type === 'dropdown'"
                                class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                    <span class="text-sm font-medium text-gray-900">{{
                                        translate('Multiple') }}</span>
                                    <span class="text-sm text-gray-500">{{
                                        translate('Allow multiple dropdown selection') }}</span>
                                </div>

                                <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                    <x-dashboard.form.toggle field="custom_properties.multiple" error-field="attribute.custom_properties" />
                                </div>
                            </div>
                            <!-- END Dropdown: Custom properties -->

                            <!-- Number Custom properties -->
                            <div x-show="type === 'number'" class="w-full">
                                <!-- Min. value -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">

                                    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                        {{ translate('Minimum value') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-1">
                                        <x-dashboard.form.input :x="true" type="number" field="custom_properties.min_value" placeholder="{{ translate('Minimum value') }}" />
                                    </div>
                                </div>
                                <!-- END Min. value -->

                                <!-- Max. value -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5">

                                    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                        {{ translate('Maximum value') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-1">
                                        <x-dashboard.form.input :x="true" type="number" field="custom_properties.max_value" placeholder="{{ translate('Maximum value') }}" />
                                    </div>
                                </div>
                                <!-- END Max. value -->

                                <!-- Unit -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5">

                                    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                        {{ translate('Unit') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <x-dashboard.form.input :x="true" type="text" field="custom_properties.unit" placeholder="{{ translate('Unit') }}" />
                                    </div>
                                </div>
                                <!-- END Unit -->
                            </div>
                            <!-- END Number Custom properties -->

                            <!-- Date Custom properties -->
                            <div x-show="type === 'date'" class="w-full">
                                {{-- With time --}}
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                    <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                        <span class="text-sm font-medium text-gray-900" id="availability-label">{{
                                            translate('With time') }}</span>
                                        <span class="text-sm text-gray-500" id="availability-description">{{
                                            translate('Include time along with date') }}</span>
                                    </div>

                                    <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                        <x-dashboard.form.toggle field="custom_properties.with_time" />
                                    </div>
                                </div>
                                {{-- END With time --}}

                                <!-- Range -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5">
                                    <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                        <span class="text-sm font-medium text-gray-900" id="availability-label">{{
                                            translate('Is range') }}</span>
                                        <span class="text-sm text-gray-500" id="availability-description">{{
                                            translate('If enabled, date wil be a date range. From X to Y date.')
                                            }}</span>
                                    </div>

                                    <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                        <x-dashboard.form.toggle field="custom_properties.range" />
                                    </div>
                                </div>
                                <!-- END Range -->
                            </div>
                            <!-- END Date Custom properties -->

                            <!-- Text Repeater custom properties-->
                            <div x-show="type === 'text_list'" class="w-full">
                                <!-- Min. value -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">

                                    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                        {{ translate('Minimum rows') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-1">
                                        <x-dashboard.form.input :x="true" type="number" field="custom_properties.min_rows" placeholder="{{ translate('Minimum rows') }}" />
                                    </div>
                                </div>
                                <!-- END Min. value -->

                                <!-- Max. value -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5">

                                    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                        {{ translate('Maximum rows') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-1">
                                        <x-dashboard.form.input :x="true" type="number" field="custom_properties.max_rows" placeholder="{{ translate('Maximum rows') }}" />
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
                                                {{-- $wire.set('attribute.is_admin', is_admin, true); --}}
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
                                    {{-- $wire.set('attribute.is_admin', is_schema, true); --}}
                                    $wire.set('attribute.filterable', is_schema, true);
                                " wire:click="saveAttribute()">
                                {{ translate('Save') }}
                            </button>
                        </div>
                    </div>
                    {{-- END Actions --}}

                    {{-- Attribute Values --}}
                    <x-dashboard.form.blocks.attribute-values-form :attribute="$attribute" />

                </div>
            </div>
        </div>
    </div>

</div>
