@extends('frontend.layouts.user_panel')

@section('page_title', translate('Edit Product').': '.$product->getTranslation('name'))

@push('pre_head_scripts')
    <script>
        let all_categories = @json(\Categories::getAllFormatted());
    </script>
@endpush

@push('head_scripts')
    <link rel="stylesheet" href="https://uicdn.toast.com/editor/latest/toastui-editor.min.css" />
@endpush

@section('panel_content')
    <section id="app">
        <livewire:dashboard.forms.products.product-form2 :product="$product"></livewire:dashboard.forms.products.product-form2>
    </section>
@endsection

@push('footer_scripts')
    <script src="{{ static_asset('js/aiz-core.js', true, true) }}"></script>
    <script src="https://uicdn.toast.com/editor/latest/toastui-editor-all.min.js"></script>
    <script src="{{ static_asset('vendor/hs-step-form/dist/hs-step-form.min.js', true, true) }}"></script>
    <script src="{{ static_asset('vendor/hs-add-field/dist/hs-add-field.min.js', true, true) }}"></script>
    <script src="{{ static_asset('vendor/hs-sticky-block/dist/hs-sticky-block.min.js', true, true) }}"></script>
    <script src="{{ static_asset('vendor/hs-toggle-switch/dist/hs-toggle-switch.min.js', true, true) }}"></script>

    <!-- JS Front -->
    <script src="{{ static_asset('vendor/hs.mask.js', true, true) }}"></script>
    <script src="{{ static_asset('vendor/hs.select2.js', true, true) }}"></script>
    <script src="{{ static_asset('vendor/hs.quill.js', true, true) }}"></script>
    <script src="{{ static_asset('vendor/hs.sortable.js', true, true) }}"></script>
    <script src="{{ static_asset('vendor/hs.flatpickr.js', true, true) }}"></script>
    <script src="{{ static_asset('vendor/hs.datatables.js', true, true) }}"></script>
    <script src="{{ static_asset('vendor/ev.toast-ui-editor.js', true, true) }}"></script>

    <script src="{{ static_asset('js/crud/new-product-form.js', true, true, true) }}"></script>
    <script src="{{ static_asset('js/crud/product-variations-table.js', true, true, true) }}"></script>
@endpush
