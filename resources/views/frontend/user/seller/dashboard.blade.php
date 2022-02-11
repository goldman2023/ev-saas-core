@extends('frontend.layouts.user_panel')

@section('panel_content')

<section>
    <div class="row">
        <div class="col-12 we-horizontal-slider">
            <h5 class="text-white">{{ translate('Setup your company profile') }} </h5>
            <x-default.dashboard.widgets.onboarding-widget></x-default.dashboard.widgets.onboarding-widget>
        </div>

        <div class="col-12 mb-3">
            <x-default.promo.shop-subscribe></x-default.promo.shop-subscribe>
        </div>
    </div>
</section>

<section>
    <div class="row mb-3 we-horizontal-slider">
        <div class="col-10 col-sm-4">
            <x-default.dashboard.widgets.products-widget>
                <a href="{{ route('ev-products.index') }}">
                    {{ translate('View all') }}
                </a>
            </x-default.dashboard.widgets.products-widget>

        </div>

        <div class="col-10 col-sm-4">
            <x-default.dashboard.widgets.orders-widget>
                <a href="{{ route('orders.index') }}">
                    {{ translate('View all') }}
                </a>
            </x-default.dashboard.widgets.orders-widget>
        </div>
        <div class="col-10 col-sm-4">
            <x-default.dashboard.widgets.leads-widget>

                <a href="{{ route('leads.index') }}">
                    {{ translate('View all') }}
                </a>

            </x-default.dashboard.widgets.leads-widget>
        </div>
    </div>

</section>
<section>
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="card bg-white p-4 text-center">
                {{-- TODO : make this company name dynamic --}}
                <div class="h5 fw-600">{{ translate('Products') }} </div>
                <p>{{ translate('Manage & organize your inventory and products') }}</p>
                <a href="{{ route('ev-products.index') }}" class="btn btn-soft-primary">{{ translate('Manage Products')
                    }}</a>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="row">
        <div class="col-6">
            <x-default.dashboard.widgets.integration-stats-widget url="{{ route('ev-products.create') }}"
                title="Add A Product"
                img="https://cdns.iconmonstr.com/wp-content/assets/preview/2019/240/iconmonstr-product-3.png">
                {{ translate('Create a new product') }}
            </x-default.dashboard.widgets.integration-stats-widget>
        </div>

        <div class="col-6">
            <x-default.dashboard.widgets.integration-stats-widget url="{{ route('blog.posts.index') }}" title="Post an update"
                img="https://banner2.cleanpng.com/20190914/tca/transparent-market-icon-news-icon-newspaper-icon-5d7ce8e6009aa0.6164315815684671740025.jpg">
                {{ translate('Share an update with your followers and customers') }}
            </x-default.dashboard.widgets.integration-stats-widget>
        </div>
    </div>
</section>
<section>
    <div class="row">
        <div class="col-12 col-sm-6">
            <x-default.dashboard.widgets.integration-stats-widget url="{{ route('analytics.index') }}" title="Website Analytics"
                img="https://developers.google.com/analytics/images/terms/logo_lockup_analytics_icon_vertical_black_2x.png?hl=ar">
                {{ translate('Track your website statictics') }}

            </x-default.dashboard.widgets.integration-stats-widget>
        </div>

        <div class="col-12 col-sm-6">

        </div>
    </div>
</section>

<section class="stats mb-3">
    <div class="row">
        <div class="col-12">

            <x-default.dashboard.dashboard-summary.admin>
            </x-default.dashboard.dashboard-summary.admin>
        </div>
        <div class="col-12 col-sm-6">
            <div class="row">
                <div class="col-12">
                    <x-default.dashboard.widgets.integrations-widget>

                    </x-default.dashboard.widgets.integrations-widget>
                </div>
            </div>
        </div>
    </div>

</section>

<section>
    <x-default.products.recently-viewed-products></x-default.products.recently-viewed-products>
</section>
@endsection
