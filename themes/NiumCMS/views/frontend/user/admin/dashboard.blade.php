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


        <div class="sm:grid sm:grid-cols-3 gap-8">

            <div class="col-span-2">
                <div class="mb-6">
                    <x-dashboard.widgets.charts.pie-chart>
                    </x-dashboard.widgets.charts.pie-chart>
                </div>

                <div class="mb-6">
                    <x-dashboard.widgets.business.quick-actions>
                    </x-dashboard.widgets.business.quick-actions>
                </div>
                <div class="div grid grid-cols-2 gap-6">

                </div>
            </div>

            <div class="col-span-1">
                <div class="mb-6">
                    <x-dashboard.widgets.quick-links>
                    </x-dashboard.widgets.quick-links>
                </div>

                @livewire('dashboard.elements.activity-log')

            </div>
        </div>

    </div>
</section>
@endsection
