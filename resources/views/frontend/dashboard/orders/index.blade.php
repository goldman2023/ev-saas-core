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
            <livewire:dashboard.tables.orders-table for="shop"></livewire:dashboard.tables.orders-table>
        </div>
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

@endpush
