@extends('frontend.layouts.' . $globalLayout)

@section('meta_title'){{ translate('Checkout page').' '.\TenantSettings::get('site_name').' | '.\TenantSettings::get('site_motto') }}@stop

@section('meta_keywords'){{ translate('checkout, cart, purchase, ecommerce') }}@stop

@section('meta')

@endsection

@section('content')

@endsection

@section('modal')

@endsection

@push('footer_scripts')
    <script src="{{ static_asset('vendor/hs-add-field/dist/hs-add-field.min.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs-toggle-switch/dist/hs-toggle-switch.min.js', false, true) }}"></script>

    <script src="{{ static_asset('vendor/hs.select2.js', false, true) }}"></script>

    <script src="{{ static_asset('js/crud/checkout-form.js', false, true, true) }}"></script>
@endpush
