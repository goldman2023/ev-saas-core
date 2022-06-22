@extends('frontend.layouts.user_panel')

@section('page_title', translate('Plans management'))

@push('head_scripts')

@endpush

@section('panel_content')
<section>
    <x-dashboard.section-headers.section-header title="{{ translate('Plans Management') }}"
        text="{{ translate('Manage your subscriptions, licenses and billing') }}">
        <x-slot name="content">
            @if(auth()->user()?->isSubscribed() ?? false)
            <a href="{{ route('stripe.portal_session') }}" class="btn-primary" target="_blank">
                {{ translate('Biling Portal') }}
            </a>
            @endif
        </x-slot>
    </x-dashboard.section-headers.section-header>

    @if(auth()->user()?->isSubscribed() ?? false)
    <div class="w-full pb-5 mb-5 border-b border-gray-200">
        <div class="flex justify-between items-center bg-white py-4 px-4 border border-gray-200 rounded-lg">
            <h4 class="text-18 text-gray-900 font-semibold">{{ translate('Subscriptions') }}</h4>
        </div>

        <livewire:dashboard.tables.my-subscriptions-table :user="auth()->user()" :show-search="false"
            :show-filters="false" :show-filter-dropdown="false" :show-per-page="false" :column-select="false" />
    </div>
    {{-- Second parameter is a variable sent to do action --}}
    @do_action('view.dashboard.plans-management.plans-table.end', auth()->user())
    @endif

    <x-dashboard.widgets.customer.pricing-table :plans="$plans">
    </x-dashboard.widgets.customer.pricing-table>

    </div>
</section>
@endsection

@push('footer_scripts')
{{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
--}}
{{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
--}}
{{-- <script type="text/javascript"
    src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-colvis-2.1.1/b-html5-2.1.1/b-print-2.1.1/date-1.1.1/fh-3.2.0/r-2.2.9/sl-1.3.4/datatables.min.js">
</script>--}}
@endpush
