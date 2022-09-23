@extends('frontend.layouts.user_panel')

@section('page_title', translate('Browse Licenses'))
@section('meta_title', translate('Browse Licenses'))

@section('panel_content')
    <section>
        <x-dashboard.section-headers.section-header title="{{ translate('Licenses') }}" text="{{ translate('Browse licenses by status.') }}">
            <x-slot name="content">

            </x-slot>
        </x-dashboard.section-headers.section-header>

        {{-- <div class="mb-6">
            <x-dashboard.widgets.business.dynamic-k-p-i></x-dashboard.widgets.business.dynamic-k-p-i>
        </div> --}}

        <div class="grid md:grid-cols-1 gap-6">
            <div>
                <h2>{{ translate('Expired Licenses') }} </h2>

                <livewire:dashboard.tables.licenses-table :show-search="false" :show-filters="true" :show-filter-dropdown="true" :show-per-page="true" :column-select="false"/>


            </div>
        </div>

    </section>
@endsection

@push('footer_scripts')

@endpush
