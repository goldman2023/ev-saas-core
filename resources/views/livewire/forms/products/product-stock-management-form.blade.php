<div class="lw-form" x-data="{
    get validation_errors() {
        let errors = $('#stockManagementFormErrors').length > 0 ? JSON.parse($('#stockManagementFormErrors').html()) : {};
        return (errors[0] !== undefined) ? errors[0] : {};
    }
}">
    <x-ev.toast id="stock-updated-toast"
                position="bottom-center"
                class="bg-success border-success text-white h3"
                :is_x="true"
                @toast.window="if(event.detail.id == 'stock-updated-toast') {
                    content = event.detail.content;
                    show = true;
                }"
    ></x-ev.toast>

    @if($errors->hasAny($errors->keys()))
        <script id="stockManagementFormErrors" type="application/json">
            @json([$errors->getMessages()])
        </script>
    @endif

    <!-- Main Product CARD -->
    <div class="card container-fluid py-3 mt-3">
        <div id="main-product-stock-form">
            <form wire:submit.prevent="updateMainStock" class="row">
                <div class="col-md-6 mb-1">
                    <x-ev.form.input name="product.temp_sku" type="text" label="{{ translate('SKU') }}" :required="true" placeholder="{{ translate('SKU of the main product.') }}" >
                        <small class="text-muted">{{ translate('Leave empty if you want to add only SKU of the variations.') }}</small>
                    </x-ev.form.input>

                    <div class="row">
                        <div class="col-md-6">
                            <x-ev.form.input name="product.current_stock" :quantity_counter="true" type="number" label="{{ translate('Stock quantity') }}" :required="true" min="0" step="1" :disabled="$product->use_serial">
                                <small class="text-muted">{{ translate('This is the current stock quantity.') }}</small>
                            </x-ev.form.input>
                        </div>
                        <div class="col-md-6">
                            <x-ev.form.input name="product.low_stock_qty" :quantity_counter="true" type="number" label="{{ translate('Low stock quantity warning') }}" :required="true"  min="0" step="1">
                            </x-ev.form.input>
                        </div>
                    </div>

                    <div class="d-flex align-items-center fw-600 opacity-10">
                        <label class="toggle-switch mr-2" >
                            <input type="checkbox" name="product.use_serial" wire:model.defer="product.use_serial"
                                   class="js-toggle-switch toggle-switch-input"
                                   data-hs-toggle-switch-options="[]"
                                   x-ref="product_use_serial"
                                   x-on:click="
                                       if(!$($el).is(':checked')) {
                                            $($refs.serial_numbers_forms).addClass('d-none');
                                            $('input[name=\'product.current_stock\']').prop('disabled', false)
                                            .parent().find('.input-group-quantity-counter-btn').removeClass('d-none');
                                       } else {
                                            $($refs.serial_numbers_forms).removeClass('d-none');
                                            $('input[name=\'product.current_stock\']').prop('disabled', true)
                                            .parent().find('.input-group-quantity-counter-btn').addClass('d-none');
                                       }
                                   ">
                            <span class="toggle-switch-label">
                                <span class="toggle-switch-indicator"></span>
                            </span>
                        </label>
                        <span class="font-size-1 text-muted">{{ translate('Use serial') }}</span>
                    </div>

                </div>
                <div class="col-md-6 d-flex flex-column">
                    <x-ev.form.radio name="product.stock_visibility_state" :required="true"
                                     :items="\EVS::getMappedStockVisibilityOptions()"
                                     label="{{ translate('Stock visibility state') }}"
                                     value="{{ $product->stock_visibility_state ?: '' }}"></x-ev.form.radio>
                    <button
                        type="submit"
                        class="btn btn-sm btn-no-focus btn-primary align-items-center ml-auto mt-3 save-btn">
                        <span>{{ translate('Save') }}</span>
                    </button>
                </div>
            </form>
        </div>



        <div class="row mt-3 {{ !$product->use_serial ? 'd-none':'' }}" :class="{'d-none':!$($refs.product_use_serial).is(':checked')}" x-ref="serial_numbers_forms" id="serial_numbers_forms">

            <x-ev.loaders.spinner class="absolute-center z-10 d-none"
                                  wire:target="status"
                                  wire:loading.class.remove="d-none"></x-ev.loaders.spinner>

            <!-- Card -->
            <div class="card container-fluid" wire:loading.class="opacity-3">
                <!-- Header -->
                <div class="card-header">
                    <div class="row justify-content-between align-items-center flex-grow-1">
                        <div class="col-12 col-md">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-header-title">{{ translate('Serial Numbers') }}</h5>
                            </div>
                        </div>

                        <div class="col-md-auto">
                            <!-- Filter -->
                            <div class="row align-items-center">
                                <div class="col-auto" x-data="{ serial_status: @entangle('serial_status') }"
                                     x-init="
                                        $($refs.select_serial_filter).on('select2:select', (event) => {
                                          serial_status = event.target.value;
                                        });
                                        $watch('serial_status', (value) => {
                                          $($refs.select_serial_filter).val(value).trigger('change');
                                        });
                                     "
                                >
                                    <!-- Select -->
                                    <select class="js-select2-custom js-datatable-filter custom-select" size="1" style="opacity: 0;"
                                            data-target-column-index="1"
                                            data-hs-select2-options='{
                                              "minimumResultsForSearch": "Infinity",
                                              "customClass": "custom-select custom-select-sm",
                                              "dropdownAutoWidth": true,
                                              "width": true,
                                              "dropdownCssClass": "no-max-height"
                                            }'
                                            x-ref="select_serial_filter"
                                            x-on:change="$wire.set('serial_status', serial_status)">
                                        <option value="">{{ translate('All') }}</option>
                                        <option value="in_stock" @if($serial_status === 'in_stock') selected @endif>{{ translate('In stock') }}</option>
                                        <option value="out_of_stock" @if($serial_status === 'out_of_stock') selected @endif>{{ translate('Out of stock') }}</option>
                                        <option value="reserved" @if($serial_status === 'reserved') selected @endif>{{ translate('Reserved') }}</option>
                                        <option value="trashed" @if($serial_status === 'trashed') selected @endif>{{ translate('Trashed') }}</option>
                                    </select>
                                    <!-- End Select -->
                                </div>

                                <div class="col">
                                    <!-- Search -->
                                    <div class="input-group input-group-merge input-group-flush">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tio-search"></i>
                                            </div>
                                        </div>
                                        <input id="serialNumbersDatatableSearch" x-on:submit.prevent wire:model.debounce.500ms="serial_search" type="search" class="form-control" placeholder="Search users" aria-label="{{ translate('Search serials...') }}">
                                    </div>
                                    <!-- End Search -->
                                </div>
                            </div>
                            <!-- End Filter -->
                        </div>
                    </div>
                </div>
                <!-- End Header -->


                <!-- Table -->
                <div class="table-responsive datatable-custom">
                    <table id="serialNumbersDatatable" class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                        <thead class="thead-light">
                        <tr>
                            <th>{{ translate('Serial number') }}</th>
                            <th>{{ translate('Status') }}</th>
                            <th>{{ translate('Last status update') }}</th>
                            <th>{{ translate('Created at') }}</th>
                            <th class="d-flex justify-content-center">{{ translate('Actions') }}</th>
                        </tr>
                        </thead>

                        <tbody x-data="{
                                    original: @js($serial_numbers->keyBy('id')->toArray()),
                                    items: @entangle('edit_serial_numbers').defer,
                                    getStatusColorClass(status) {
                                        let matches = {
                                            'in_stock': 'bg-success',
                                            'out_of_stock': 'bg-danger',
                                            'reserved': 'bg-warning',
                                            'default': 'bg-dark'
                                          };
                                        return (matches[status] || matches['default']);
                                    },
                                    getStatusSelectIDTemplate(item_id, no_hash = false) {
                                        return  no_hash ? 'serial_number_status_select_'+item_id : '#serial_number_status_select_'+item_id;
                                    },
                                    resetRows(except) {
                                        this.items.forEach((element, index) => {
                                            if(except.id !== undefined && except.id === element.id)
                                                return;

                                            this.resetRow(element);
                                        });
                                    },
                                    resetRow(item) {
                                        item.edit_mode = false;
                                        item.serial_number = this.original[item.id].serial_number;
                                        item.status = this.original[item.id].status;
                                        $('.edit_serial_number_row_'+item.id).find('input').removeClass('border-danger');
                                        if($('.edit_serial_number_row_'+item.id).find('.error-msg').is(':visible')) {
                                            fresh_validation_errors = this.validation_errors;
                                            delete fresh_validation_errors['edit_serial_numbers.'+($('.edit_serial_number_row_'+item.id).data('row-index'))+'.serial_number'];
                                            $('#stockManagementFormErrors').html( JSON.stringify([fresh_validation_errors]) );
                                        }
                                    }
                                }"
                        >
                        <template x-for="(item, key) in items" :key="item.id" wire:key="item.id">
                            <!-- TODO: Fix style conditional -->
                            <!-- TODO: Fix error msgs display on close -->
                            <tr :style="item.trashed ? {background:'rgb(255 0 0 / 10%)'} : {}"
                                x-bind:data-row-index="key"
                                :class="'edit_serial_number_row_'+item.id"
                                x-init="$watch('item.status', (value) => {
                                              $(getStatusSelectIDTemplate(item.id)).val(value).trigger('change');
                                            });
                                            // When livewire changes html on first change, duplicate serial numbers are printed! This happens only on first html change. Prevent it manually by deleting wrong items!
                                            if($('.edit_serial_number_row_'+item.id).length > 1) {
                                                $('.edit_serial_number_row_'+item.id).last().remove();
                                            }
                                           "
                            >

                                <td style="width: 240px;">
                                        <span class="position-relative">
                                            <input type="text" name="serial_number" class="form-control" :id="'serial_number_input_'+item.id"
                                                   :class="{'border-danger': validation_errors.hasOwnProperty('edit_serial_numbers.'+key+'.serial_number')}"
                                                   x-model="item.serial_number"
                                                   x-show="item.edit_mode"
                                                   style="width: 208px;"
                                            />

                                            <span x-show="!item.edit_mode">
                                                <span x-text="item.serial_number"></span>
                                                <small x-show="item.trashed" class="badge badge-danger position-absolute" style="top: -4px; left: calc(100% + 5px); height: 15px; font-size: 9px; padding: 3px 4px;">{{ translate('Trashed') }}</small>
                                            </span>

                                            <span
                                                class="error-msg text-danger text-12"
                                                x-show="item.edit_mode && validation_errors.hasOwnProperty('edit_serial_numbers.'+key+'.serial_number')"
                                                x-text="getSafe(() => validation_errors['edit_serial_numbers.'+key+'.serial_number'][0], '')"></span>
                                        </span>
                                </td>

                                <td>
                                    <div class="" x-show="item.edit_mode">
                                        <select :key="getStatusSelectIDTemplate(item.id, true)" :id="getStatusSelectIDTemplate(item.id, true)" class="custom-select js-custom-select-dynamic" name="serial_number_status" data-hs-select2-options='{
                                                  "minimumResultsForSearch": "Infinity",
                                                  "customClass": "custom-select custom-select-sm",
                                                  "dropdownAutoWidth": true,
                                                  "width": true
                                            }' x-init="
                                                $(getStatusSelectIDTemplate(item.id)).on('select2:select', (event) => {
                                                  item.status = event.target.value;
                                                });
                                            ">
                                            <option value="in_stock" :selected="item.status === 'in_stock'">{{ translate('In stock') }}</option>
                                            <option value="out_of_stock" :selected="item.status === 'out_of_stock'">{{ translate('Out of stock') }}</option>
                                            <option value="reserved" :selected="item.status === 'reserved'">{{ translate('Reserved') }}</option>
                                        </select>
                                    </div>
                                    <div class="align-items-center" :class="{'d-flex':!item.edit_mode}" x-show="!item.edit_mode">
                                        <span class="legend-indicator" :class="getStatusColorClass(item.status)"></span>
                                        <span class="text-capitalize" x-text="item.status.replaceAll('_',' ')"></span>
                                    </div>
                                </td>

                                <td>
                                    <span x-text="item.updated_at"></span>
                                </td>
                                <td>
                                    <span x-text="item.created_at"></span>
                                </td>

                                <td class="">
                                    <div class="d-flex justify-content-center">
                                        <button type="button" :class="{'d-inline-flex' : !item.trashed && item.edit_mode}" class="btn btn-success btn-xs text-white p-1 justify-content-center align-items-center mr-2"
                                                x-show="!item.trashed && item.edit_mode"
                                                @click="$wire.updateSerialNumber(item.id)">
                                            @svg('heroicon-o-check', ['style' => 'height: 16px;'])
                                        </button>

                                        <button type="button" :class="{'d-inline-flex' : !item.trashed, 'btn-warning' : item.edit_mode, 'btn-info' : !item.edit_mode}"
                                                class="btn btn-xs text-white p-1 justify-content-center align-items-center mr-2"
                                                x-show="!item.trashed"
                                                @click="item.edit_mode = !item.edit_mode; if(item.edit_mode) { resetRows(item); } else { resetRow(item); }">
                                            @svg('heroicon-o-pencil-alt', ['style' => 'height: 16px;', 'x-show' => '!item.edit_mode'])
                                            @svg('heroicon-o-x', ['style' => 'height: 16px;', 'x-show' => 'item.edit_mode'])
                                        </button>

                                        <template x-if="item.status === 'in_stock' && item.trashed">
                                            <button type="button" class="btn btn-info btn-xs p-1" style="line-height: 1;"
                                                    x-show="!item.edit_mode"
                                                    @click="$wire.reviveSerialNumber(item.id)">
                                                <!--@svg('heroicon-o-x', ['style' => 'width: 16px; height: 16px;'])-->
                                                <span>{{ translate('Revive') }}</span>
                                            </button>
                                        </template>
                                        <template x-if="item.status === 'in_stock' && !item.trashed">
                                            <button type="button" class="btn btn-danger btn-xs p-1" style="line-height: 1;"
                                                    x-show="!item.edit_mode"
                                                    @click="$wire.invalidateSerialNumber(item.id)">
                                                @svg('heroicon-o-trash', ['style' => 'width: 16px; height: 16px;'])
                                            </button>
                                        </template>

                                    </div>
                                </td>
                            </tr>
                        </template>
                        </tbody>
                    </table>

                    <div class="d-flex align-items-center border rounded px-3 py-2 mt-3" style="border-color: #e7eaf3;">
                        @php
                            $serial_stats = $this->product->getSerialNumbersStockStats();
                        @endphp
                        <div class="d-flex align-items-center mr-2">
                            <strong class="mr-2 d-flex align-items-center">
                                <span class="legend-indicator bg-success mr-2"></span>
                                {{ translate('In stock:') }}
                            </strong>
                            <span>{{ $serial_stats['in_stock'] }}</span>
                        </div>

                        <div class="column-divider d-flex align-items-center pl-2 mr-2">
                            <strong class="mr-2 d-flex align-items-center">
                                <span class="legend-indicator bg-danger mr-2"></span>
                                {{ translate('Out of stock:') }}
                            </strong>
                            <span>{{ $serial_stats['out_of_stock'] }}</span>
                        </div>

                        <div class="column-divider d-flex align-items-center pl-2 mr-2">
                            <strong class="mr-2 d-flex align-items-center">
                                <span class="legend-indicator bg-warning mr-2"></span>
                                {{ translate('Reserved:') }}
                            </strong>
                            <span>{{ $serial_stats['reserved'] }}</span>
                        </div>

                        <div class="column-divider d-flex align-items-center pl-2 mr-2">
                            <strong class="mr-2 d-flex align-items-center">
                                <span class="legend-indicator bg-dark mr-2"></span>
                                {{ translate('Total:') }}
                            </strong>
                            <span>{{ $serial_stats['total'] }}</span>
                        </div>

                        <div class="column-divider d-flex align-items-center pl-2 ml-auto">
                            <strong class="mr-2 d-flex align-items-center">
                                @svg('heroicon-s-trash', ['class' => 'mr-2', 'style' => 'width: 14px; height: 14px;'])
                                {{ translate('Trashed:') }}
                            </strong>
                            <span>{{ $serial_stats['trashed'] }}</span>
                        </div>
                    </div>
                </div>
                <!-- End Table -->

                <span class="divider mt-4">{{ translate('New serial numbers') }}</span>

                <!-- Card Body (Add New Serial Numbers Panel) -->
                <div class="card-body js-add-field " id="main-product-new-serial-numbers" data-hs-add-field-options='{
                            "template": "#addSerialNumberTemplate",
                            "container": "#addSerialNumberContainer",
                            "defaultCreated": {{ count($new_serial_numbers) }},
                            "limit": 9999
                          }'>

                    @if(count($new_serial_numbers) > 0)
                        <script id="newSerialNumbersJSON" type="application/json">
                            @json($new_serial_numbers)
                        </script>
                    @endif

                    <div id="addSerialNumberContainer">

                    </div>

                    <div class="w-100 d-flex justify-content-between align-items-center mt-2">
                        <a href="javascript:;" class="js-create-field form-link btn btn-sm btn-no-focus btn-secondary d-inline-flex align-items-center mt-0">
                            @svg('heroicon-s-plus', ['style' => 'width: 16px; height:16px;'])
                            <span>{{ translate('Add serial number') }}</span>
                        </a>

                        <a href="javascript:;" class="btn btn-sm btn-no-focus btn-primary d-none align-items-center mt-0 save-btn"
                           onClick="document.dispatchEvent(new CustomEvent('save-new-serial-numbers', {detail: {component: @this, target: '#main-product-new-serial-numbers'}}))">
                            <span>{{ translate('Save') }}</span>
                        </a>
                    </div>


                </div>
                <!-- End Card Body -->

                <!-- Footer -->
                <div class="card-footer">

                    <!-- Add Serial Number Template -->
                    <div id="addSerialNumberTemplate" class="w-100" style="display: none;">
                        <div class="d-flex flex-row align-items-start w-100 pb-2">
                            <div class="input-group-add-field mt-0 pr-3">
                                <input type="text" name="serial_number" class="form-control" value="" />
                            </div>
                            <div class="input-group-add-field mt-1 mr-3">
                                <select class="js-custom-select-dynamic" name="serial_number_status" data-hs-select2-options='{
                                          "minimumResultsForSearch": "Infinity",
                                          "customClass": "custom-select custom-select-sm",
                                          "dropdownAutoWidth": true,
                                          "width": true
                                }'>
                                    <option value="in_stock" >{{ translate('In stock') }}</option>
                                    <option value="out_of_stock" >{{ translate('Out of stock') }}</option>
                                    <option value="reserved" >{{ translate('Reserved') }}</option>
                                </select>
                            </div>

                            <div class="input-group-add-field " style="margin-top: 12px;">
                                <button type="button" class="btn btn-danger btn-xs p-1 rounded js-delete-field d-inline-flex">
                                    @svg('heroicon-o-x', ['style' => 'width: 16px; height: 16px;'])
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- End Add Serial Number Template -->

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center justify-content-sm-end">
                        <nav id="serialNumbersDatatablePagination" aria-label="Activity pagination"></nav>
                    </div>
                    <!-- End Pagination -->
                </div>
                <!-- End Footer -->


            </div>
            <!-- End Card -->
        </div>



    </div>
</div>
