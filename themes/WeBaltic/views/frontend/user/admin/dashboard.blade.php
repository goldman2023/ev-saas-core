@extends('frontend.layouts.user_panel')

@section('panel_content')

<section>
    <div class="row">
        <div class="grid">
            <div class="mb-6">
                <x-dashboard.widgets.business.dynamic-k-p-i></x-dashboard.widgets.business.dynamic-k-p-i>
            </div>


        </div>


        <div class="grid sm:grid-cols-3 gap-8">

            <div class="col-span-2">
                <div class="mb-6">
                    <x-dashboard.widgets.business.quick-actions>
                    </x-dashboard.widgets.business.quick-actions>
                </div>
                <div class="div grid grid-cols-2 gap-6">
                    <div>
                    {{-- <x-dashboard.widgets.charts.column-chart>
                    </x-dashboard.widgets.charts.column-chart> --}}
                    </div>

                    <div>
                    {{-- <x-dashboard.widgets.charts.pie-chart>
                    </x-dashboard.widgets.charts.pie-chart> --}}
                    </div>
                </div>

            </div>

            <div class="col-span-1">
                <div class=" mb-6 bg-white p-6 rounded-xl shadow">
                    <x-dashboard.widgets.business.calendar-summary></x-dashboard.widgets.business.calendar-summary>
                </div>



                <x-dashboard.orders.latest-orders></x-dashboard.orders.latest-orders>

                @livewire('dashboard.elements.activity-log')

            </div>
        </div>

    </div>
</section>



<section class="stats mb-3">
    <div class="sm:grid sm:grid-cols-2 gap-5">
        {{-- <x-default.dashboard.widgets.integrations-widget>

        </x-default.dashboard.widgets.integrations-widget> --}}


        <div class="">
            <div class="mt-3">
            </div>
        </div>
    </div>
</section>

<section>

</section>
@endsection
