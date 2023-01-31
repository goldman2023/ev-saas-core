@extends('frontend.layouts.user_panel')

@section('page_title', translate('Browse Licenses'))
@section('meta_title', translate('Browse Licenses'))

@section('panel_content')
<section>
    <x-dashboard.section-headers.section-header title="{{ translate('Licenses') }}"
        text="{{ translate('Browse licenses by status.') }}">
        <x-slot name="content">

        </x-slot>
    </x-dashboard.section-headers.section-header>

    {{-- <div class="mb-6">
        <x-dashboard.widgets.business.dynamic-k-p-i></x-dashboard.widgets.business.dynamic-k-p-i>
    </div> --}}

    <div class="grid md:grid-cols-1 gap-6">
        <div>

            <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab"
                    data-tabs-toggle="#myTabContent" role="tablist">

                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 rounded-t-lg border-b-2" id="all_licenses_tab"
                            data-tabs-target="#all_licenses" type="button" role="tab" aria-controls="profile"
                            aria-selected="false">
                            {{ translate('All') }}
                        </button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button
                            class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                            id="expired_licenses_tab" data-tabs-target="#expired_licenses" type="button" role="tab"
                            aria-controls="dashboard" aria-selected="false">
                            {{ translate('Expired') }}
                        </button>
                    </li>

                </ul>
            </div>
            <div id="myTabContent">
                <div class="hidden rounded-lg dark:bg-gray-800" id="all_licenses" role="tabpanel">
                    <livewire:dashboard.tables.licenses-table :show-search="true" :show-filters="true"
                        :show-filter-dropdown="true" :show-per-page="true" :column-select="true" />
                </div>
                <div class="hidden  rounded-lg dark:bg-gray-800" id="expired_licenses" role="tabpanel"
                    aria-labelledby="dashboard-tab">
                    <livewire:dashboard.tables.licenses-table :only_expired="true" :show-search="true"
                        :show-filters="true" :show-filter-dropdown="true" :show-per-page="true"
                        :column-select="false" />
                </div>
            </div>
        </div>
    </div>

</section>
@endsection

@push('modal')
    @include('frontend.partials.pix-pro-license-modals', ['user' => null])
@endpush

@push('footer_scripts')

@endpush
