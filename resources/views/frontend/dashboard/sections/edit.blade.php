@extends('frontend.layouts.user_panel')

@section('page_title', translate('Edit Section').': '.$section->name)

@push('head_scripts')

@endpush

@section('panel_content')
    <section>
        <x-dashboard.section-headers.section-header title="{{ translate('Edit Section') }}" text="">
            <x-slot name="content">
                <a href="{{ route('sections.index') }}" class="btn-standard">
                    @svg('heroicon-o-chevron-left', ['class' => 'h-4 h-4 mr-2'])
                    <span>{{ translate('All sections') }}</span>
                </a>
            </x-slot>
        </x-dashboard.section-headers.section-header>
        <div class="grid grid-cols-12 gap-8">
            <div class="col-span-12">
                <livewire:dashboard.forms.sections.section-form :section="$section">
            </div>
            
            {{-- <div class="col-span-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-3">
                    {{ translate('Preview') }}
                </h3>
                <iframe class="rounded-md bg-white w-full min-h-[600px]" src="{{ $section->getPermalink() }}?preview=true"> </iframe>
            </div> --}}
        </div>
    </section>
@endsection

@push('footer_scripts')
    {{--    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>--}}
    {{--    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>--}}
    {{--    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-colvis-2.1.1/b-html5-2.1.1/b-print-2.1.1/date-1.1.1/fh-3.2.0/r-2.2.9/sl-1.3.4/datatables.min.js"></script>--}}
@endpush
