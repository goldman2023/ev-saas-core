@extends('frontend.layouts.user_panel')

@section('page_title', translate('Edit Plan').': '.$plan->getTranslation('title'))

@push('head_scripts')
    <link rel="stylesheet" href="https://uicdn.toast.com/editor/latest/toastui-editor.min.css" />
@endpush

@section('panel_content')
    <!-- Card -->
    <div class="card">
        <!-- Header -->
        <div class="card-header">
            <h5 class="card-header-title">{{ translate('Edit') }}: {{ $plan->getTranslation('title') }}</h5>
            <a href="{{ route('plans.index') }}" class="btn btn-primary btn-xs">{{ translate('All Plans') }}</a>
        </div>
        <!-- End Header -->

        <div class="card-body">
            <livewire:dashboard.forms.plans.plan-form :plan="$plan"></livewire:dashboard.forms.plans.plan-form>
{{--            <livewire:dashboard.forms.blog-posts.blog-post-form :plan="$plan"></livewire:dashboard.forms.blog-posts.blog-post-form>--}}
{{--            <livewire:dashboard.forms.blog-posts.blog-post-form :category="$category"></livewire:dashboard.forms.blog-posts.blog-post-form>--}}
        </div>
    </div>
@endsection

@push('footer_scripts')
    {{--    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>--}}
    {{--    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>--}}
    {{--    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-colvis-2.1.1/b-html5-2.1.1/b-print-2.1.1/date-1.1.1/fh-3.2.0/r-2.2.9/sl-1.3.4/datatables.min.js"></script>--}}

    <script src="{{ static_asset('js/aiz-core.js', false, true) }}"></script>
    <script src="https://uicdn.toast.com/editor/latest/toastui-editor-all.min.js"></script>

    <script src="{{ static_asset('vendor/hs.select2.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/ev.toast-ui-editor.js', false, true) }}"></script>

    <script src="{{ static_asset('js/crud/plan-form.js', false, true, true) }}"></script>
@endpush