@extends('frontend.layouts.user_panel')

@section('panel_content')

    <div class="bg-white">
        <x-free-member-notification> </x-free-member-notification>
    </div>
    <section>
        <div class="row">
            <div class="col-12">
                <h5>{{ translate('Setup your store') }} </h5>
                <x-default.dashboard.widgets.onboarding-widget></x-default.dashboard.widgets.onboarding-widget>
            </div>
        </div>
    </section>
    <section>
        <div class="row">
            <div class="col-6">
                <x-default.dashboard.widgets.integration-stats-widget url="#" title="Google Analytics"
                    img="https://developers.google.com/analytics/images/terms/logo_lockup_analytics_icon_vertical_black_2x.png?hl=ar">
                </x-default.dashboard.widgets.integration-stats-widget>
            </div>

            <div class="col-6">
                <x-default.dashboard.widgets.integration-stats-widget url="#" title="Mailchimp"
                    img="https://www.drupal.org/files/project-images/MC_Logo.jpg">
                </x-default.dashboard.widgets.integration-stats-widget>
            </div>
        </div>
    </section>

    <section class="stats mb-3">
        <div class="row">
            <div class="col-6">
                <div class="row">
                    <div class="col-12 mb-3">
                        <x-default.dashboard.widgets.leads-widget>

                            <a href="{{ route('leads.index') }}">
                                {{ translate('View all') }}
                            </a>

                        </x-default.dashboard.widgets.leads-widget>

                    </div>

                    <div class="col-12 mb-3">
                        <x-default.dashboard.widgets.orders-widget>
                            <a href="{{ route('orders.index') }}">
                                {{ translate('View all') }}
                            </a>
                        </x-default.dashboard.widgets.orders-widget>
                    </div>

                    <div class="col-12 mb-3">
                        <x-default.dashboard.widgets.products-widget>
                            <a href="{{ route('ev-products.index') }}">
                                {{ translate('View all') }}
                            </a>
                        </x-default.dashboard.widgets.products-widget>
                    </div>

                </div>

            </div>
            <div class="col-6">
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
        <div class="row">
            <div class="col-sm-6">
            </div>
        </div>
    </section>

    <x-default.dashboard.dashboard-summary.admin>
    </x-default.dashboard.dashboard-summary.admin>

    <div class="row">
        <div class="col-md-6">
            <div class="card bg-white p-4 text-center">
                {{-- TODO : make this company name dynamic --}}
                <div class="h5 fw-600">{{ translate('Products') }} </div>
                <p>{{ translate('Manage & organize your inventory and products') }}</p>
                <a href="{{ route('ev-products.index') }}"
                    class="btn btn-soft-primary">{{ translate('Manage Products') }}</a>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card bg-white p-4 text-center">
                {{-- TODO : make this company name dynamic --}}
                <div class="h5 fw-600">{{ translate('Your Website Admin Panel') }} </div>
                <p>{{ translate('Manage & organize your website settings') }}</p>
                <a href="/admin" class="btn btn-soft-primary">{{ translate('Manage your website') }}</a>
            </div>
        </div>

        <div class="col-md-6">
            {{-- <x-company.company-onboarding-wizard></x-company.company-onboarding-wizard> --}}
        </div>

        <div class="col-sm-6">

            <!-- Body -->
            <!-- End Body -->
        </div>
    </div>



@endsection
