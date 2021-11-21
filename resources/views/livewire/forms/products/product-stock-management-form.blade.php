<div class="lw-form" x-data="{}">
    <x-ev.toast id="product-updated-toast"
                position="bottom-center"
                content="{{ translate('Product successfully updated!') }}"
                class="bg-success border-success text-white h3"></x-ev.toast>

    <!-- Main Product CARD -->
    <div class="card container-fluid py-3 mt-3">
        <div class="row">
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
                        <x-ev.form.input name="product.low_stock_qty" :quantity_counter="true" type="number" label="{{ translate('Low stock quantity warning') }}"  min="0" step="1">
                        </x-ev.form.input>
                    </div>
                </div>

                <x-ev.form.toggle name="product.use_serial"
                                  class="fw-600 opacity-10"
                                  append-text="{{ translate('Use serial') }}"
                                  :selected="$product->use_serial ?? false">
                </x-ev.form.toggle>
            </div>
            <div class="col-md-6 ">
                <x-ev.form.radio name="product.stock_visibility_state" :required="true" :items="\EVS::getMappedStockVisibilityOptions()" label="{{ translate('Stock visibility state') }}" value="{{ $product->stock_visibility_state ?: '' }}"></x-ev.form.radio>
            </div>
        </div>

        @if($product->use_serial)
        <div class="row mt-3">
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
                                     x-init="() => {
                                        select2 = $($refs.select).select2();
                                        select2.on('select2:select', (event) => {
                                          serial_status = event.target.value;
                                        });
                                        $watch('serial_status', (value) => {
                                          select2.val(value).trigger('change');
                                        });
                                     }"
                                >
                                    <!-- Select -->
                                    <select class="js-select2-custom js-datatable-filter custom-select" size="1" style="opacity: 0;"
                                            data-target-column-index="1"
                                            data-hs-select2-options='{
                                              "minimumResultsForSearch": "Infinity",
                                              "customClass": "custom-select custom-select-sm custom-select-borderless",
                                              "dropdownAutoWidth": true,
                                              "width": true
                                            }'
                                            x-ref="select"
                                            x-on:change="$wire.set('serial_status', serial_status)">
                                        <option value="">{{ translate('All') }}</option>
                                        <option value="in_stock" @if($serial_status === 'in_stock') selected @endif>{{ translate('In stock') }}</option>
                                        <option value="out_of_stock" @if($serial_status === 'out_of_stock') selected @endif>{{ translate('Out of stock') }}</option>
                                        <option value="reserved" @if($serial_status === 'reserved') selected @endif>{{ translate('Reserved') }}</option>
                                    </select>
                                    <!-- End Select -->
                                </div>

                                <div class="col">
                                    <form>
                                        <!-- Search -->
                                        <div class="input-group input-group-merge input-group-flush">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="tio-search"></i>
                                                </div>
                                            </div>
                                            <input id="serialNumbersDatatableSearch" wire:model.debounce.500ms="serial_search" type="search" class="form-control" placeholder="Search users" aria-label="{{ translate('Search serials...') }}">
                                        </div>
                                        <!-- End Search -->
                                    </form>
                                </div>
                            </div>
                            <!-- End Filter -->
                        </div>
                    </div>
                </div>
                <!-- End Header -->


                <!-- Table -->
                <div class="table-responsive datatable-custom">
                    <table id="serialNumbersDatatable" class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                           data-hs-datatables-options='{
                             "columnDefs": [{
                                "targets": [1],
                                "orderable": false
                              }],
                             "order": [],
                             "search": "#serialNumbersDatatableSearch",
                             "isResponsive": false,
                             "isShowPaging": false,
                             "pagination": "serialNumbersDatatablePagination"
                           }'
                           >
                        <thead class="thead-light">
                            <tr>
                                <th>{{ translate('Serial number') }}</th>
                                <th>{{ translate('Status') }}</th>
                                <th>{{ translate('Last status update') }}</th>
                                <th>{{ translate('Created at') }}</th>
                                <th class="d-flex justify-content-center">{{ translate('Actions') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                        @if(!empty($serial_numbers))
                            @foreach($serial_numbers as $serial)
                                @php
                                    $status_color_class = match ((string) $serial->status) {
                                        'in_stock' => 'bg-success',
                                        'out_of_stock' => 'bg-danger',
                                        'reserved' => 'bg-warning',
                                        default => 'bg-dark'
                                    };
                                @endphp
                                <tr>
                                    <td>
                                        <span>{{ $serial->serial_number }}</span>
                                    </td>
                                    <td>
                                        <span class="legend-indicator {{ $status_color_class }}"></span> {{ ucfirst(str_replace('_',' ',$serial->status))  }}
                                    </td>
                                    <td>
                                        {{ $serial->updated_at->format('d.m.Y H:i') }}
                                    </td>
                                    <td>
                                        {{ $serial->created_at->format('d.m.Y') }}
                                    </td>
                                    <td class="d-flex justify-content-center">
                                        @if($serial->status === 'in_stock')
                                            <button type="button" class="btn btn-dark btn-xs p-1 rounded" wire:click="" style="line-height: 1;">
                                                <!--@svg('heroicon-o-x', ['style' => 'width: 16px; height: 16px;'])-->
                                                <span>{{ translate('Invalidate') }}</span>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <!-- End Table -->

                <span class="divider mt-4">{{ translate('New serial numbers') }}</span>

                <!-- Card Body -->
                <div class="card-body js-add-field " id="main-product-new-serial-numbers" data-hs-add-field-options='{
                            "template": "#addSerialNumberTemplate",
                            "container": "#addSerialNumberContainer",
                            "defaultCreated": {{ count($new_serial_numbers) }},
                            "limit": 9999
                          }'>

                    @if(count($new_serial_numbers) > 0)
                        <script id="newSerialNumbersJSON" type="application/json">
                            @php echo json_encode($new_serial_numbers); @endphp
                        </script>
                    @endif

                    @if($errors->hasAny($errors->keys()))
                        <script id="newSerialNumbersErrorsJSON" type="application/json">
                            @php echo json_encode([$errors->getMessages()]); @endphp
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
                           onClick="document.dispatchEvent(new CustomEvent('save-new-serial-numbers', {detail: {component: @this, target: '#main-product-new-serial-numbers', params: ['new_serial_numbers']}}))">
                            <span>{{ translate('Save') }}</span>
                        </a>
                    </div>


                </div>
                <!-- End Card Body -->

                <!-- Footer -->
                <div class="card-footer">

                    <!-- Add Serial Number Template -->
                    <div id="addSerialNumberTemplate" class="w-100" style="display: none;">
                        <div class="d-flex flex-row align-items-center w-100 pb-2">
                            <div class="input-group-add-field mt-0 pr-3">
                                <input type="text" name="serial_number" class="form-control" value="" />
                            </div>
                            <div class="input-group-add-field mt-0 mr-3">
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

                            <div  class="input-group-add-field mt-0">
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
        @endif
    </div>
</div>
