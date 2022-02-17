<div class="w-100" x-data="{
    predefined_types: @js(App\Enums\AttributeTypeEnum::getPredefined()),
    type: @js($attribute->type ?? App\Enums\AttributeTypeEnum::dropdown()->value),
    is_schema: @js($attribute->is_schema ?? false),
    custom_properties: {...{
        'multiple': false,
        'min_value': 0,
        'max_value': 0,
        'unit': '',
    }, ...@js($attribute->custom_properties ?? ((object) []))},
    attribute_values: @js($attribute->attribute_values ?? []),
}">
    {{-- Attribute Card --}}
    <div class="card">
        <!-- Header -->
        <div class="card-header">
            <h5 class="card-header-title">{{ translate('Edit') }}: {{ $attribute->getTranslation('name') }}</h5>
            <a href="{{ route('attributes.index', base64_encode($attribute->content_type)) }}" class="btn btn-primary btn-xs">{{ translate('All attributes') }}</a>
        </div>
        <!-- End Header -->
    
        <div class="card-body" 
            @validation-errors.window="$scrollToErrors($event.detail.errors, 700);"
            >
                <div class="col-lg-12 position-relative" x-cloak>
                    <x-ev.loaders.spinner class="absolute-center z-10 d-none"
                                          wire:target="saveAttribute"
                                          wire:loading.class.remove="d-none"></x-ev.loaders.spinner>
            
                    <div class=""
                         wire:loading.class="opacity-3 prevent-pointer-events"
                         wire:target="saveAttribute"
                    >
                        <!-- Name -->
                        <div class="row form-group mt-5" x-data="{}">
                            <label for="attribute-name" class="col-sm-3 col-form-label input-label">{{ translate('Name') }}</label>
            
                            <div class="col-sm-9">
                                <div class="input-group input-group-sm-down-break">
                                    <input type="text" class="form-control @error('attribute.name') is-invalid @enderror"
                                            name="attribute.name"
                                            id="attribute-name"
                                            placeholder="{{ translate('New attribute name') }}"
                                            wire:model.defer="attribute.name" />
                                </div>
            
                                <x-default.system.invalid-msg field="attribute.name" type="slim"></x-default.system.invalid-msg>
                            </div>
                        </div>
                        <!-- END Name -->
            
                        <!-- Type -->
                        <div class="row form-group mt-5">
                            <label for="attribute-type" class="col-sm-3 col-form-label input-label d-flex align-items-center">
                                {{ translate('Type') }}
                            </label>
            
                            <div class="col-sm-9" x-data="{}"
                                x-init="
                                    $($refs.attribute_type_selector).on('select2:select', (event) => {
                                        type = event.target.value;
                                    });
            
                                    $watch('type', (value) => {
                                        $($refs.attribute_type_selector).val(value).trigger('change');
                                    });
                                "
                            >
                                <select
                                    wire:model.defer="attribute.type"
                                    name="attribute.type"
                                    x-ref="attribute_type_selector"
                                    id="attribute-type-status-selector"
                                    class="js-select2-custom custom-select select2-hidden-accessible"
                                    data-hs-select2-options='
                                        {"minimumResultsForSearch":"Infinity"}
                                    '
                                >
                                    @foreach(\App\Enums\AttributeTypeEnum::labels() as $key => $status)
                                        <option value="{{ $key }}">
                                            {{ $status }}
                                        </option>
                                    @endforeach
                                </select>
            
                                <x-default.system.invalid-msg field="attribute.type" type="slim"></x-default.system.invalid-msg>
                            </div>
                        </div>
                        <!-- END Type -->
            
                        <!-- Filterable -->
                        <div class="row form-group mt-5" x-data="{}">
                            <label for="attribute-filterable" class="col-sm-3 col-form-label input-label">{{ translate('Filterable') }}</label>
            
                            <div class="col-sm-9 d-flex align-items-center">
                                <div class="input-group input-group-sm-down-break">
                                    <label class="toggle-switch" for="connectedAccounts1">
                                        <input id="connectedAccounts1" type="checkbox" class="toggle-switch-input" wire:model.defer="attribute.filterable">
                                        <span class="toggle-switch-label">
                                            <span class="toggle-switch-indicator"></span>
                                        </span>
                                    </label>
                                </div>
            
                                <x-default.system.invalid-msg field="attribute.filterable" type="slim"></x-default.system.invalid-msg>
                            </div>
                        </div>
                        <!-- END Filterable -->
            
                        <!-- Is admin -->
                        <div class="row form-group mt-5" x-data="{}">
                            <label for="attribute-is_admin" class="col-sm-3 col-form-label input-label">{{ translate('For admin') }}</label>
            
                            <div class="col-sm-9 d-flex align-items-center">
                                <div class="input-group input-group-sm-down-break">
                                    <label class="toggle-switch">
                                        <input type="checkbox" class="toggle-switch-input" wire:model.defer="attribute.is_admin">
                                        <span class="toggle-switch-label">
                                            <span class="toggle-switch-indicator"></span>
                                        </span>
                                    </label>
                                </div>
            
                                <x-default.system.invalid-msg field="attribute.is_admin" type="slim"></x-default.system.invalid-msg>
                            </div>
                        </div>
                        <!-- END admin -->
            
                        <!-- Is Schema -->
                        <div class="row form-group mt-5" x-data="{}">
                            <label for="attribute-is_schema" class="col-sm-3 col-form-label input-label">{{ translate('Is schema') }}</label>
            
                            <div class="col-sm-9 d-flex align-items-center">
                                <div class="input-group input-group-sm-down-break">
                                    <label class="toggle-switch">
                                        <input type="checkbox" class="toggle-switch-input" x-model="is_schema">
                                        <span class="toggle-switch-label">
                                            <span class="toggle-switch-indicator"></span>
                                        </span>
                                    </label>
                                </div>
            
                                <x-default.system.invalid-msg field="attribute.is_schema" type="slim"></x-default.system.invalid-msg>
                            </div>
                        </div>
                        <!-- END Is Schema -->
            
                        {{-- <template x-if="is_schema"> --}}
                            <div class="w-100" x-show="is_schema">
                                <!-- Schema Key -->
                                <div class="row form-group mt-5" x-data="{}">
                                    <label for="attribute-schema_key" class="col-sm-3 col-form-label input-label">{{ translate('Schema Key') }}</label>
            
                                    <div class="col-sm-9">
                                        <div class="input-group input-group-sm-down-break">
                                            <input type="text" class="form-control @error('attribute.schema_key') is-invalid @enderror"
                                                    name="attribute.schema_key"
                                                    id="attribute-schema_key"
                                                    placeholder="{{ translate('Schema key') }}"
                                                    wire:model.defer="attribute.schema_key" />
                                        </div>
            
                                        <x-default.system.invalid-msg field="attribute.schema_key" type="slim"></x-default.system.invalid-msg>
                                    </div>
                                </div>
                                <!-- END Schema Key -->
            
                                <!-- Schema value -->
                                <div class="row form-group mt-5" x-data="{}">
                                    <label for="attribute-schema_value" class="col-sm-3 col-form-label input-label">{{ translate('Schema value') }}</label>
            
                                    <div class="col-sm-9">
                                        <div class="input-group input-group-sm-down-break">
                                            <input type="text" class="form-control @error('attribute.schema_value') is-invalid @enderror"
                                                    name="attribute.schema_value"
                                                    id="attribute-schema_value"
                                                    placeholder="{{ translate('Schema value') }}"
                                                    wire:model.defer="attribute.schema_value" />
                                        </div>
            
                                        <x-default.system.invalid-msg field="attribute.schema_value" type="slim"></x-default.system.invalid-msg>
                                    </div>
                                </div>
                                <!-- END Schema value -->
                            </div>
                            
                        {{-- </template> --}}
            
                        <!-- Dropdown: Custom properties -->
                        {{-- <template x-if="type === 'dropdown'"> --}}
                            <div class="row form-group mt-5" x-data="{
            
                            }" x-show="type === 'dropdown'">
                                <label for="attribute-multiple" class="col-sm-3 col-form-label input-label">{{ translate('Allow multiple selection') }}</label>
                
                                <div class="col-sm-9 d-flex align-items-center">
                                    <div class="input-group input-group-sm-down-break">
                                        <label class="toggle-switch">
                                            <input type="checkbox" class="toggle-switch-input" x-model="custom_properties.multiple">
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        {{-- </template> --}}
                        <!-- END Dropdown: Custom properties -->
            
                        <!-- Number Custom properties -->
                        {{-- <template x-if="type === 'number'"> --}}
                            <div x-show="type === 'number'">
                                <!-- Min. value -->
                                <div class="row form-group mt-5" x-data="{}">
                                    <label class="col-sm-3 col-form-label input-label">{{ translate('Min. value') }}</label>
            
                                    <div class="col-sm-9">
                                        <div class="input-group input-group-sm-down-break">
                                            <input type="number" 
                                                    class="form-control"
                                                    placeholder="{{ translate('Minimum value') }}"
                                                    x-model="custom_properties.min_value" />
                                        </div>
                                    </div>
                                </div>
                                <!-- END Min. value -->
            
                                <!-- Max. value -->
                                <div class="row form-group mt-5" x-data="{}">
                                    <label class="col-sm-3 col-form-label input-label">{{ translate('Max. value') }}</label>
            
                                    <div class="col-sm-9">
                                        <div class="input-group input-group-sm-down-break">
                                            <input type="number" 
                                                    class="form-control"
                                                    placeholder="{{ translate('Maximum value') }}"
                                                    x-model="custom_properties.max_value" />
                                        </div>
                                    </div>
                                </div>
                                <!-- END Max. value -->
            
                                <!-- Unit -->
                                <div class="row form-group mt-5">
                                    <label class="col-sm-3 col-form-label input-label d-flex align-items-center">
                                        {{ translate('Unit') }}
                                    </label>
            
                                    <div class="col-sm-9" 
                                        x-data="{}"
                                        x-init="
                                            $($refs.custom_properties_unit_selector).on('select2:select', (event) => {
                                                custom_properties.unit = event.target.value;
                                            });
            
                                            $watch('custom_properties.unit', (value) => {
                                                $($refs.custom_properties_unit_selector).val(value).trigger('change');
                                            });
                                        "
                                    >
                                        <select
                                            x-ref="custom_properties_unit_selector"
                                            class="js-select2-custom custom-select select2-hidden-accessible"
                                            data-hs-select2-options='
                                                {"minimumResultsForSearch":-1}
                                            '
                                        >
                                            @foreach(\App\Enums\UnitsEnum::labels() as $key => $status)
                                                <option value="{{ $key }}">
                                                    {{ $status }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- END Type -->
                            </div>
                        {{-- </template> --}}
                        <!-- END Number Custom properties -->
            
                        <hr/>
            
                        <div class="row form-group mb-0">
                            <div class="col-12 d-flex">
                                {{-- TODO: Standardize Categories selection for various Content Types --}}
                                <button type="button" class="btn btn-primary ml-auto btn-sm"
                                        @click="
                                            $wire.set('attribute.custom_properties', custom_properties, true);
                                            $wire.set('attribute.type', type, true);
                                            $wire.set('attribute.is_schema', is_schema, true);
                                            {{--let $selected_categories = [];
                                            $('[name=\'selected_categories\']').each(function(index, item) {
                                                $selected_categories = [...$selected_categories, ...$(item).val()];
                                            });
                                            $wire.set('selected_categories', $selected_categories, true);
                                            $wire.set('plan.base_currency', $('#plan-base_currency').val(), true);
                                            $wire.set('plan.discount_type', $('#plan-discount_type').val(), true);
                                            $wire.set('plan.yearly_discount_type', $('#plan-yearly_discount_type').val(), true);
                                            $wire.set('plan.tax_type', $('#plan-tax_type').val(), true); --}}
                                        "
                                        wire:click="saveAttribute()">
                                    {{ translate('Save') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    {{-- END Attribute Card --}}

    {{-- Attribute Values Card --}}
    <div class="card mt-4" x-if="predefined_types.indexOf(type) !== -1">
        <!-- Header -->
        <div class="card-header">
            <h5 class="card-header-title">{{ translate('Attribute Values') }}</h5>
        </div>
        <!-- End Header -->

        <div class="card-body" 
            @validation-errors.window="$scrollToErrors($event.detail.errors, 700);"
            >
            <div class="col-lg-12 position-relative" x-cloak>
                <x-ev.loaders.spinner class="absolute-center z-10 d-none"
                                    wire:target="saveAttributeValues"
                                    wire:loading.class.remove="d-none"></x-ev.loaders.spinner>

                <div class=""
                    wire:loading.class="opacity-3 prevent-pointer-events"
                    wire:target="saveAttributeValues"
                >
                    <template x-if="predefined_types.indexOf(type) !== -1">
                        <div class="w-100">
                            <!-- Values of Predefined Types -->
                            <div class="row form-group" x-data="{
                                count() {
                                    if(this.attribute_values === undefined || this.attribute_values === null) {
                                        this.attribute_values = [{values: ''}];
                                    }

                                    return this.attribute_values.length;
                                },
                                add() {
                                    this.attribute_values.push({values:''});
                                },
                                remove(index) {
                                    this.attribute_values.splice(index, 1);
                                },
                            }"
                            >
                                <div class="col-sm-9">
                                    <template x-if="count() <= 1">
                                        <div class="d-flex">
                                            <input type="text" 
                                                    class="form-control"
                                                    placeholder="{{ translate('Value 1') }}"
                                                    x-model="attribute_values[0]['values']" />
                                        </div>
                                    </template>
                                    <template x-if="count() > 1">
                                        <template x-for="[key, value] of Object.entries(attribute_values)">
                                            <div class="d-flex" :class="{'mt-2': key > 0}">
                                                <input type="text" 
                                                    class="form-control"
                                                    x-bind:placeholder="'{{ translate('Value') }} '+(Number(key)+1)"
                                                    x-model="attribute_values[key]['values']" />
                                                <template x-if="key > 0">
                                                    <span class="ml-2 d-flex align-items-center pointer" @click="remove(key)">
                                                        @svg('heroicon-o-trash', ['class' => 'square-22 text-danger'])
                                                    </span>
                                                </template>
                                            </div>
                                        </template>
                                    </template>

                                    <a href="javascript:;"
                                        class="js-create-field form-link btn btn-xs btn-no-focus btn-ghost-primary" @click="add()">
                                        <i class="tio-add"></i> {{ translate('Add value') }}
                                    </a>
    {{-- 
                                    <x-default.system.invalid-msg field="plan.attribute_values"></x-default.system.invalid-msg> --}}
                                </div>
                            </div>
                            <!-- END Values of Predefined Types --> 
                        </div>
                    </template>

                    <hr/>
            
                    <div class="row form-group mb-0">
                        <div class="col-12 d-flex">
                            <button type="button" class="btn btn-primary ml-auto btn-sm"
                                    @click="
                                        $wire.set('attribute_values', attribute_values, true);
                                    "
                                    wire:click="saveAttributeValues()">
                                {{ translate('Save') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- END Attribute Values Card --}}
</div>


