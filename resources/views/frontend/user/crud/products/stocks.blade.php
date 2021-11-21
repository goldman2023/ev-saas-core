@extends('frontend.layouts.user_panel')

@section('page_title', translate('Stock Management - ').$product->getTranslation('name'))

@push('head_scripts')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.3/b-2.0.1/b-html5-2.0.1/fh-3.2.0/r-2.2.9/datatables.min.css"/>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
@endpush

@section('panel_content')
<div class="card d-flex flex-row justify-content-start pl-3 py-3 align-items-center">
    <a href="{{ back()->getTargetUrl() }}" class="text-secondary mr-4" style="height: 32px;">
        @svg('heroicon-o-chevron-left', ['style' => 'height: 32px;'])
    </a>

    <h2 class="h3 d-flex align-items-center my-0">
                <span class="avatar avatar-circle mr-3">
                    <img class="avatar-img" src="{{ $product->getThumbnail() }}">
                </span>
        <span>{{ $product->getTranslation('name') }}</span>
    </h2>
</div>

<livewire:forms.products.stock-management-form :product="$product">
</livewire:forms.products.stock-management-form>

@endsection

@push('footer_scripts')
    <script src="{{ static_asset('vendor/hs-add-field/dist/hs-add-field.min.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs-quantity-counter/dist/hs-quantity-counter.min.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs-toggle-switch/dist/hs-toggle-switch.min.js', false, true) }}"></script>

    <!-- CDN stuff -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.3/b-2.0.1/b-html5-2.0.1/fh-3.2.0/r-2.2.9/datatables.min.js"></script>


    <script src="{{ static_asset('vendor/hs.select2.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs.datatables.js', false, true) }}"></script>

    <script src="{{ static_asset('js/crud/stock-management-form.js', false, true, true) }}"></script>
@endpush
