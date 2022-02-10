@extends('frontend.layouts.user_panel')

@section('meta_title', translate('My Purchases'))
@section('page_title', translate('My Purchases'))

@push('head_scripts')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-colvis-2.1.1/b-html5-2.1.1/b-print-2.1.1/date-1.1.1/fh-3.2.0/r-2.2.9/sl-1.3.4/datatables.min.css"/>
@endpush

@section('panel_content')
    <!-- Card -->
    <div class="card">
        <!-- Header -->
        <div class="card-header">
            <h5 class="card-header-title">{{ translate('My purchases') }}</h5>
{{--            <a href="{{ route('ev-products.create') }}" class="btn btn-primary btn-xs">{{ translate('Add new') }}</a>--}}

            <!-- Unfold -->
            <div class="hs-unfold">
                <a class="js-hs-unfold-invoker btn btn-icon btn-sm btn-ghost-secondary rounded-circle" href="javascript:;"
                   data-hs-unfold-options='{
                       "target": "#showHideDropdown",
                       "type": "css-animation"
                     }'>
                    <i class="tio-table"></i>
                </a>

{{--                <div id="showHideDropdown" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right dropdown-card" style="width: 15rem;">--}}
{{--                    <div class="card card-sm">--}}
{{--                        <div class="card-body">--}}
{{--                            <div class="d-flex justify-content-between align-items-center mb-3">--}}
{{--                                <span class="mr-2">Country</span>--}}

{{--                                <!-- Checkbox Switch -->--}}
{{--                                <label class="toggle-switch toggle-switch-sm" for="toggleColumn_country">--}}
{{--                                    <input type="checkbox" class="toggle-switch-input" id="toggleColumn_country" checked>--}}
{{--                                    <span class="toggle-switch-label">--}}
{{--                                      <span class="toggle-switch-indicator"></span>--}}
{{--                                    </span>--}}
{{--                                </label>--}}
{{--                                <!-- End Checkbox Switch -->--}}
{{--                            </div>--}}

{{--                            <div class="d-flex justify-content-between align-items-center mb-3">--}}
{{--                                <span class="mr-2">Position</span>--}}

{{--                                <!-- Checkbox Switch -->--}}
{{--                                <label class="toggle-switch toggle-switch-sm" for="toggleColumn_position">--}}
{{--                                    <input type="checkbox" class="toggle-switch-input" id="toggleColumn_position" checked>--}}
{{--                                    <span class="toggle-switch-label">--}}
{{--                                      <span class="toggle-switch-indicator"></span>--}}
{{--                                    </span>--}}
{{--                                </label>--}}
{{--                                <!-- End Checkbox Switch -->--}}
{{--                            </div>--}}

{{--                            <div class="d-flex justify-content-between align-items-center">--}}
{{--                                <span class="mr-2">Status</span>--}}

{{--                                <!-- Checkbox Switch -->--}}
{{--                                <label class="toggle-switch toggle-switch-sm" for="toggleColumn_status">--}}
{{--                                    <input type="checkbox" class="toggle-switch-input" id="toggleColumn_status" checked>--}}
{{--                                    <span class="toggle-switch-label">--}}
{{--                                      <span class="toggle-switch-indicator"></span>--}}
{{--                                    </span>--}}
{{--                                </label>--}}
{{--                                <!-- End Checkbox Switch -->--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            --}}
            </div>
            <!-- End Unfold -->
        </div>
        <!-- End Header -->
{{-- TODO: Create proper pagination! --}}
        <!-- Table -->
        <div class="table-responsive datatable-custom pt-3">
            <table id="ordersDatatable"
                   class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                   data-hs-datatables-options='{
                     "columnDefs": [{
                        "targets": [0],
                        "orderable": false
                     }],
                     "order": [],
                     "info": {
                       "totalQty": "#ordersDatatableTotalQty"
                     },
                     "pageLength": 15,
                     "entries": "#ordersDatatablePerPage",
                     "isResponsive": false,
                     "isShowPaging": false,
                     "paging": true,
                     "pagination": "ordersDatatablePagination"
                   }'>
                <thead class="thead-light">
                <tr>
                    <th>{{ translate('Order') }}</th>
                    <th>{{ translate('Date') }}</th>
                    <th>{{ translate('Customer') }}</th>
                    <th>{{ translate('Payment status') }}</th>
                    <th>{{ translate('Shipping status') }}</th>
{{--                    <th>{{ translate('Payment method') }}</th>--}}
                    <th>{{ translate('Total') }}</th>
                    <th>{{ translate('Actions') }}</th>
                </tr>
                </thead>

                <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>
                            <a class="media align-items-center text-14" href="{{ route('order.details', ['id' => $order->id]) }}">
                                #{{ $order->id }}
                            </a>
                        </td>
                        <td>
                            <span class="d-block text-14 mb-0">{{ $order->created_at }}</span>
                        </td>
                        <td>
                            <span class="text-14">{{ $order->billing_first_name.' '.$order->billing_last_name }}</span>
                        </td>
                        <td>
                            @if($order->payment_status === App\Enums\PaymentStatusEnum::paid()->value)
                                <span class="badge badge-soft-success">
                                  <span class="legend-indicator bg-success mr-1"></span> {{ ucfirst($order->payment_status) }}
                                </span>
                            @elseif($order->payment_status === App\Enums\PaymentStatusEnum::pending()->value)
                                <span class="badge badge-soft-info">
                                  <span class="legend-indicator bg-info mr-1"></span> {{ ucfirst($order->payment_status) }}
                                </span>
                            @elseif($order->payment_status === App\Enums\PaymentStatusEnum::unpaid()->value)
                                <span class="badge badge-soft-danger">
                                  <span class="legend-indicator bg-danger mr-1"></span> {{ ucfirst($order->payment_status) }}
                                </span>
                            @elseif($order->payment_status === App\Enums\PaymentStatusEnum::canceled()->value)
                                <span class="badge badge-soft-warning">
                                  <span class="legend-indicator bg-warning mr-1"></span> {{ ucfirst($order->payment_status) }}
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($order->shipping_status === App\Enums\ShippingStatusEnum::delivered()->value)
                                <span class="badge badge-soft-success">
                                  <span class="legend-indicator bg-success mr-1"></span> {{ ucfirst($order->shipping_status) }}
                                </span>
                            @elseif($order->shipping_status === App\Enums\ShippingStatusEnum::sent()->value)
                                <span class="badge badge-soft-warning">
                                  <span class="legend-indicator bg-warning mr-1"></span> {{ ucfirst($order->shipping_status) }}
                                </span>
                            @elseif($order->shipping_status === App\Enums\ShippingStatusEnum::not_sent()->value)
                                <span class="badge badge-soft-danger">
                                  <span class="legend-indicator bg-danger mr-1"></span> {{ \Str::replace('_', ' ', ucfirst($order->shipping_status)) }}
                                </span>
                            @endif
                        </td>
{{--                        <td>--}}
{{--                            --}}{{-- TODO: Create suitable images for inline display (crop canvas top and bottom) --}}
{{--                            @if($order->payment_method === 'wire_transfer')--}}
{{--                                <img class="img-fluid w-25 mb-0" src="{{ static_asset(path: 'images/wire-transfer-logo-transparent.png', theme: true) }}" >--}}
{{--                            @elseif($order->payment_method === 'paypal')--}}
{{--                                <div class="d-flex align-items-center">--}}
{{--                                    <img class="img-fluid w-25 mb-0 mr-2" src="{{ static_asset(path: 'images/paypal-logo-transparent-512.png', theme: true) }}">--}}
{{--                                    <span class="d-inline-block">{{ preg_replace('/(?!^).(?=[^@]+@)/', '*', $order->email) }}</span>--}}
{{--                                </div>--}}
{{--                            @elseif($order->payment_method === 'stripe')--}}
{{--                                <img class="img-fluid w-25 mb-0" src="{{ static_asset(path: 'images/stripe-logo-transparent-512.png', theme: true) }}" >--}}
{{--                            @elseif($order->payment_method === 'paysera')--}}
{{--                                <img class="img-fluid w-25 mb-0" src="{{ static_asset(path: 'images/paysera-logo-transparent-512.png', theme: true) }}" >--}}
{{--                            @endif--}}
{{--                        </td>--}}
                        <td>
                            <strong class="text-14">{{ \FX::formatPrice($order->total_price) }}</strong>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a class="btn btn-sm btn-white" href="{{ route('order.details', ['id' => $order->id]) }}">
                                    <i class="tio-visible-outlined"></i> {{ translate('View') }}
                                </a>

                                <!-- Unfold -->
                                <div class="hs-unfold btn-group">
                                    <a class="js-hs-unfold-invoker btn btn-icon btn-sm btn-white dropdown-toggle dropdown-toggle-empty" href="javascript:;"
                                       data-hs-unfold-options='{
                                            "target": "#orderExportDropdown-{{ $order->id }}",
                                            "type": "css-animation",
                                            "smartPositionOffEl": "#ordersDatatable"
                                       }'
                                       data-hs-unfold-target="#orderExportDropdown-{{ $order->id }}" data-hs-unfold-invoker=""></a>

                                    <div id="orderExportDropdown-{{ $order->id }}" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right mt-1 hs-unfold-content-initialized hs-unfold-css-animation animated hs-unfold-hidden" data-hs-target-height="330.625" data-hs-unfold-content="" data-hs-unfold-content-animation-in="slideInUp" data-hs-unfold-content-animation-out="fadeOut" style="animation-duration: 300ms;">
                                        <span class="dropdown-header">{{ translate('Options') }}</span>s
                                        <a class="js-export-print dropdown-item d-flex " href="javascript:;">
                                            @svg('heroicon-o-printer', ['class' => 'square-18 mr-2'])
                                            {{ translate('Print') }}
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <span class="dropdown-header">Download options</span>
                                        <a class="js-export-excel dropdown-item" href="javascript:;">
                                            <img class="avatar avatar-xss avatar-4by3 mr-2" src="./assets/svg/brands/excel.svg" alt="Image Description">
                                            Excel
                                        </a>
                                        <a class="js-export-csv dropdown-item" href="javascript:;">
                                            <img class="avatar avatar-xss avatar-4by3 mr-2" src="./assets/svg/components/placeholder-csv-format.svg" alt="Image Description">
                                            .CSV
                                        </a>
                                        <a class="js-export-pdf dropdown-item" href="javascript:;">
                                            <img class="avatar avatar-xss avatar-4by3 mr-2" src="./assets/svg/brands/pdf.svg" alt="Image Description">
                                            PDF
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="javascript:;">
                                            <i class="tio-delete-outlined dropdown-item-icon"></i> Delete
                                        </a>
                                    </div>
                                </div>
                                <!-- End Unfold -->
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- End Table -->

        <!-- Footer -->
        <div class="card-footer">
            <!-- Pagination -->
            <div class="row justify-content-center justify-content-sm-between align-items-sm-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <div class="d-flex justify-content-center justify-content-sm-start align-items-center">
                        <span class="mr-2">{{ translate('Showing') }}:</span>

                        <!-- Select -->
                        <select id="ordersDatatablePerPage" class="js-select2-custom"
                                data-hs-select2-options='{
                                    "minimumResultsForSearch": "Infinity",
                                    "customClass": "custom-select custom-select-sm custom-select-borderless",
                                    "dropdownAutoWidth": true,
                                    "width": true
                                  }'>
                            <option value="10">10</option>
                            <option value="15" selected>15</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="50">40</option>
                            <option value="50">50</option>
                            <option value="75">75</option>
                            <option value="100">100</option>
                        </select>
                        <!-- End Select -->

                        <span class="text-secondary mr-2">{{ translate('of') }}</span>

                        <!-- Pagination Quantity -->
                        <span id="ordersDatatableTotalQty">{{ $orders_count }}</span>
                    </div>
                </div>

                <div class="col-sm-auto">
                    <div class="d-flex justify-content-center justify-content-sm-end">
                        <!-- Pagination -->
                        <nav id="ordersDatatablePagination" aria-label="Activity pagination"></nav>
                    </div>
                </div>
            </div>
            <!-- End Pagination -->
        </div>
        <!-- End Footer -->
    </div>
@endsection

@push('footer_scripts')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-colvis-2.1.1/b-html5-2.1.1/b-print-2.1.1/date-1.1.1/fh-3.2.0/r-2.2.9/sl-1.3.4/datatables.min.js"></script>

    <script src="{{ static_asset('vendor/hs-toggle-switch/dist/hs-toggle-switch.min.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs-sticky-block/dist/hs-sticky-block.min.js', false, true) }}"></script>

    <!-- JS Front -->
    <script src="{{ static_asset('vendor/hs.mask.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs.select2.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs.quill.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs.sortable.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs.flatpickr.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs.datatables.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/ev.toast-ui-editor.js', false, true) }}"></script>

    <script>
        $(window).on('load', function () {
            // INITIALIZATION OF DATATABLES
            // =======================================================
            var datatable = $.HSCore.components.HSDatatables.init($('#ordersDatatable'));

            $('#toggleColumn_position').on('change', function (e) {
                datatableSortingColumn.columns(1).visible(e.target.checked)
            });

            $('#toggleColumn_country').on('change', function (e) {
                datatable.columns(2).visible(e.target.checked)
            });

            $('#toggleColumn_status').on('change', function (e) {
                datatableSortingColumn.columns(3).visible(e.target.checked)
            });

            $('.js-select2-custom').each(function () {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });

            // INITIALIZATION OF UNFOLD
            // =======================================================
            $('.js-hs-unfold-invoker').each(function () {
                var unfold = new HSUnfold($(this)).init();
            });
        });
    </script>
@endpush
