@extends('frontend.layouts.user_panel')

@section('page_title', translate('All Plans'))

@push('head_scripts')

@endpush

@section('panel_content')
    <section>
        <x-dashboard.section-headers.section-header title="{{ translate('All Plans') }}" text="Workcation is a property rental website. Etiam ullamcorper massa viverra consequat, consectetur id nulla tempus. Fringilla egestas justo massa purus sagittis malesuada.">
            <x-slot name="content">
                <a href="{{ route('plan.create') }}" class="btn-primary">
                    @svg('heroicon-o-plus', ['class' => 'h-4 h-4 mr-2'])
                    <span>{{ translate('Add new Plan') }}</span>
                </a>
            </x-slot>
        </x-dashboard.section-headers.section-header>
  
        <div class="w-full">
            @if($plans->isNotEmpty())
                <livewire:dashboard.tables.plans-table></livewire:dashboard.tables.plans-table>
            @else
                <x-dashboard.empty-states.no-items-in-collection 
                    icon="heroicon-o-document" 
                    title="{{ translate('No plans yet') }}" 
                    text="{{ translate('Get your business going by creating a subscription plan!') }}"
                    link-href-route="plan.create"
                    link-text="{{ translate('Add new Plan') }}">

                </x-dashboard.empty-states.no-items-in-collection>
            @endif
            
        </div>
    </section>
@endsection

@push('footer_scripts')
    {{--    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>--}}
    {{--    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>--}}
    {{--    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-colvis-2.1.1/b-html5-2.1.1/b-print-2.1.1/date-1.1.1/fh-3.2.0/r-2.2.9/sl-1.3.4/datatables.min.js"></script>--}}
@endpush
