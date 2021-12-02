@extends('frontend.layouts.user_panel')

@section('page_title', translate('All Products'))

@push('head_scripts')
    <script src="https://unpkg.com/alpinejs@3.5.1/dist/cdn.min.js" defer></script>
@endpush

@section('panel_content')
<div class="card d-flex flex-row justify-content-start pl-3 py-3 mb-3 align-items-center">
    <a href="{{ back()->getTargetUrl() }}" class="text-secondary mr-4" style="height: 32px;">
        @svg('heroicon-o-chevron-left', ['style' => 'height: 32px;'])
    </a>

    <h2 class="h3 d-flex align-items-center my-0">
            <span class="avatar avatar-circle mr-3">
                <img class="avatar-img" src="{{ $product->getThumbnail() }}">
            </span>
        <span>{{ $product->getTranslation('name') }}</span>
    </h2>

    <div class="ml-auto d-flex align-items-center pr-3">
        <a class="btn btn-soft-dark btn-circle btn-xs d-inline-flex align-items-center mr-2"
           href="{{ route('ev-products.details', $product->slug) }}" target="_blank">
            @svg('heroicon-o-eye', ['class' => 'square-16 mr-2'])
            {{ translate('Details') }}
        </a>

        <a class="btn btn-soft-dark btn-circle btn-xs d-inline-flex align-items-center"
           href="{{ route('ev-products.edit.stocks', $product->slug) }}">
            @svg('heroicon-o-archive', ['class' => 'square-16 mr-2'])
            {{ translate('Stock Management') }}
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body pt-2">
        <div class="card-header pl-2 mb-3">
            <h5 class="card-header-title">{{ translate('Product Variations') }}</h5>
        </div>

        <livewire:forms.products.product-variations-table
            class="ev-product-variations-component"
            :emptyMessage="translate('Please generate all variations or add them manually.')"
            :product="$product"
        >
        </livewire:forms.products.product-variations-table>
    </div>
</div>
@endsection

@push('footer_scripts')
    <script src="{{ static_asset('js/aiz-core.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs-toggle-switch/dist/hs-toggle-switch.min.js', false, true) }}"></script>

    <script src="{{ static_asset('vendor/hs.select2.js', false, true) }}"></script>

    <script src="{{ static_asset('js/crud/product-variations-table.js', false, true, true) }}"></script>
@endpush
