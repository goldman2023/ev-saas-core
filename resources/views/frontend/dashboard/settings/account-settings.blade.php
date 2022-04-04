@extends('frontend.layouts.user_panel')
@section('page_title', translate('My Account Settings'))
@section('meta_title', translate('My Account Settings'))

@section('panel_content')
    <section>
        <x-dashboard.section-headers.section-header title="{{ translate('Account settings') }}" text="">
            <x-slot name="content">
                <a href="#" class="btn-primary">
                    @svg('heroicon-o-user', ['class' => 'h-4 h-4 mr-2'])
                    <span>{{ translate('My profile') }}</span>
                </a>
            </x-slot>
        </x-dashboard.section-headers.section-header>

        <livewire:dashboard.forms.settings.my-account-form></livewire:dashboard.forms.settings.my-account-form>
    </section>
@endsection


@push('footer_scripts')
    {{-- <script src="{{ static_asset('js/aiz-core.js', false, true) }}"></script>
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

    <script src="{{ static_asset('js/crud/account-settings-form.js', false, true, true) }}"></script> --}}
@endpush
