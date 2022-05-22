@extends('frontend.layouts.user_panel')
@section('meta_title', translate('My Shop Settings'))

@section('panel_content')
    <section>
        <x-dashboard.section-headers.section-header title="{{ translate('Shop settings') }}" text="">
            <x-slot name="content">
                <a href="{{ $shop->getPermalink() }}"
                    target="_blank"
                    class="btn-primary">
                    @svg('heroicon-o-user', ['class' => 'h-4 h-4 mr-2'])
                    <span>{{ translate('My shop') }}</span>
                </a>
            </x-slot>
        </x-dashboard.section-headers.section-header>

        <livewire:dashboard.forms.settings.my-shop-form></livewire:dashboard.forms.settings.my-shop-form>
    </section>
@endsection


@push('footer_scripts')
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js"></script>
@endpush
