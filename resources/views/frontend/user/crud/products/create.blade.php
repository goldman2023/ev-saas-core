@extends('frontend.layouts.user_panel')

@section('page_title', translate('Add New Product'))

@push('head_scripts')

@endpush

@section('panel_content')
    <section id="app">
        {!! $form->render() !!}
    </section>
@endsection

@push('footer_scripts')
    <script src="{{ static_asset('js/vue.js', false, true) }}"></script>
@endpush
