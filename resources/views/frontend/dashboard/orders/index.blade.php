@extends('frontend.layouts.user_panel')

@section('page_title', translate('All Orders'))

@push('head_scripts')
{{--    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-colvis-2.1.1/b-html5-2.1.1/b-print-2.1.1/date-1.1.1/fh-3.2.0/r-2.2.9/sl-1.3.4/datatables.min.css"/>--}}
@endpush

@section('panel_content')
    <!-- Card -->
    <div class="card">
        <!-- Header -->
        <div class="card-header">
            <h5 class="card-header-title">{{ translate('All Orders') }}</h5>
            <a href="{{ route('order.create') }}" class="btn btn-primary btn-xs">{{ translate('Add new') }}</a>

        </div>
        <!-- End Header -->

        <div class="card-body">
            @if($orders_count > 0)
                <livewire:dashboard.tables.orders-table></livewire:dashboard.tables.orders-table>
            @endif
        </div>

        <!-- Footer -->
{{--        <div class="card-footer">--}}
{{--            <!-- Pagination -->--}}
{{--            <div class="row justify-content-center justify-content-sm-between align-items-sm-center">--}}
{{--                <div class="col-sm mb-2 mb-sm-0">--}}
{{--                    <div class="d-flex justify-content-center justify-content-sm-start align-items-center">--}}
{{--                        <span class="mr-2">{{ translate('Showing') }}:</span>--}}

{{--                        <!-- Select -->--}}
{{--                        <select id="ordersDatatablePerPage" class="js-select2-custom"--}}
{{--                                data-hs-select2-options='{--}}
{{--                                    "minimumResultsForSearch": "Infinity",--}}
{{--                                    "customClass": "custom-select custom-select-sm custom-select-borderless",--}}
{{--                                    "dropdownAutoWidth": true,--}}
{{--                                    "width": true--}}
{{--                                  }'>--}}
{{--                            <option value="10">10</option>--}}
{{--                            <option value="15" selected>15</option>--}}
{{--                            <option value="20">20</option>--}}
{{--                            <option value="30">30</option>--}}
{{--                            <option value="50">40</option>--}}
{{--                            <option value="50">50</option>--}}
{{--                            <option value="75">75</option>--}}
{{--                            <option value="100">100</option>--}}
{{--                        </select>--}}
{{--                        <!-- End Select -->--}}

{{--                        <span class="text-secondary mr-2">{{ translate('of') }}</span>--}}

{{--                        <!-- Pagination Quantity -->--}}
{{--                        <span id="ordersDatatableTotalQty">{{ $orders_count }}</span>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="col-sm-auto">--}}
{{--                    <div class="d-flex justify-content-center justify-content-sm-end">--}}
{{--                        <!-- Pagination -->--}}
{{--                        <nav id="ordersDatatablePagination" aria-label="Activity pagination"></nav>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <!-- End Pagination -->--}}
{{--        </div>--}}
        <!-- End Footer -->
    </div>


    <div class="row mt-5">
        <div class="col-12 col-md-6 col-lg-4 d-flex">
            <div class="card w-100 mb-3">
                <a href="{{ route('dashboard') }}" class="card-body d-flex flex-column">
                    <div class="pb-2">
                        @svg('lineawesome-file-invoice-solid', ['class' => 'square-32'])
                    </div>
                    <h5 class="text-20">
                        {{ translate('Create Order') }}
                    </h5>
                    <p class="text-dark text-14 mb-4">
                        {{ translate('Create full order manually.') }}
                    </p>
                    <span class="text-link d-flex align-items-center mt-auto">
                        {{ translate('Get Started') }}
                        @svg('heroicon-o-arrow-narrow-right', ['class' => 'square-16 ml-2'])
                    </span>
                </a>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4 d-flex">
            <div class="card w-100 mb-3">
                <a href="{{ route('dashboard') }}" class="card-body d-flex flex-column">
                    <div class="pb-2">
                        @svg('lineawesome-question-solid', ['class' => 'square-32'])
                    </div>
                    <h5 class="text-20">
                        {{ translate('Create Proposal') }}
                    </h5>
                    <p class="text-dark text-14 mb-4">
                        {{ translate('Create order as a proposal for possible future payments.') }}
                    </p>
                    <span class="text-link d-flex align-items-center mt-auto">
                        {{ translate('Get Started') }}
                        @svg('heroicon-o-arrow-narrow-right', ['class' => 'square-16 ml-2'])
                    </span>
                </a>
            </div>
        </div>
{{--        <div class="col-12 col-md-6 col-lg-4 d-flex">--}}
{{--            <div class="card w-100 mb-3">--}}
{{--                <a href="{{ route('dashboard') }}" class="card-body d-flex flex-column">--}}
{{--                    <div class="pb-2">--}}
{{--                        @svg('lineawesome-file-invoice-dollar-solid', ['class' => 'square-32'])--}}
{{--                    </div>--}}
{{--                    <h5 class="text-20">--}}
{{--                        {{ translate('Create Invoice') }}--}}
{{--                    </h5>--}}
{{--                    <p class="text-dark text-14 mb-4">--}}
{{--                        {{ translate('Create single invoice for specific products/services manually.') }}--}}
{{--                    </p>--}}
{{--                    <span class="text-link d-flex align-items-center mt-auto">--}}
{{--                        {{ translate('Get Started') }}--}}
{{--                        @svg('heroicon-o-arrow-narrow-right', ['class' => 'square-16 ml-2'])--}}
{{--                    </span>--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>

@endsection

@push('footer_scripts')
{{--    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>--}}
{{--    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>--}}
{{--    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-colvis-2.1.1/b-html5-2.1.1/b-print-2.1.1/date-1.1.1/fh-3.2.0/r-2.2.9/sl-1.3.4/datatables.min.js"></script>--}}

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
@endpush
