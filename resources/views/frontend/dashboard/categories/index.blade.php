@extends('frontend.layouts.user_panel')

@section('page_title', translate('All Categories'))

@push('head_scripts')

@endpush

@section('panel_content')
    <section>
        <div class="pb-5 mb-5 border-b border-gray-200 sm:flex sm:items-center sm:justify-between">
            <div class="">
                <h3 class="text-24 leading-6 font-semibold text-gray-900">{{ translate('All Categories') }}</h3>
                <p class="mt-2 max-w-4xl text-sm text-gray-500">Workcation is a property rental website. Etiam ullamcorper massa viverra consequat, consectetur id nulla tempus. Fringilla egestas justo massa purus sagittis malesuada.</p>    
            </div>
            <div class="flex sm:mt-0 sm:ml-4">
                <a href="{{ route('category.create') }}" class="btn-primary">
                    @svg('heroicon-o-plus', ['class' => 'h-4 h-4 mr-2'])
                    <span>{{ translate('Add new Category') }}</span>
                </a>
            </div>
        </div>
  
        <div class="w-full">
            @if($all_categories->isNotEmpty())
                <livewire:dashboard.tables.categories-table></livewire:dashboard.tables.categories-table>
            @else
                <x-dashboard.empty-states.no-items-in-collection 
                    icon="heroicon-o-document" 
                    title="{{ translate('No categories yet') }}" 
                    text="{{ translate('Get your business going by creating categories!') }}"
                    link-href-route="category.create"
                    link-text="{{ translate('Add new category') }}">

                </x-dashboard.empty-states.no-items-in-collection>
            @endif
            
        </div>
    </section>

{{--    <div class="row mt-5">--}}
{{--        <div class="col-12 col-md-6 col-lg-4 d-flex">--}}
{{--            <div class="card w-100 mb-3">--}}
{{--                <a href="{{ route('dashboard') }}" class="card-body d-flex flex-column">--}}
{{--                    <div class="pb-2">--}}
{{--                        @svg('lineawesome-file-invoice-solid', ['class' => 'square-32'])--}}
{{--                    </div>--}}
{{--                    <h5 class="text-20">--}}
{{--                        {{ translate('Create Order') }}--}}
{{--                    </h5>--}}
{{--                    <p class="text-dark text-14 mb-4">--}}
{{--                        {{ translate('Create full order manually.') }}--}}
{{--                    </p>--}}
{{--                    <span class="text-link d-flex align-items-center mt-auto">--}}
{{--                        {{ translate('Get Started') }}--}}
{{--                        @svg('heroicon-o-arrow-narrow-right', ['class' => 'square-16 ml-2'])--}}
{{--                    </span>--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="col-12 col-md-6 col-lg-4 d-flex">--}}
{{--            <div class="card w-100 mb-3">--}}
{{--                <a href="{{ route('dashboard') }}" class="card-body d-flex flex-column">--}}
{{--                    <div class="pb-2">--}}
{{--                        @svg('lineawesome-question-solid', ['class' => 'square-32'])--}}
{{--                    </div>--}}
{{--                    <h5 class="text-20">--}}
{{--                        {{ translate('Create Proposal') }}--}}
{{--                    </h5>--}}
{{--                    <p class="text-dark text-14 mb-4">--}}
{{--                        {{ translate('Create order as a proposal for possible future payments.') }}--}}
{{--                    </p>--}}
{{--                    <span class="text-link d-flex align-items-center mt-auto">--}}
{{--                        {{ translate('Get Started') }}--}}
{{--                        @svg('heroicon-o-arrow-narrow-right', ['class' => 'square-16 ml-2'])--}}
{{--                    </span>--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        </div>--}}
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
{{--    </div>--}}

@endsection

@push('footer_scripts')
    {{--    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>--}}
    {{--    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>--}}
    {{--    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-colvis-2.1.1/b-html5-2.1.1/b-print-2.1.1/date-1.1.1/fh-3.2.0/r-2.2.9/sl-1.3.4/datatables.min.js"></script>--}}
@endpush
