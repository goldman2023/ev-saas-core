@extends('frontend.layouts.user_panel')

@section('panel_content')

<section>
    <div class="grid grid-cols-3">
        <div class="col-span-1">
            {{-- <x-default.dashboard.widgets.onboarding-widget></x-default.dashboard.widgets.onboarding-widget> --}}
        </div>

        <div class="col-span-1">
            {{-- <x-default.promo.shop-subscribe></x-default.promo.shop-subscribe> --}}

        </div>
    </div>
</section>

<section>
    <div class="row">
        <div class="grid">
            <div>
                <x-dashboard.widgets.user-welcome></x-dashboard.widgets.user-welcome>
            </div>

            <div class="mb-6">
                <x-dashboard.widgets.shop.dynamic-k-p-i></x-dashboard.widgets.shop.dynamic-k-p-i>
            </div>

        </div>

        <div>
            <x-dashboard.widgets.business.quick-actions>
            </x-dashboard.widgets.business.quick-actions>
        </div>
        <div class="sm:grid sm:grid-cols-4 gap-5 gap-y-5 mb-12 grid">


            <div>

                <x-dashboard.elements.support-card class="card mb-3">
                </x-dashboard.elements.support-card>

            </div>

            <div>

            </div>

        </div>
    </div>
</section>



<section class="stats">
    <div class="grid sm:grid-cols-1 gap-5">
        <div class="card">
            <x-default.products.recently-viewed-products class="p-0"></x-default.products.recently-viewed-products>
        </div>
    </div>
</section>
@endsection
