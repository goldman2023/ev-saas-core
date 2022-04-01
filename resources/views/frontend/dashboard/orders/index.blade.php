@extends('frontend.layouts.user_panel')

@section('page_title', translate('All Orders'))

@push('head_scripts')
{{--    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-colvis-2.1.1/b-html5-2.1.1/b-print-2.1.1/date-1.1.1/fh-3.2.0/r-2.2.9/sl-1.3.4/datatables.min.css"/>--}}
@endpush

@section('panel_content')
    <x-dashboard.section-headers.section-header title="{{ translate('All orders') }}" text="">
        <x-slot name="content">
            <a href="{{ route('order.create') }}" class="btn-primary">
                @svg('heroicon-o-plus', ['class' => 'h-4 h-4 mr-2'])
                <span>{{ translate('Add new') }}</span>
            </a>
        </x-slot>
    </x-dashboard.section-headers.section-header>

    <div class="w-full">
        @if($orders_count > 0)
            <livewire:dashboard.tables.orders-table for="shop"></livewire:dashboard.tables.orders-table>
        @else
            <x-dashboard.empty-states.no-items-in-collection 
                icon="heroicon-o-document" 
                title="{{ translate('No orders yet') }}"
                text="{{ translate('Engage your customers so you can get a new order!') }}"
                link-href-route="order.create"
                link-text="{{ translate('Add new Order') }}">

            </x-dashboard.empty-states.no-items-in-collection>
        @endif
        
        {{-- <div class="col-6">
            <x-default.dashboard.widgets.create-card></x-default.dashboard.widgets.create-card>
        </div>
    
        <div class="col-6">
            <x-default.dashboard.widgets.create-card title="Create a subscription product" description="Create a recurring digital product"></x-default.dashboard.widgets.create-card>
        </div> --}}
    </div>

    <div class="w-full grid grid-cols-12 gap-4 mt-5">
        <div class="col-span-12 md:col-span-6 lg:col-span-4 flex">
            <div class="shadow rounded border border-gray-200 bg-white p-4 w-full mb-3">
                <a href="{{ route('order.create') }}" class="flex flex-col">
                    <div class="pb-2">
                        @svg('lineawesome-file-invoice-solid', ['class' => 'w-[32px] h-[32px]'])
                    </div>
                    <h5 class="text-20">
                        {{ translate('Create Order') }}
                    </h5>
                    <p class="text-dark text-14 mb-4">
                        {{ translate('Create full order manually.') }}
                    </p>
                    <span class="text-link flex items-center mt-auto">
                        {{ translate('Get Started') }}
                        @svg('heroicon-o-arrow-narrow-right', ['class' => 'w-[16px] h-[16px] ml-2'])
                    </span>
                </a>
            </div>
        </div>
        <div class="col-span-12 md:col-span-6 lg:col-span-4 flex">
            <div class="shadow rounded border border-gray-200 bg-white p-4 w-full mb-3">
                <a href="#" class="flex flex-col">
                    <div class="pb-2">
                        @svg('lineawesome-question-solid', ['class' => 'w-[32px] h-[32px]'])
                    </div>
                    <h5 class="text-20">
                        {{ translate('Create Proposal') }}
                    </h5>
                    <p class="text-dark text-14 mb-4">
                        {{ translate('Create order as a proposal for possible future payments.') }}
                    </p>
                    <span class="text-link flex items-center mt-auto">
                        {{ translate('Get Started') }}
                        @svg('heroicon-o-arrow-narrow-right', ['class' => 'w-[16px] h-[16px] ml-2'])
                    </span>
                </a>
            </div>
        </div>
    </div>

@endsection

@push('footer_scripts')
{{--    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>--}}
{{--    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>--}}
{{--    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-colvis-2.1.1/b-html5-2.1.1/b-print-2.1.1/date-1.1.1/fh-3.2.0/r-2.2.9/sl-1.3.4/datatables.min.js"></script>--}}

    <script src="{{ static_asset('vendor/hs-toggle-switch/dist/hs-toggle-switch.min.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs-sticky-block/dist/hs-sticky-block.min.js', false, true) }}"></script>

@endpush
