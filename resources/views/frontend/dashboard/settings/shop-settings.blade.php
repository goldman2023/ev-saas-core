@extends('frontend.layouts.user_panel')
@section('page_title', translate('My Shop Settings'))
@section('meta_title', translate('My Shop Settings'))

@push('head_scripts')
    <link rel="stylesheet" href="https://uicdn.toast.com/editor/latest/toastui-editor.min.css" />
@endpush

@section('panel_content')
    <div class="card card-header mb-3">
        <h4 class="mb-0 h4">{{ translate('My shop settings')}}</h4>
        <a class="btn btn-primary" href="#">
            @svg('heroicon-o-user', ['class' => 'mr-2 square-16']) {{ translate('My shop') }}
        </a>
    </div>

    <livewire:dashboard.forms.settings.my-shop-form></livewire:dashboard.forms.settings.my-shop-form>

    <x-ev.toast id="my-account-updated-toast"
                position="bottom-center"
                class="bg-success border-success text-white h3"
                :is_x="true"
                :timeout="4000"
    ></x-ev.toast>
@endsection


@push('footer_scripts')
    <script src="{{ static_asset('js/aiz-core.js', false, true) }}"></script>
    <script src="https://uicdn.toast.com/editor/latest/toastui-editor-all.min.js"></script>
    <script src="{{ static_asset('vendor/pwstrength-bootstrap/dist/pwstrength-bootstrap.min.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs-step-form/dist/hs-step-form.min.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs-add-field/dist/hs-add-field.min.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs-sticky-block/dist/hs-sticky-block.min.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs-toggle-switch/dist/hs-toggle-switch.min.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs-go-to/dist/hs-go-to.min.js', false, true) }}"></script>

    <!-- JS Front -->
    <script src="{{ static_asset('vendor/hs.pwstrength.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs.mask.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs.select2.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs.quill.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs.sortable.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs.flatpickr.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs.datatables.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/ev.toast-ui-editor.js', false, true) }}"></script>

    <script src="{{ static_asset('js/crud/shop-settings-form.js', false, true, true) }}"></script>
@endpush
