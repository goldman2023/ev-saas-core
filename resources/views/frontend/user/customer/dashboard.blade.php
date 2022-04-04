@extends('frontend.layouts.user_panel')

@section('panel_content')
<section>
    <div class="row">
        <div class="grid">
            <x-dashboard.widgets.user-welcome></x-dashboard.widgets.user-welcome>
        </div>
        <div class="grid grid-cols-4 gap-12 mb-12">

            <div class="lg:col-span-2 col-span-4">
                <x-dashboard.elements.support-card class="card bg-white p-4 mb-3">
                </x-dashboard.elements.support-card>
            </div>

            <div>



            </div>

        </div>
    </div>
</section>

<section class="recently-viewed-products mb-3">
    <div class="">
        <x-default.products.recently-viewed-products></x-default.products.recently-viewed-products>
    </div>
</section>
@endsection
