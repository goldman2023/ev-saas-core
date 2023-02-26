@extends('frontend.layouts.user_panel')

@section('page_title', translate('Add New Product'))

@push('pre_head_scripts')
    <script>
        let all_categories = @json(\Categories::getAllFormatted());
    </script>
@endpush

@push('head_scripts')
<script src="{{ mix('js/editor.js', 'themes/WeTailwind') }}" defer></script>
@endpush


@section('panel_content')
    <section id="app">
        <livewire:dashboard.forms.products.product-form page="general" />
    </section>
@endsection
