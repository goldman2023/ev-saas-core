@extends('frontend.layouts.user_panel')

@section('page_title', translate('Add new plan'))

@push('head_scripts')
<link href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js"></script>
@endpush

@section('panel_content')
    <section>
        <div class="pb-5 mb-5 border-b border-gray-200 sm:flex sm:items-center sm:justify-between">
            <div class="">
                <h3 class="text-24 leading-6 font-semibold text-gray-900">{{ translate('New Plan') }}</h3>
                {{-- <p class="mt-2 max-w-4xl text-sm text-gray-500">Workcation is a property rental website. Etiam ullamcorper massa viverra consequat, consectetur id nulla tempus. Fringilla egestas justo massa purus sagittis malesuada.</p>     --}}
            </div>
            <div class="flex sm:mt-0 sm:ml-4">
                <a href="{{ route('plans.index') }}" class="btn-standard">
                    @svg('heroicon-o-chevron-left', ['class' => 'h-4 h-4 mr-2'])
                    <span>{{ translate('All plans') }}</span>
                </a>
            </div>
        </div>

        <livewire:dashboard.forms.plans.plan-form ></livewire:dashboard.forms.plans.plan-form>
    </section>
@endsection

@push('footer_scripts')
    {{--    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>--}}
    {{--    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>--}}
    {{--    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-colvis-2.1.1/b-html5-2.1.1/b-print-2.1.1/date-1.1.1/fh-3.2.0/r-2.2.9/sl-1.3.4/datatables.min.js"></script>--}}
@endpush
