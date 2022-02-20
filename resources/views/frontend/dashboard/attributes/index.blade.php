@extends('frontend.layouts.user_panel')

@section('page_title', translate('All Attributes'))

@push('head_scripts')

@endpush

@section('panel_content')
    <!-- Card -->
    <div class="card">
        <!-- Header -->
        <div class="card-header">
            <h5 class="card-header-title">
                {{ translate('All Attributes') }}
            </h5>
            <a href="{{ route('attributes.create', base64_encode($content_type)) }}" class="btn btn-primary btn-xs">{{ translate('Add new') }}</a>
        </div>
        <!-- End Header -->

        <div class="card-body">
            <livewire:dashboard.tables.attributes-table></livewire:dashboard.tables.attributes-table>
        </div>
    </div>
@endsection

@push('footer_scripts')
    {{--    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>--}}
    {{--    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>--}}
    {{--    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-colvis-2.1.1/b-html5-2.1.1/b-print-2.1.1/date-1.1.1/fh-3.2.0/r-2.2.9/sl-1.3.4/datatables.min.js"></script>--}}
@endpush
