@extends('frontend.layouts.user_panel')

@section('page_title', translate('Add New Product'))

@push('head_scripts')
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
@endpush

@section('panel_content')
    <section id="app">
        {{-- $form->render() --}}
        <livewire:forms.products.product-form page="general" :product="$product"/>
    </section>
@endsection

@push('footer_scripts')
    <script src="{{ static_asset('js/aiz-core.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs-step-form/dist/hs-step-form.min.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs-add-field/dist/hs-add-field.min.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs-sticky-block/dist/hs-sticky-block.min.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs-toggle-switch/dist/hs-toggle-switch.min.js', false, true) }}"></script>

    <!-- JS Front -->
    <script src="{{ static_asset('vendor/hs.mask.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs.select2.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs.quill.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs.sortable.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs.flatpickr.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs.datatables.js', false, true) }}"></script>

    <script src="{{ static_asset('js/crud/product-form.js', false, true, true) }}"></script>
@endpush
