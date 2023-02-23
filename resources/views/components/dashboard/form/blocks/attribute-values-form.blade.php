@if(!empty($attribute->id) && $attribute->is_predefined)
    <div id="attribute-values-form" class="mt-8 border bg-white border-gray-200 rounded-lg shadow select-none" x-data="{
            open: true,
            attribute_values: @entangle('attribute_values').defer,
            sortableList: null,
            hasID(index) {
                if(this.attribute_values[index].hasOwnProperty('id') && Number(this.attribute_values[index]['id']) !== NaN) {
                    return  true;
                }

                return false;
            },
            count() {
                if(this.attribute_values === null || this.attribute_values === undefined || this.attribute_values.length <= 0) {
                    this.attribute_values.push({
                        id: crypto.randomUUID(),
                        values: '',
                        ordering: 0,
                    });
                }

                return this.attribute_values.length;
            },
            remove(index) {
                if(this.hasID(index)) {
                    // TODO: Invoke confirmation window before removing!
                    $wire.removeAttributeValue(this.attribute_values[index]['id']);
                }
                
                this.attribute_values.splice(index, 1);
            },
            reOrder() {
                $nextTick(() => {
                    let new_idx_list = [];
                    $el.querySelectorAll('.attribute-values__list .attribute-values__list-item').forEach((item, index) => {
                        new_idx_list.push(item.getAttribute('data-att-value-id'));
                    });
                    this.attribute_values = new_idx_list.map(id => this.attribute_values.find(x => x.id == id));

                    {{-- TODO: FIX SORTABLE!!!! DOESNT WORK CORRECTLY!!!! --}}
                    
                    {{-- $nextTick(() => {
                        this.sortableList.option('disabled');
                        this.attribute_values = new_idx_list.map(id => this.attribute_values.find(x => x.id == id) );
                        console.log(this.attribute_values);
                        this.sortableList.option('disabled', false);

                    }); --}}
                    {{-- console.log(this.attribute_values.map(i => i['id'])); --}}

                    {{-- this.attribute_values.forEach((item, index) => {
                        this.attribute_values[index]['ordering'] = Array.from($el.querySelectorAll('.attribute-values__list .attribute-values__list-item')).indexOf($el.querySelector('.attribute-values__list [data-att-value-id=\''+item.id+'\']')) + 1;
                    });

                    $nextTick(() => {
                        this.attribute_values.sort((a,b) => a.ordering - b.ordering);
                    }); --}}
                });
            },
            makeSortable() {
                $nextTick(() => {
                    let args = {
                        onSort: (evt) => {
                            this.reOrder();
                        },
                        animation: 150,
                        ghostClass: 'opacity-20',
                        dragClass: 'bg-blue-50',
                    };


                    {{-- TODO: Check https://github.com/SortableJS/Sortable#save - for fixing sorting/ordering UI/UX when items are added or removed! --}}
                    if(this.sortableList) {
                        {{-- this.sortableList.destroy(); --}}
                        {{-- this.sortableList = window.Sortable.create($el.querySelector('.file-selector__sortable-list'), args); --}}
                    } else {
                        if($el.querySelector('.attribute-values__list') !== null) {
                            this.sortableList = window.Sortable.create($el.querySelector('.attribute-values__list'), args);
                        }
                    }
                });
            }
        }" 
        :class="{'p-4': open}"
        x-init="count(); "
        wire:ignore
        x-cloak
    >
    {{-- FIXME: If $attribute->custom_properties is {} and not null, it will rise livewire checksum error on
    saveAttribute() --}}
        <div class="w-full flex items-center justify-between cursor-pointer " @click="open = !open"
            :class="{'border-b border-gray-200 pb-4 mb-4': open, 'p-4': !open}">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                {{ translate('Attribute values') }}
            </h3>
            @svg('heroicon-o-chevron-down', ['class' => 'h-4 w-4', ':class' => "{'rotate-180':open}"])
        </div>

        <div class="w-full" x-show="open">
            <template x-if="predefined_types.indexOf(type) !== -1">
                <!-- Values of Predefined Types -->
                <div class="w-full grid grid-cols-12 gap-3">
                    <div class="attribute-values__list col-span-12">
                        <template x-if="count() <= 1">
                            <div class="flex attribute-values__list-item" x-bind:data-att-value-id="attribute_values[0]['id']">
                                <input type="text" class="form-standard"
                                    placeholder="{{ translate('Value 1') }}"
                                    x-model="attribute_values[0]['values']" />
                            </div>
                        </template>
                        <template x-if="count() > 1">
                            <template
                                x-for="(attribute_value, index) in attribute_values">
                                <div class="attribute-values__list-item flex items-center pt-2" x-bind:data-att-value-id="attribute_values[index]['id']">
                                    <span class="flex items-center cursor-grab mr-2">
                                        @svg('heroicon-m-bars-3', ['class' => 'w-[22px] h-[22px] text-gray-900'])
                                    </span>

                                    <input disabled type="text" class="form-standard"
                                        x-bind:placeholder="'{{ translate('Value') }} '+(Number(index)+1)"
                                        x-model="attribute_value.values" />

                                    <div class="flex items-center gap-x-2">
                                        <span class="ml-2 flex items-center cursor-pointer"
                                            @click="$dispatch('display-modal', {'id': 'attribute-value-form-modal', 'att_val_index': index})">
                                            @svg('heroicon-o-pencil-square', ['class' => 'w-[22px] h-[22px] text-info'])
                                        </span>

                                        <span class="ml-2 flex items-center cursor-pointer"
                                            @click="remove(index)">
                                            @svg('heroicon-o-trash', ['class' => 'w-[22px] h-[22px] text-danger'])
                                        </span>
                                    </div>
                                </div>
                            </template>
                        </template>
                        {{-- <x-system.invalid-msg field="attribute.attribute_values">
                        </x-system.invalid-msg> --}}
                    </div>

                    <div class="col-span-12">
                        <button type="button" class="btn-ghost !pl-0 !text-14" @click="$dispatch('display-modal', {'id': 'attribute-value-form-modal'})">
                            @svg('heroicon-o-plus', ['class' => 'h-3 w-3 mr-2'])
                            {{ translate('Add new') }}
                        </button>
                    </div>
                    
                </div>
                <!-- END Values of Predefined Types -->
            </template>

            <div class="w-full flex justify-end">
                <button type="button" class="btn btn-primary ml-auto" @click="
                        $wire.set('attribute_values', attribute_values, true);
                        $wire.saveAttributeValues();
                    ">
                    {{ translate('Save') }}
                </button>
            </div>
        </div>

        {{-- Attribute Value Modal --}}
        <x-system.form-modal id="attribute-value-form-modal" title="Attribute Value" class="!max-w-3xl" :prevent-close="true">
            <div class="w-full" x-data="{
                index: null,
            }" @display-modal.window="
                if($event.detail.id === id) {
                    if(_.get($event.detail, 'att_val_index', false)) {
                        modal_title = '{{ translate('Edit Attribute Value') }}';

                        index = $event.detail.att_val_index;
                    } else {
                        modal_title = '{{ translate('New Attribute Value') }}';

                        attribute_values.push({
                            id: crypto.randomUUID(),
                            values: '',
                            ordering: 0,
                        });
                        index = attribute_values.length - 1;

                        {{-- reOrder(); --}}
                    }
                }
            "
            wire:ignore
            wire:loading.class="opacity-30 pointer-events-none"
            x-init="$watch('show', show_value => {
                {{-- If attribute value is empty, remove it on close --}}
                if(!show_value && (_.get(attribute_values[index], 'values', null) == '' || _.get(attribute_values[index], 'values', null) === null)) {
                    attribute_values.splice(attribute_values.length - 1, 1);
                }
            })">
                <template x-if="attribute_values[index] !== undefined">
                    <input type="text" class="form-standard"
                        x-bind:placeholder="'{{ translate('Value') }} '+(Number(index)+1)"
                        x-model="attribute_values[index].values" />
                </template>
                

                <div class="grid grid-cols-1 gap-y-3 mt-4">
                    @php
                        do_action('view.dashboard.form.attribute-value-modal.wefs', $attribute);
                    @endphp
                </div>

                <div class="w-full flex justify-end mt-4 pt-4 border-t border-gray-200">
                    <button type="button" class="btn btn-primary ml-auto" @click="
                            $wire.set('attribute_values', attribute_values, true);
                            $wire.saveAttributeValues();
                        ">
                        {{ translate('Save') }}
                    </button>
                </div>
            </div>
        </x-system.form-modal>
        {{-- END Attribute Value Modal --}}
    </div>
    {{-- END Attribute Values --}}

    
@endif