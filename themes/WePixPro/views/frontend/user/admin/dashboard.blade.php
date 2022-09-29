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

            <div class="col-span-2">
                <div class="mb-6">
                    <x-dashboard.widgets.business.quick-actions>
                    </x-dashboard.widgets.business.quick-actions>
                </div>

                <div>
                    <x-default.products.recently-viewed-products></x-default.products.recently-viewed-products>
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
