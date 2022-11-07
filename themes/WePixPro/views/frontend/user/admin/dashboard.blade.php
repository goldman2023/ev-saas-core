@extends('frontend.layouts.user_panel')

@section('panel_content')

<section>
    <div class="grid grid-cols-3">
        <div class="col-span-1">
        </div>

        <div class="col-span-1">
        </div>
    </div>
</section>

<section>
    <div class="row">
        <div class="grid">
            <div class="mb-6">
                <x-dashboard.widgets.business.dynamic-k-p-i></x-dashboard.widgets.business.dynamic-k-p-i>
            </div>


        </div>


        <div class="grid sm:grid-cols-3 gap-8">

            <div class="sm:col-span-2">
                <div class="mb-6">
                    <x-dashboard.widgets.business.quick-actions>
                    </x-dashboard.widgets.business.quick-actions>
                </div>

                <div>
                    <x-default.products.recently-viewed-products></x-default.products.recently-viewed-products>
                </div>

                <div class="">
                    <x-dashboard.section-headers.section-header title="{{ translate('Latest users') }}" text="">
                        <x-slot name="content">
                            <a href="{{ route('crm.all_customers') }}" class="btn-primary">
                                <span>{{ translate('All Customers') }}</span>
                                @svg('heroicon-o-arrow-right', ['class' => 'h-4 h-4 mr-2'])

                            </a>
                        </x-slot>
                    </x-dashboard.section-headers.section-header>
                    <div class="w-full">
                        <livewire:dashboard.tables.users-table perPage="5" :showFilters="false" :showFilterDropdown="false" :showFilters="false" :showSearch="false" :showPagination="false" for="customer"></livewire:dashboard.tables.users-table>
                    </div>
                </div>


            </div>

            <div class="col-span-1">
                @livewire('dashboard.elements.activity-log')
            </div>
        </div>

    </div>
</section>



<section class="stats mb-3">
    <div class="sm:grid sm:grid-cols-2 gap-5">
        <div class="">
            <div class="mt-3">
            </div>
        </div>
    </div>
</section>

@endsection
